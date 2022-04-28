<?php

declare(strict_types=1);

use Coduo\PHPHumanizer\NumberHumanizer;
use Coduo\PHPHumanizer\StringHumanizer;
use Cryptomute\Cryptomute;
use DockerSecrets\Reader\SecretsReader;
use Illuminate\Support\Carbon;
use Tuupola\Base62;
use Webpatser\Uuid\Uuid;

if (! function_exists('compressJson')) {
    /**
     * Compress array to json.
     *
     * @param  array  $array
     *
     * @return string
     */
    function compressJson(array $array): string
    {
        $object = base64_encode(zlib_encode(json_encode($array), ZLIB_ENCODING_DEFLATE));

        return (string) json_encode(['zip_json_key' => $object]);
    }
}

if (! function_exists('extractJson')) {
    /**
     * Extract json to array.
     *
     * @param  string  $string
     *
     * @return array
     */
    function extractJson(string $string): array
    {
        $array = (array) json_decode([$string][0]);

        return (array) json_decode(zlib_decode(base64_decode(array_values($array)[0], true)));
    }
}

if (! function_exists('formatBytes')) {
    /**
     * Parsing and formatting file sizes in simple, human friendly formats.
     *
     * @param  int  $bytes
     * @param  int  $decimals
     *
     * @return string
     */
    function formatBytes(int $bytes, int $decimals = 2): string
    {
        $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($size) - 1);

        //calculate bytes
        $bytes /= 1024 ** $pow;
        //return the bytes
        return round($bytes, $decimals).' '.$size[$pow];
    }
}

if (! function_exists('generateCacheKeyName')) {
    /**
     * Generate Cache key name.
     *
     * @param  array  $arg
     * @param  string  $space
     *
     * @return string
     */
    function generateCacheKeyName(array $arg, string $space = ':'): string
    {
        return implode($space, array_filter($arg));
    }
}

if (! function_exists('carbon')) {
    /**
     * @param  mixed  ...$args
     *
     * @return \Illuminate\Support\Carbon
     * @throws \Exception
     */
    function carbon(...$args): Carbon
    {
        return new Carbon(...$args);
    }
}

if (! function_exists('base62')) {
    /**
     * functional base62 class.
     *
     * @return Base62
     */
    function base62(): Base62
    {
        return new Base62();
    }
}

if (! function_exists('str_humanize')) {
    /**
     * @param  string  $text
     * @param  bool  $capitalize
     * @param  string  $separator
     * @param  array  $forbiddenWords
     *
     * @return string
     */
    function str_humanize(
        string $text,
        bool $capitalize = true,
        string $separator = '_',
        array $forbiddenWords = []
    ): string {
        return StringHumanizer::humanize($text, $capitalize, $separator, $forbiddenWords);
    }
}

if (! function_exists('number_ordinalize')) {
    /**
     * @param  int  $number
     * @param  string  $locale
     *
     * @return string
     */
    function number_ordinalize(int $number, string $locale = 'en'): string
    {
        return NumberHumanizer::ordinalize($number, $locale);
    }
}

if (! function_exists('number_ordinal')) {
    /**
     * @param  int  $number
     * @param  string  $locale
     *
     * @return string
     */
    function number_ordinal(int $number, string $locale = 'en'): string
    {
        return NumberHumanizer::ordinal($number, $locale);
    }
}

if (! function_exists('number_binary')) {
    /**
     * @param  int  $number
     * @param  int  $precision
     * @param  string  $locale
     *
     * @return string
     */
    function number_binary(int $number, int $precision = 0, string $locale = 'en'): string
    {
        return (string) NumberHumanizer::preciseBinarySuffix($number, $precision, $locale);
    }
}

if (! function_exists('uuid')) {
    /**
     * @param  int  $ver
     * @param  string|null  $node
     * @param  string|null  $ns
     *
     * @return \Webpatser\Uuid\Uuid
     * @throws \Exception
     */
    function uuid(int $ver = 1, string $node = null, string $ns = null): Uuid
    {
        return Uuid::generate($ver, $node, $ns);
    }
}

if (! function_exists('getSecret')) {
    /**
     * @param  string  $secretsDir
     *
     * @return \DockerSecrets\Reader\SecretsReader
     */
    function getSecret(string $secretsDir = '/run/secrets'): SecretsReader
    {
        return new SecretsReader($secretsDir);
    }
}

if (! function_exists('fpe')) {
    /**
     * @param  string  $key
     * @param  string  $cipher
     * @param  int  $round
     *
     * @return \Cryptomute\Cryptomute
     */
    function fpe(string $key, string $cipher = 'aes-256-cbc', int $round = 7): Cryptomute
    {
        return new Cryptomute($cipher, $key, $round);
    }
}

if (!function_exists('readEnv')) {
    /**
     * 读取env.
     *
     * @param string $name
     * @param $default
     *
     * @return array|false|mixed|string
     */
    function readEnv(string $name, $default = null): mixed
    {
        return getenv($name) ?: env($name, $default);
    }
}