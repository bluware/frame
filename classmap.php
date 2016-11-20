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
     *  @package `secure` module
     */
     'Frame\\Secure\\Keychain'
         => __DIR__ . "/secure/Secure/Keychain.php",
     'Frame\\SecureInterface'
         => __DIR__ . "/secure/SecureInterface.php",
     'Frame\\Secure'
         => __DIR__ . "/secure/Secure.php",
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
         => __DIR__ . "/rest/Client/Headers.php",
     'Frame\\Rest\\Client\\Response'
         => __DIR__ . "/rest/Client/Response.php",
     'Frame\\Rest\\ClientAbstract'
         => __DIR__ . "/rest/ClientAbstract.php",
     'Frame\\Rest\\Client'
         => __DIR__ . "/rest/Client.php",
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
     *  @package `response` module
     */
     'Frame\\Response\\Headers'
         => __DIR__ . "/response/Response/Headers.php",
     'Frame\\ResponseInterface'
         => __DIR__ . "/response/ResponseInterface.php",
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
     'Frame\\RequestInterface'
         => __DIR__ . "/request/RequestInterface.php",
     'Frame\\Request'
         => __DIR__ . "/request/Request.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `http` module
     */
     'Frame\\HttpInterface'
         => __DIR__ . "/http/HttpInterface.php",
     'Frame\\Http'
         => __DIR__ . "/http/Http.php",
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
     'Frame\\AspectInterface'
         => __DIR__ . "/aspect/AspectInterface.php",
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
     'Frame\\Active\\Query'
         => __DIR__ . "/active/Query.php",
     'Frame\\Active\\Record'
         => __DIR__ . "/active/Record.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `service` module
     */
     'Frame\\Service\\Autoload'
         => __DIR__ . "/service/Autoload.php",
     'Frame\\Service\\Locator'
         => __DIR__ . "/service/Locator.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `package` module
     */
     'Frame\\Package'
         => __DIR__ . "/package/Package.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `package` module
     */
     'Frame\\App'
         => __DIR__ . "/app/App.php",
    //-------------------------------------------------------------------------
];
