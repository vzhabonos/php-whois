<?php

declare(strict_types=1);

namespace Iodev\Whois\Helpers;

class TextHelper
{
    /**
     * @param string $text
     * @return string
     */
    public static function toUtf8(string $text): string
    {
        if ($text === '') {
            return $text;
        }

        $srcEncoding = mb_detect_encoding(
            $text,
            ['UTF-8', 'Windows-1252', 'ISO-8859-1', 'ISO-8859-15', 'Windows-1251'],
            true
        );

        if ($srcEncoding && strtolower($srcEncoding) !== 'utf-8') {
            return mb_convert_encoding($text, 'UTF-8', $srcEncoding);
        }

        if (mb_check_encoding($text, 'UTF-8')) {
            return $text;
        }

        foreach (['Windows-1252', 'ISO-8859-1', 'ISO-8859-15', 'Windows-1251'] as $enc) {
            if (mb_check_encoding($text, $enc)) {
                return iconv($enc, 'UTF-8//IGNORE', $text);
            }
        }

        return $text;
    }
}
