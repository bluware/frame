<?php

return [
    /**------------------------------------------------------------------------
     *  @package `json` module
     */
     'Frame\\JSON'
         => __DIR__ . "/json/JSON.php",
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
     'Frame\\UriAbstract'
         => __DIR__ . "/uri/UriAbstract.php",
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
     *  @package `database` module
     */
     'Frame\\Database\\Query\\Where'
         => __DIR__ . "/database/Database/Query/Where.php",
     'Frame\\Database\\Query'
         => __DIR__ . "/database/Database/Query.php",
    //-------------------------------------------------------------------------
];
