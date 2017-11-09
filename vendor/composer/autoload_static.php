<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8e5a0519c11ee2238c3cacbd67dfd583
{
    public static $files = array (
        'a274048505ae3446b0c9023cd348b689' => __DIR__ . '/../..' . '/app/Includes/Bootstrap.php',
        '6d96a91cd94589cae5577de54b51d068' => __DIR__ . '/../..' . '/app/Includes/Functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Spring_App\\' => 11,
            'Slim\\Views\\' => 11,
        ),
        'C' => 
        array (
            'Curl\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Spring_App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
        'Slim\\Views\\' => 
        array (
            0 => __DIR__ . '/..' . '/slim/views',
        ),
        'Curl\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-curl-class/php-curl-class/src/Curl',
        ),
    );

    public static $prefixesPsr0 = array (
        'S' => 
        array (
            'Slim' => 
            array (
                0 => __DIR__ . '/..' . '/slim/slim',
            ),
        ),
    );

    public static $classMap = array (
        'Curl\\ArrayUtil' => __DIR__ . '/..' . '/php-curl-class/php-curl-class/src/Curl/ArrayUtil.php',
        'Curl\\CaseInsensitiveArray' => __DIR__ . '/..' . '/php-curl-class/php-curl-class/src/Curl/CaseInsensitiveArray.php',
        'Curl\\Curl' => __DIR__ . '/..' . '/php-curl-class/php-curl-class/src/Curl/Curl.php',
        'Curl\\Decoder' => __DIR__ . '/..' . '/php-curl-class/php-curl-class/src/Curl/Decoder.php',
        'Curl\\MultiCurl' => __DIR__ . '/..' . '/php-curl-class/php-curl-class/src/Curl/MultiCurl.php',
        'SlimFlashTest' => __DIR__ . '/..' . '/slim/slim/tests/Middleware/FlashTest.php',
        'SlimHttpUtilTest' => __DIR__ . '/..' . '/slim/slim/tests/Http/UtilTest.php',
        'SlimTest' => __DIR__ . '/..' . '/slim/slim/tests/SlimTest.php',
        'Slim\\Environment' => __DIR__ . '/..' . '/slim/slim/Slim/Environment.php',
        'Slim\\Exception\\Pass' => __DIR__ . '/..' . '/slim/slim/Slim/Exception/Pass.php',
        'Slim\\Exception\\Stop' => __DIR__ . '/..' . '/slim/slim/Slim/Exception/Stop.php',
        'Slim\\Helper\\Set' => __DIR__ . '/..' . '/slim/slim/Slim/Helper/Set.php',
        'Slim\\Http\\Cookies' => __DIR__ . '/..' . '/slim/slim/Slim/Http/Cookies.php',
        'Slim\\Http\\Headers' => __DIR__ . '/..' . '/slim/slim/Slim/Http/Headers.php',
        'Slim\\Http\\Request' => __DIR__ . '/..' . '/slim/slim/Slim/Http/Request.php',
        'Slim\\Http\\Response' => __DIR__ . '/..' . '/slim/slim/Slim/Http/Response.php',
        'Slim\\Http\\Util' => __DIR__ . '/..' . '/slim/slim/Slim/Http/Util.php',
        'Slim\\Log' => __DIR__ . '/..' . '/slim/slim/Slim/Log.php',
        'Slim\\LogWriter' => __DIR__ . '/..' . '/slim/slim/Slim/LogWriter.php',
        'Slim\\Middleware' => __DIR__ . '/..' . '/slim/slim/Slim/Middleware.php',
        'Slim\\Middleware\\ContentTypes' => __DIR__ . '/..' . '/slim/slim/Slim/Middleware/ContentTypes.php',
        'Slim\\Middleware\\Flash' => __DIR__ . '/..' . '/slim/slim/Slim/Middleware/Flash.php',
        'Slim\\Middleware\\MethodOverride' => __DIR__ . '/..' . '/slim/slim/Slim/Middleware/MethodOverride.php',
        'Slim\\Middleware\\PrettyExceptions' => __DIR__ . '/..' . '/slim/slim/Slim/Middleware/PrettyExceptions.php',
        'Slim\\Middleware\\SessionCookie' => __DIR__ . '/..' . '/slim/slim/Slim/Middleware/SessionCookie.php',
        'Slim\\Route' => __DIR__ . '/..' . '/slim/slim/Slim/Route.php',
        'Slim\\Router' => __DIR__ . '/..' . '/slim/slim/Slim/Router.php',
        'Slim\\Slim' => __DIR__ . '/..' . '/slim/slim/Slim/Slim.php',
        'Slim\\View' => __DIR__ . '/..' . '/slim/slim/Slim/View.php',
        'Slim\\Views\\Smarty' => __DIR__ . '/..' . '/slim/views/Smarty.php',
        'Slim\\Views\\Twig' => __DIR__ . '/..' . '/slim/views/Twig.php',
        'Slim\\Views\\TwigExtension' => __DIR__ . '/..' . '/slim/views/TwigExtension.php',
        'Spring_App\\Includes\\CustomView' => __DIR__ . '/../..' . '/app/Includes/CustomView.php',
        'Spring_App\\Model\\Note' => __DIR__ . '/../..' . '/app/Model/Note.php',
        'Spring_App\\Model\\User' => __DIR__ . '/../..' . '/app/Model/User.php',
        'Spring_App\\Utility\\DB' => __DIR__ . '/../..' . '/app/Utility/DB.php',
        'Spring_App\\Utility\\Logger\\Log' => __DIR__ . '/../..' . '/app/Utility/Logger/Log.php',
        'Spring_App\\Utility\\Logger\\Logger' => __DIR__ . '/../..' . '/app/Utility/Logger/Logger.php',
        'Spring_App\\Utility\\Messenger' => __DIR__ . '/../..' . '/app/Utility/Messenger.php',
        'Spring_App\\Utility\\Navigation' => __DIR__ . '/../..' . '/app/Utility/Navigation.php',
        'Spring_App\\Utility\\Request' => __DIR__ . '/../..' . '/app/Utility/Request.php',
        'Spring_App\\Utility\\Session' => __DIR__ . '/../..' . '/app/Utility/Session.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8e5a0519c11ee2238c3cacbd67dfd583::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8e5a0519c11ee2238c3cacbd67dfd583::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit8e5a0519c11ee2238c3cacbd67dfd583::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit8e5a0519c11ee2238c3cacbd67dfd583::$classMap;

        }, null, ClassLoader::class);
    }
}
