<?php
namespace App\Helpers;

class MyHelper
{
    public static function calDiscount($amount)
    {
        //return 'data';
        return $amount * 10 / 200 + 200 - 1000;
    }
}