<?php

namespace App\Utils;

class UuidGenerator
{

    const DEFAULT_IDENTIFIER_LENGTH = 20;

    /**
     * Generate random identifier value by length value.
     *
     * @param int $length
     *
     * @return string
     */
    public function generateUniqueIdentifier(int $length = self::DEFAULT_IDENTIFIER_LENGTH): string
    {
        return substr(preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(openssl_random_pseudo_bytes($length + 1))), 0, $length);
    }

}