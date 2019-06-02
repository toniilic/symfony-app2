<?php


namespace App\Utils;


class Slugger
{
    /**
     * @param string $string
     *
     * @return string
     */
    public function slugify($string)
    {
        return preg_replace('/\s+/', '-', mb_strtolower(trim(strip_tags($string)), 'UTF-8')) . '-' . bin2hex(random_bytes(15));
    }
}