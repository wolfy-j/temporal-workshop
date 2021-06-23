<?php

namespace Workshop\Util;

class Path
{
    public static function resolve(string $filename)
    {
        return realpath(__DIR__ . '/../../data/' . $filename);
    }
}