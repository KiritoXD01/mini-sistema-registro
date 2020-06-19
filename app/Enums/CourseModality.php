<?php

namespace App\Enums;

use ReflectionClass;

class CourseModality
{
    const PRESENCIAL     = 1;
    const SEMIPRESENCIAL = 2;
    const ONLINE         = 3;

    public static function getItems()
    {
        $class = new ReflectionClass(__CLASS__);
        $items = [];
        foreach (array_flip($class->getConstants()) as $key => $value)
        {
            array_push($items, [
                'id'    => $key,
                'value' => $value
            ]);
        }
        return $items;
    }

    public static function getItem($item)
    {
        $class = new ReflectionClass(__CLASS__);
        $items = array_flip($class->getConstants());
        return (isset($items[$item])) ? $items[$item] : "Undefined";
    }
}
