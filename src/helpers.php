<?php

use Illuminate\Support\Carbon;

if (! function_exists('compressJson')) {
    /**
     * Compress array to json.
     *
     * @param array $array
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
     * @param string $string
     *
     * @return array
     */
    function extractJson(string $string): array
    {
        $array = (array) json_decode([$string][0]);

        return (array) json_decode(zlib_decode(base64_decode(array_values($array)[0])));
    }
}

if (! function_exists('sizeFormat')) {
    /**
     * Parsing and formatting file sizes in simple, human friendly formats.
     *
     * @param int $bytes
     * @param int $decimals
     *
     * @return string
     */
    function sizeFormat(int $bytes, int $decimals = 2): string
    {
        $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $factor = floor((strlen($bytes) - 1) / 3);

        return (string) sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)).$size[$factor];
    }
}

if (! function_exists('generateCacheKeyName')) {
    /**
     * Generate Cache key name.
     *
     * @param array|null $arg
     * @param string $space
     *
     * @return string
     */
    function generateCacheKeyName(array $arg, string $space = ':'): string
    {
        return (string) implode($space, array_filter($arg));
    }
}

if (! function_exists('carbon')) {
    /**
     * @param mixed ...$args
     *
     * @return \Illuminate\Support\Carbon
     * @throws \Exception
     */
    function carbon(...$args)
    {
        return new Carbon(...$args);
    }
}
