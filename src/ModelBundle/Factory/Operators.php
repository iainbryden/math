<?php

namespace ModelBundle\Factory;

use ReflectionClass;
use stdClass;

class Operators
{
    const ADD = "+";
    const SUBTRACT = "-";
    const MULTIPLY = "x";
    const DIVIDE = "%";

    /**
     * @param null|array $allowed
     * @return array
     */
    public static function getAllOperators($allowed = null)
    {
        $reflector = new ReflectionClass(__CLASS__);
        
        //if ($allowed == null) {
        //    return $reflector->getConstants();
        //}


        return ($allowed) ? array_intersect($reflector->getConstants(), $allowed) : $reflector->getConstants();
    }
}