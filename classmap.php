<?php

return [
    /**------------------------------------------------------------------------
     *  @package `json` module
     */
     'Blu\\JSON'
         => __DIR__ . "/json/JSON.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `data` module
     */
     'Blu\\Data\\ReadableAbstract'
         => __DIR__ . "/data/Data/ReadableAbstract.php",
     'Blu\\Data\\Readable'
         => __DIR__ . "/data/Data/Readable.php",
     'Blu\\Data\\WriteableAbstract'
         => __DIR__ . "/data/Data/WriteableAbstract.php",
     'Blu\\Data\\Writeable'
         => __DIR__ . "/data/Data/Writeable.php",
    //-------------------------------------------------------------------------


    /**------------------------------------------------------------------------
     *  @package `secure` module
     */
    "Blu\\Secure\\Keychain"
        => __DIR__ . "/secure/Secure/Keychain.php",
    "Blu\\SecureInterface"
        => __DIR__ . "/secure/SecureInterface.php",
    "Blu\\Secure"
        => __DIR__ . "/secure/Secure.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `http` module
     */
    "Blu\\Http\\Exception"
        => __DIR__ . "/http/Http/Exception.php",
    "Blu\\HttpInterface"
        => __DIR__ . "/http/HttpInterface.php",
    "Blu\\Http"
        => __DIR__ . "/http/Http.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `cookie` module
     */
    "Blu\\CookieInterface"
        => __DIR__ . "/cookie/CookieInterface.php",
    "Blu\\CookieAbstract"
        => __DIR__ . "/cookie/CookieAbstract.php",
    "Blu\\Cookie"
        => __DIR__ . "/cookie/Cookie.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `uri` module
     */
     "Blu\\Uri\\Query"
         => __DIR__ . "/uri/Uri/Query.php",
     "Blu\\UriInterface"
         => __DIR__ . "/uri/UriInterface.php",
     "Blu\\UriAbstract"
         => __DIR__ . "/uri/UriAbstract.php",
     "Blu\\Uri"
         => __DIR__ . "/uri/Uri.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `client` module
     */
    "Blu\\Client\\Headers"
        => __DIR__ . "/client/Client/Headers.php",
    "Blu\\Client\\Response"
        => __DIR__ . "/client/Client/Response.php",
    "Blu\\ClientInterface"
        => __DIR__ . "/client/ClientInterface.php",
    "Blu\\ClientAbstract"
        => __DIR__ . "/client/ClientAbstract.php",
    "Blu\\Client"
        => __DIR__ . "/client/Client.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `request` module
     */
    "Blu\\Request\\Query"
        => __DIR__ . "/request/Request/Query.php",
    "Blu\\Request\\Body"
        => __DIR__ . "/request/Request/Body.php",
    "Blu\\Request\\Files"
        => __DIR__ . "/request/Request/Files.php",
    "Blu\\Request\\Cookies"
        => __DIR__ . "/request/Request/Cookies.php",
    "Blu\\Request\\Server"
        => __DIR__ . "/request/Request/Server.php",
    "Blu\\RequestInterface"
        => __DIR__ . "/request/RequestInterface.php",
    "Blu\\RequestAbstract"
        => __DIR__ . "/request/RequestAbstract.php",
    "Blu\\Request"
        => __DIR__ . "/request/Request.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `response` module
     */
    "Blu\\Response\\Headers"
        => __DIR__ . "/response/Response/Headers.php",
    "Blu\\ResponseInterface"
        => __DIR__ . "/response/ResponseInterface.php",
    "Blu\\ResponseAbstract"
        => __DIR__ . "/response/ResponseAbstract.php",
    "Blu\\Response"
        => __DIR__ . "/response/Response.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `router` module
     */
    "Blu\\Router\\Routes\\Route"
        => __DIR__ . "/router/Router/Routes/Route.php",
    "Blu\\Router\\Groups"
        => __DIR__ . "/router/Router/Groups.php",
    "Blu\\Router\\Aspects"
        => __DIR__ . "/router/Router/Aspects.php",
    "Blu\\Router\\Invokes"
        => __DIR__ . "/router/Router/Invokes.php",
    "Blu\\Router\\Routes"
        => __DIR__ . "/router/Router/Routes.php",
    "Blu\\RouterAbstract"
        => __DIR__ . "/router/RouterAbstract.php",
    "Blu\\Router"
        => __DIR__ . "/router/Router.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `controller` module
     */
     "Blu\\Controller\\DispatcherInterface"
         => __DIR__ . "/controller/Controller/DispatcherInterface.php",
     "Blu\\Controller\\Dispatcher"
         => __DIR__ . "/controller/Controller/Dispatcher.php",
     "Blu\\Controller"
         => __DIR__ . "/controller/Controller.php",
     "Blu\\ControllerInterface"
         => __DIR__ . "/controller/ControllerInterface.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `service` module
     */
     "Blu\\Service\\AutoloadAbstract"
         => __DIR__ . "/service/Service/AutoloadAbstract.php",
     "Blu\\Service\\Autoload"
         => __DIR__ . "/service/Service/Autoload.php",
     "Blu\\Service\\LocatorAbstract"
         => __DIR__ . "/service/Service/LocatorAbstract.php",
     "Blu\\Service\\Locator"
         => __DIR__ . "/service/Service/Locator.php",
     "Blu\\Service"
         => __DIR__ . "/service/Service.php",
     "Blu\\ServiceInterface"
         => __DIR__ . "/service/ServiceInterface.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `package` module
     */
     "Blu\\Package"
         => __DIR__ . "/package/Package.php",
     "Blu\\PackageInterface"
         => __DIR__ . "/package/PackageInterface.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `aspect` module
     */
     "Blu\\Aspect"
         => __DIR__ . "/aspect/Aspect.php",
     "Blu\\AspectInterface"
         => __DIR__ . "/aspect/AspectInterface.php",
    //-------------------------------------------------------------------------
];
