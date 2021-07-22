<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Management;

class EventSearchQueryParserService
{
    public static function parse($text)
    {
        preg_match('/^(.+?) at (.+?)$/', $text, $match);

        if ($match) {
            return [
                'text' => $match[1],
                'location' => $match[2],
            ];
        }
    }
}
