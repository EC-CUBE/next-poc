<?php

namespace Eccube\Util;

use Doctrine\Common\Util\ClassUtils as DoctrineClassUtils;

class ClassUtils
{
    public static function getClass($object)
    {
        return DoctrineClassUtils::getRealClass(get_class($object));
    }
}
