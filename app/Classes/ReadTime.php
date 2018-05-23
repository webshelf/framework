<?php

namespace App\Classes;

class ReadTime
{
    /**
     * Estimates the reading time for a given piece of $content.
     *
     * @param string $content Content to calculate read time for.
     * @param int $wpm Estimated words per minute of reader.
     *
     * @returns	int $time Esimated reading time.
     */
    public static function InMinutes($content)
    {
        $words_per_minute = 200;
        $clean_content = strip_tags($content);
        $word_count = str_word_count($clean_content);
        $time = ceil($word_count / $words_per_minute);

        return $time;
    }

    /**
     * Gets the word count of a content without its html tags being read.
     *
     * @param string $content The content to be parsed.
     *
     * @return int $word_count The count of words found.
     */
    public static function countWords($content)
    {
        $clean_content = strip_tags($content);
        $word_count = str_word_count($clean_content);

        return $word_count;
    }
}
