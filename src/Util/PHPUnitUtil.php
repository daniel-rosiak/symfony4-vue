<?php

namespace App\Util;

/**
 * Class PHPUnitUtil
 * @package App\Util
 */
class PHPUnitUtil
{

    /**
     * @param object $obj The instantiated instance of your class
     * @param string $name The name of your private/protected method
     * @return \ReflectionMethod The method you asked for
     */
    public static function getMethod($obj, $name) {
        $class = new \ReflectionClass($obj);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }
  
}