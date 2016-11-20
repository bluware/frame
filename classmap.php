<?php

return [
    /**------------------------------------------------------------------------
     *  @package `json` module
     */
     'Frame\\Json'
         => __DIR__ . "/json/Json.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `facade` module
     */
     'Frame\\Facade'
         => __DIR__ . "/facade/Facade.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `data` module
     */
     'Frame\\Data\\Readable'
         => __DIR__ . "/data/Data/Readable.php",
     'Frame\\Data\\Writable'
         => __DIR__ . "/data/Data/Writable.php",
     'Frame\\Data'
         => __DIR__ . "/data/Data.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `uri` module
     */
     'Frame\\Uri\\Query'
         => __DIR__ . "/uri/Uri/Query.php",
     'Frame\\Uri'
         => __DIR__ . "/uri/Uri.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `client` module
     */
     'Frame\\Rest\\Client\\Headers'
         => __DIR__ . "/rest/Rest/Client/Headers.php",
     'Frame\\Rest\\Client\\Response'
         => __DIR__ . "/rest/Rest/Client/Response.php",
     'Frame\\Rest\\ClientAbstract'
         => __DIR__ . "/rest/Rest/ClientAbstract.php",
     'Frame\\Rest\\Client'
         => __DIR__ . "/rest/Rest/Client.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `cookie` module
     */
     'Frame\\CookieInterface'
         => __DIR__ . "/cookie/CookieInterface.php",
     'Frame\\Cookie'
         => __DIR__ . "/cookie/Cookie.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `request` module
     */
     'Frame\\Request\\Body'
         => __DIR__ . "/request/Request/Body.php",
     'Frame\\Request\\Cookies'
         => __DIR__ . "/request/Request/Cookies.php",
     'Frame\\Request\\Files'
         => __DIR__ . "/request/Request/Files.php",
     'Frame\\Request\\Query'
         => __DIR__ . "/request/Request/Query.php",
     'Frame\\Request\\Server'
         => __DIR__ . "/request/Request/Server.php",
     'Frame\\RequestInterface'
         => __DIR__ . "/request/RequestInterface.php",
     'Frame\\Request'
         => __DIR__ . "/request/Request.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `database` module
     */
     'Frame\\Database\\Drive'
         => __DIR__ . "/database/Database/Drive.php",
     'Frame\\Database\\Drive\\MySQL'
         => __DIR__ . "/database/Database/Drive/MySQL.php",
     'Frame\\Database\\Drive\\PgSQL'
         => __DIR__ . "/database/Database/Drive/PgSQL.php",
     'Frame\\Database\\Drive\\SQLite'
         => __DIR__ . "/database/Database/Drive/SQLite.php",
     'Frame\\Database\\Query\\Where'
         => __DIR__ . "/database/Database/Query/Where.php",
     'Frame\\Database\\Query'
         => __DIR__ . "/database/Database/Query.php",
     'Frame\\Database\\State'
         => __DIR__ . "/database/Database/State.php",
     'Frame\\Database\\Union'
         => __DIR__ . "/database/Database/Union.php",
     'Frame\\Database'
         => __DIR__ . "/database/Database.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `database` module
     */
     'Frame\\Active\\Query'
         => __DIR__ . "/active/Active/Query.php",
     'Frame\\Active\\Record'
         => __DIR__ . "/active/Active/Record.php",
    //-------------------------------------------------------------------------
];
