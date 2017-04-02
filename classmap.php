<?php

return [
    /**------------------------------------------------------------------------
     *  @package `json` module
     */
    'Frame\\Json\\Exception'
        => __DIR__ . "/data/Json/Exception.php",
    'Frame\\Json'
        => __DIR__ . "/json/Json.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `data` module
     */
    'Frame\\Data\\Exception'
        => __DIR__ . "/data/Data/Exception.php",
    'Frame\\Data\\Readable'
        => __DIR__ . "/data/Data/Readable.php",
    'Frame\\Data\\Writable'
        => __DIR__ . "/data/Data/Writable.php",
    'Frame\\Data'
        => __DIR__ . "/data/Data.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `data` module
     */
    'Frame\\IBit'
        => __DIR__ . "/bit/IBit.php",
    'Frame\\Bit'
        => __DIR__ . "/bit/Bit.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `secure` module
     */
    'Frame\\Secure\\Exception'
        => __DIR__ . "/secure/Secure/Exception.php",
    'Frame\\Secure\\Secret'
        => __DIR__ . "/secure/Secure/Secret.php",
    'Frame\\Secure\\Chain'
        => __DIR__ . "/secure/Secure/Chain.php",
    'Frame\\Secure\\Rsa'
        => __DIR__ . "/secure/Secure/Rsa.php",
    'Frame\\Secure\\Hash'
        => __DIR__ . "/secure/Secure/Hash.php",
    'Frame\\SecureInterface'
        => __DIR__ . "/secure/SecureInterface.php",
    'Frame\\Secure'
        => __DIR__ . "/secure/Secure.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `http-uri` module
     */
    'Frame\\Http\\Uri\\Query'
        => __DIR__ . "/http-uri/Uri/Query.php",
    'Frame\\Http\\Uri'
        => __DIR__ . "/http-uri/Uri.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `client` module
     */
    'Frame\\Http\\Client\\Headers'
        => __DIR__ . "/http-client/Client/Headers.php",
    'Frame\\Http\\Client\\Response'
        => __DIR__ . "/http-client/Client/Response.php",
    'Frame\\Http\\ClientInterface'
        => __DIR__ . "/http-client/ClientInterface.php",
    'Frame\\Http\\Client'
        => __DIR__ . "/http-client/Client.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `cookie` module
     */
    'Frame\\ICookie'
        => __DIR__ . "/cookie/ICookie.php",
    'Frame\\Cookie'
        => __DIR__ . "/cookie/Cookie.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `response` module
     */
    'Frame\\Response\\Headers'
        => __DIR__ . "/response/Response/Headers.php",
    'Frame\\IResponse'
        => __DIR__ . "/response/IResponse.php",
    'Frame\\Response\\Support'
        => __DIR__ . "/response/Response/Support.php",
    'Frame\\Response'
        => __DIR__ . "/response/Response.php",
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
    'Frame\\IRequest'
        => __DIR__ . "/request/IRequest.php",
    'Frame\\Request\\Support'
        => __DIR__ . "/request/Request/Support.php",
    'Frame\\Request'
        => __DIR__ . "/request/Request.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `mediator` module
     */
    'Frame\\Mediator'
        => __DIR__ . "/mediator/Mediator.php",
    'Frame\\Mediator\\Exception'
        => __DIR__ . "/mediator/Mediator/Exception.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `daemon` module
     */
    'Frame\\Daemon\\Exception'
        => __DIR__ . "/daemon/Daemon/Exception.php",
    'Frame\\Daemon'
        => __DIR__ . "/daemon/Daemon.php",
    'Frame\\Daemon\\Worker'
        => __DIR__ . "/daemon/Daemon/Worker.php",
    'Frame\\Daemon\\Support'
        => __DIR__ . "/daemon/Daemon/Support.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `http` module
     */
     'Frame\\I18n'
         => __DIR__ . "/i18n/I18n.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `http` module
     */
     'Frame\\Http\\Exception'
         => __DIR__ . "/http/Http/Exception.php",
    'Frame\\HttpInterface'
        => __DIR__ . "/http/HttpInterface.php",
    'Frame\\Http'
        => __DIR__ . "/http/Http.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `session` module
     */
    'Frame\\Session\\Exception'
        => __DIR__ . "/session/Session/Exception.php",
    'Frame\\SessionInterface'
        => __DIR__ . "/session/SessionInterface.php",
    'Frame\\Session'
        => __DIR__ . "/session/Session.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `router` module
     */
    'Frame\\Routing\\Aspects'
        => __DIR__ . "/routing/Routing/Aspects.php",
    'Frame\\Routing'
        => __DIR__ . "/routing/Routing.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `aspect` module
     */
    'Frame\\View\\PageInterface'
        => __DIR__ . "/view/View/PageInterface.php",
    'Frame\\View\\Page'
        => __DIR__ . "/view/View/Page.php",
    'Frame\\ViewInterface'
        => __DIR__ . "/view/ViewInterface.php",
    'Frame\\View\\Support'
        => __DIR__ . "/view/View/Support.php",
    'Frame\\View'
        => __DIR__ . "/view/View.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `controller` module
     */
    'Frame\\ControllerInterface'
        => __DIR__ . "/controller/ControllerInterface.php",
    'Frame\\Controller'
        => __DIR__ . "/controller/Controller.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `aspect` module
     */
    'Frame\\IAspect'
        => __DIR__ . "/aspect/IAspect.php",
    'Frame\\Aspect'
        => __DIR__ . "/aspect/Aspect.php",
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
    'Frame\\ActiveRecord\\Exception'
        => __DIR__ . "/active-record/ActiveRecord/Exception.php",
    'Frame\\ActiveRecord\\Query'
        => __DIR__ . "/active-record/ActiveRecord/Query.php",
    'Frame\\ActiveRecord'
        => __DIR__ . "/active-record/ActiveRecord.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `autoload` module
     */
    'Frame\\Autoload\\Exception'
        => __DIR__ . "/autoload/Autoload/Exception.php",
    'Frame\\Autoload'
        => __DIR__ . "/autoload/Autoload.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `locator` module
     */
    'Frame\\Locator\\Exception'
        => __DIR__ . "/locator/Locator/Exception.php",
    'Frame\\Locator'
        => __DIR__ . "/locator/Locator.php",
    'Frame\\Locator\\Support'
        => __DIR__ . "/locator/Locator/Support.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `hook` module
     */
    'Frame\\Hook\\Exception'
        => __DIR__ . "/hook/Hook/Exception.php",
    'Frame\\Hook'
        => __DIR__ . "/hook/Hook.php",
    'Frame\\Hook\\Support'
        => __DIR__ . "/hook/Hook/Support.php",
    'Frame\\Hook\\Controller'
        => __DIR__ . "/hook/Hook/Controller.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `hook` module
     */
    'Frame\\Mail'
        => __DIR__ . "/mail/Mail.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `form` module
     */
    'Frame\\Form\\Exception'
        => __DIR__ . "/form/Form/Exception.php",
    'Frame\\Form\\Filter'
        => __DIR__ . "/form/Form/Filter.php",
    'Frame\\Form\\Input'
        => __DIR__ . "/form/Form/Input.php",
    'Frame\\FormInterface'
        => __DIR__ . "/form/FormInterface.php",
    'Frame\\Form'
        => __DIR__ . "/form/Form.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `package` module
     */
    'Frame\\Package\\Exception'
        => __DIR__ . "/package/Package/Exception.php",
    'Frame\\Package\\Dispatcher'
        => __DIR__ . "/package/Package/Dispatcher.php",
    'Frame\\Package'
        => __DIR__ . "/package/Package.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `package` module
     */
    'Frame\\Paging\\Exception'
        => __DIR__ . "/paging/Paging/Exception.php",
    'Frame\\Paging'
        => __DIR__ . "/paging/Paging.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `image` module
     */
    'Frame\\Image\\Exception'
        => __DIR__ . "/image/Image/Exception.php",
    'Frame\\Image'
        => __DIR__ . "/image/Image.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `file` module
     */
    'Frame\\Dir\\Exception'
        => __DIR__ . "/dir/Dir/Exception.php",
    'Frame\\Dir'
        => __DIR__ . "/dir/Dir.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `file` module
     */
    'Frame\\File\\Exception'
        => __DIR__ . "/file/File/Exception.php",
    'Frame\\File\\Util'
        => __DIR__ . "/file/File/Util.php",
    'Frame\\File\\Data'
        => __DIR__ . "/file/File/Data.php",
    'Frame\\File'
        => __DIR__ . "/file/File.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `redis` module
     */
    'Frame\\Redis\\Exception'
        => __DIR__ . "/redis/Redis/Exception.php",
    'Frame\\RedisInterface'
        => __DIR__ . "/redis/RedisInterface.php",
    'Frame\\Redis'
        => __DIR__ . "/redis/Redis.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `package` module
     */
    'Frame\\App\\Exception'
        => __DIR__ . "/app/App/Exception.php",
    'Frame\\App'
        => __DIR__ . "/app/App.php",
    'Frame\\Node'
        => __DIR__ . "/app/Node.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `xml` module
     */
    'Frame\\Xml'
        => __DIR__ . "/xml/Xml.php",
    //-------------------------------------------------------------------------
];
