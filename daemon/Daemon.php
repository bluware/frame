<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

class Daemon extends Entry
{
    protected $name;

    protected $time = 1000000;

    protected $live = false;

    protected $pid;

    protected $pid_file;

    protected $pid_fd;

    protected $calle;

    public function __construct(App $app)
    {
        if ($app->locator('request')->is('cli') === false) {
            throw new \Exception('Daemon can be executed only in cli scope.');
        }
        parent::__construct($app);

        $this->pid = getmypid();

        pcntl_signal(SIGTERM, [$this, 'sig_handler']);
        pcntl_signal(SIGHUP, [$this, 'sig_handler']);
        pcntl_signal(SIGUSR1, [$this, 'sig_handler']);
    }

    public function name($name)
    {
        $this->name = $name;

        $success = cli_set_process_title(
            sprintf('Bluware.Daemon %s', $name)
        );

        if ($success === false) {
            echo "! Process name cannot be setted\n";
        }

        return $this;
    }

    public function time($seconds)
    {
        $this->time = $seconds * 1000000;

        return $this;
    }

    public function utime($seconds)
    {
        $this->time = $seconds;

        return $this;
    }

    public function pid()
    {
        return $this->pid;
    }

    public function pid_file($file = null)
    {
        if ($this->live === true) {
            throw new \Exception('PID file cannot be changes when daemon is working.');
        }
        $this->pid_file = $file;

        return $this;
    }

    public function start(callable $calle = null)
    {
        if ($calle === null && $this->calle === null) {
            throw new \Exception("Daemon can't be start without handler function.");
        }
        if ($calle !== null) {
            $this->calle = $calle;
        }

        if ($this->pid_file !== null) {
            $this->pid_fd = fopen($this->pid_file, 'c');
            $lock = flock($this->pid_fd, LOCK_EX | LOCK_NB, $block);

            if ($this->pid_fd === false || (!$lock && !$block)) {
                throw new \Exception(
                    'Unexpected error opening or locking lock file. Perhaps you '.
                    "don't  have permission to write to the lock file or its ".
                    'containing directory?'
                );
            } elseif (!$lock && $block) {
                exit("Another instance is already running; terminating.\n");
            }

            ftruncate($this->pid_fd, 0);
            fwrite($this->pid_fd, sprintf("%s\n", $this->pid));
        }

        $this->live = true;

        try {
            while ($this->live) {
                call_user_func($this->calle, $this);

                usleep($this->time);
            }
        } catch (\Exception $e) {
            $this->stop();

            throw $e;
        }

        return 1;
    }

    protected function sig_handler($signal)
    {
        switch ($signal) {
            case SIGTERM:
                $this->stop();
                exit;
                break;

            case SIGHUP:
                $this->restart();
                break;

            case SIGUSR1:
                //echo "Caught SIGUSR1...\n";
                break;
            default:
                // handle all other signals
        }
    }

    public function restart(callable $calle = null)
    {
        return $this->stop()->start($calle);
    }

    public function stop()
    {
        $this->live = 0;

        if ($this->pid_file !== null) {
            ftruncate($this->pid_fd, 0);
            flock($this->pid_fd, LOCK_UN);
        }

        return $this;
    }
}
