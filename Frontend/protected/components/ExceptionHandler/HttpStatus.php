<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-12-22
 * Time: 11:28am
 */

class HttpStatus
{
    const STATUS_100=100;
    const STATUS_101=101;
    const STATUS_102=102;
    const STATUS_200=200;
    const STATUS_201=201;
    const STATUS_202=202;
    const STATUS_203=203;
    const STATUS_204=204;
    const STATUS_205=205;
    const STATUS_206=206;
    const STATUS_207=207;
    const STATUS_300=300;
    const STATUS_301=301;
    const STATUS_302=302;
    const STATUS_303=303;
    const STATUS_304=304;
    const STATUS_305=305;
    const STATUS_306=306;
    const STATUS_307=307;
    const STATUS_400=400;
    const STATUS_401=401;
    const STATUS_402=402;
    const STATUS_403=403;
    const STATUS_404=404;
    const STATUS_405=405;
    const STATUS_406=406;
    const STATUS_407=407;
    const STATUS_408=408;
    const STATUS_409=409;
    const STATUS_410=410;
    const STATUS_411=411;
    const STATUS_412=412;
    const STATUS_413=413;
    const STATUS_414=414;
    const STATUS_415=415;
    const STATUS_416=416;
    const STATUS_417=417;
    const STATUS_421=421;
    const STATUS_422=422;
    const STATUS_423=423;
    const STATUS_424=424;
    const STATUS_425=425;
    const STATUS_426=426;
    const STATUS_449=449;
    const STATUS_500=500;
    const STATUS_501=501;
    const STATUS_502=502;
    const STATUS_503=503;
    const STATUS_504=504;
    const STATUS_505=505;
    const STATUS_506=506;
    const STATUS_507=507;
    const STATUS_509=509;
    const STATUS_510=510;
    const STATUS_600=600;

    public static function getHttpStatusOption()
    {
        return array(
            self::STATUS_100=>"Continue",
            self::STATUS_101=>"Switching Protocols",
            self::STATUS_102=>"Processing",
            self::STATUS_200=>"OK",
            self::STATUS_201=>"Created",
            self::STATUS_202=>"Accepted",
            self::STATUS_203=>"Non-Authoritative Information",
            self::STATUS_204=>"No Content",
            self::STATUS_205=>"Reset Content",
            self::STATUS_206=>"Partial Content",
            self::STATUS_207=>"Multi-Status",
            self::STATUS_300=>"Multiple Choices",
            self::STATUS_301=>"Moved Permanently",
            self::STATUS_302=>"Move temporarily",
            self::STATUS_303=>"See Other",
            self::STATUS_304=>"Not Modified",
            self::STATUS_305=>"Use Proxy",
            self::STATUS_306=>"Switch Proxy",
            self::STATUS_307=>"Temporary Redirect",
            self::STATUS_400=>"Bad Request",
            self::STATUS_401=>"Unauthorized",
            self::STATUS_402=>"Payment Required",
            self::STATUS_403=>"Forbidden",
            self::STATUS_404=>"Not Found",
            self::STATUS_405=>"Method Not Allowed",
            self::STATUS_406=>"Not Acceptable",
            self::STATUS_407=>"Proxy Authentication Required",
            self::STATUS_408=>"Request Timeout",
            self::STATUS_409=>"Conflict",
            self::STATUS_410=>"Gone",
            self::STATUS_411=>"Length Required",
            self::STATUS_412=>"Precondition Failed",
            self::STATUS_413=>"Request Entity Too Large",
            self::STATUS_414=>"Request-URI Too Long",
            self::STATUS_415=>"Unsupported Media Type",
            self::STATUS_416=>"Requested Range Not Satisfiable",
            self::STATUS_417=>"Expectation Failed",
            self::STATUS_421=>"There are too many connections from your internet address",
            self::STATUS_422=>"Unprocessable Entity",
            self::STATUS_423=>"Locked",
            self::STATUS_424=>"Failed Dependency",
            self::STATUS_425=>"Unordered Collection",
            self::STATUS_426=>"Upgrade Required",
            self::STATUS_449=>"Retry With",
            self::STATUS_500=>"Internal Server Error",
            self::STATUS_501=>"Not Implemented",
            self::STATUS_502=>"Bad Gateway",
            self::STATUS_503=>"Service Unavailable",
            self::STATUS_504=>"Gateway Timeout",
            self::STATUS_505=>"HTTP Version Not Supported",
            self::STATUS_506=>"Variant Also Negotiates",
            self::STATUS_507=>"Insufficient Storage",
            self::STATUS_509=>"Bandwidth Limit Exceeded",
            self::STATUS_510=>"Not Extended",
            self::STATUS_600=>"Unparseable Response Headers",
        );
    }

    public static function getHttpStatusText($statusCode)
    {
        $statusCodes = self::getHttpStatusOption();
        return isset($statusCodes[$statusCode]) ? $statusCodes[$statusCode] : "Unknown Status Code: ($statusCode)";
    }
} 