<?php

class Crypt
{
    /**
     * Code
     *
     * @param string $text
     * @param string $key
     * @return string
     */
    private function code(string $text, string $key)
    {
        $outText = '';
        for ($i = 0; $i < strlen($text);) {
            for ($j = 0; ($j < strlen($key) && $i < strlen($text)); $j++, $i++) {
                $outText .= $text{$i} ^ $key{$j};
            }
        }

        return $outText;
    }

    /**
     * Encode
     *
     * @param string $text
     * @param string $key
     * @return string
     */
    public function encode(string $text, string $key) {
        return base64_encode($this->code($text, $key));
    }
}