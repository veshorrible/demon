<?php

class Crypt
{
    /**
     * Code
     *
     * @param $text
     * @param $key
     * @return string
     */
    public static function code($text, $key)
    {
        $outText = '';
        for ($i = 0; $i < strlen($text);) {
            for ($j = 0; ($j < strlen($key) && $i < strlen($text)); $j++, $i++) {
                $outText .= $text{$i} ^ $key{$j};
            }
        }
        return $outText;

    }
}