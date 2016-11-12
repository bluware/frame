<?php

return [
    /**------------------------------------------------------------------------
     *  @package `json` package
     */
     'Blu\\JSON'
         => __DIR__ . "/json/JSON.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `essence` package
     */
     'Blu\\Essence\\ReadableAbstract'
         => __DIR__ . "/essence/Essence/ReadableAbstract.php",
     'Blu\\Essence\\Readable'
         => __DIR__ . "/essence/Essence/Readable.php",
     'Blu\\Essence\\WriteableAbstract'
         => __DIR__ . "/essence/Essence/WriteableAbstract.php",
     'Blu\\Essence\\Writeable'
         => __DIR__ . "/essence/Essence/Writeable.php",
     'Blu\\EssenceInterface'
         => __DIR__ . "/essence/EssenceInterface.php",
     'Blu\\Essence'
         => __DIR__ . "/essence/Essence.php",
    //-------------------------------------------------------------------------


    /**------------------------------------------------------------------------
     *  @package `secure` package
     */
    "Blu\\Secure\\Keychain"
        => __DIR__ . "/secure/Secure/Keychain.php",
    "Blu\\SecureInterface"
        => __DIR__ . "/secure/SecureInterface.php",
    "Blu\\Secure"
        => __DIR__ . "/secure/Secure.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `http` package
     */
    "Blu\\Http\\URI\\Query"
        => __DIR__ . "/http/Http/URI/Query.php",
    "Blu\\Http\\URIInterface"
        => __DIR__ . "/http/Http/URIInterface.php",
    "Blu\\Http\\URIAbstract"
        => __DIR__ . "/http/Http/URIAbstract.php",
    "Blu\\Http\\URI"
        => __DIR__ . "/http/Http/URI.php",
    "Blu\\Http\\Exception"
        => __DIR__ . "/http/Http/Exception.php",
    "Blu\\HttpInterface"
        => __DIR__ . "/http/HttpInterface.php",
    "Blu\\Http"
        => __DIR__ . "/http/Http.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `http-cookie` package
     */
    "Blu\\Http\\Cookie\\Hash"
        => __DIR__ . "/http-cookie/Cookie/Hash.php",
    "Blu\\Http\\CookieInterface"
        => __DIR__ . "/http-cookie/CookieInterface.php",
    "Blu\\Http\\CookieAbstract"
        => __DIR__ . "/http-cookie/CookieAbstract.php",
    "Blu\\Http\\Cookie"
        => __DIR__ . "/http-cookie/Cookie.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `http-client` package
     */
    "Blu\\Http\\Client\\Headers"
        => __DIR__ . "/http-client/Client/Headers.php",
    "Blu\\Http\\Client\\Response"
        => __DIR__ . "/http-client/Client/Response.php",
    "Blu\\Http\\ClientInterface"
        => __DIR__ . "/http-client/ClientInterface.php",
    "Blu\\Http\\ClientAbstract"
        => __DIR__ . "/http-client/ClientAbstract.php",
    "Blu\\Http\\Client"
        => __DIR__ . "/http-client/Client.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `http-request` package
     */
    "Blu\\Http\\Request\\Query"
        => __DIR__ . "/http-request/Request/Query.php",
    "Blu\\Http\\Request\\Body"
        => __DIR__ . "/http-request/Request/Body.php",
    "Blu\\Http\\Request\\Files"
        => __DIR__ . "/http-request/Request/Files.php",
    "Blu\\Http\\Request\\Cookies"
        => __DIR__ . "/http-request/Request/Cookies.php",
    "Blu\\Http\\Request\\Server"
        => __DIR__ . "/http-request/Request/Server.php",
    "Blu\\Http\\RequestInterface"
        => __DIR__ . "/http-request/RequestInterface.php",
    "Blu\\Http\\RequestAbstract"
        => __DIR__ . "/http-request/RequestAbstract.php",
    "Blu\\Http\\Request"
        => __DIR__ . "/http-request/Request.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `http-response` package
     */
    "Blu\\Http\\Response\\Headers"
        => __DIR__ . "/http-response/Response/Headers.php",
    "Blu\\Http\\ResponseAbstract"
        => __DIR__ . "/http-response/ResponseAbstract.php",
    "Blu\\Http\\Response"
        => __DIR__ . "/http-response/Response.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `http-router` package
     */
    "Blu\\Http\\Router\\Controllers"
        => __DIR__ . "/http-router/Router/Controllers.php",
    "Blu\\Http\\Router\\Groups"
        => __DIR__ . "/http-router/Router/Groups.php",
    "Blu\\Http\\Router\\Guardians"
        => __DIR__ . "/http-router/Router/Guardians.php",
    "Blu\\Http\\Router\\Routes"
        => __DIR__ . "/http-router/Router/Routes.php",
    "Blu\\Http\\RouterAbstract"
        => __DIR__ . "/http-router/RouterAbstract.php",
    "Blu\\Http\\Router"
        => __DIR__ . "/http-router/Router.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `http-controller` package
     */
     "Blu\\Http\\ControllerAbstract"
         => __DIR__ . "/http-controller/ControllerAbstract.php",
     "Blu\\Http\\Controller"
         => __DIR__ . "/http-controller/Controller.php",
    //-------------------------------------------------------------------------

    /**------------------------------------------------------------------------
     *  @package `http-aspect` package
     */
     "Blu\\Http\\AspectAbstract"
         => __DIR__ . "/http-aspect/AspectAbstract.php",
     "Blu\\Http\\Guardian"
         => __DIR__ . "/http-aspect/Aspect.php",
    //-------------------------------------------------------------------------
];
