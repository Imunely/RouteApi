<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit74b80f501148c7d8d0674d4d9f3f4c69
{
    public static $files = array (
        '0e2b3c52cdc45502fd38519914f08b5a' => __DIR__ . '/../..' . '/api.config.php',
    );

    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'ApiRoute\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ApiRoute\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit74b80f501148c7d8d0674d4d9f3f4c69::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit74b80f501148c7d8d0674d4d9f3f4c69::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit74b80f501148c7d8d0674d4d9f3f4c69::$classMap;

        }, null, ClassLoader::class);
    }
}
