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
     'Frame\\Http\\CookieInterface'
         => __DIR__ . "/http-cookie/CookieInterface.php",
     'Frame\\Http\\Cookie'
         => __DIR__ . "/http-cookie/Cookie.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `response` module
     */
     'Frame\\Http\\Response\\Headers'
         => __DIR__ . "/http-response/Response/Headers.php",
     'Frame\\Http\\ResponseInterface'
         => __DIR__ . "/http-response/ResponseInterface.php",
     'Frame\\Http\\Response'
         => __DIR__ . "/http-response/Response.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `request` module
     */
     'Frame\\Http\\Request\\Body'
         => __DIR__ . "/http-request/Request/Body.php",
     'Frame\\Http\\Request\\Cookies'
         => __DIR__ . "/http-request/Request/Cookies.php",
     'Frame\\Http\\Request\\Files'
         => __DIR__ . "/http-request/Request/Files.php",
     'Frame\\Http\\Request\\Query'
         => __DIR__ . "/http-request/Request/Query.php",
     'Frame\\Http\\Request\\Server'
         => __DIR__ . "/http-request/Request/Server.php",
     'Frame\\Http\\RequestInterface'
         => __DIR__ . "/http-request/RequestInterface.php",
     'Frame\\Http\\Request'
         => __DIR__ . "/http-request/Request.php",
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
     'Frame\\ActiveRecord\\Query'
         => __DIR__ . "/active-record/ActiveRecord/Query.php",
     'Frame\\ActiveRecord'
         => __DIR__ . "/active-record/ActiveRecord.php",
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
