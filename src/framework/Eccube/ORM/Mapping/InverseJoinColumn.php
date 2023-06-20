<?php

declare(strict_types=1);


namespace Eccube\ORM\Mapping;

use Attribute;
use Doctrine\ORM\Mapping\JoinColumnProperties;
use Doctrine\ORM\Mapping\MappingAttribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
final class InverseJoinColumn implements MappingAttribute
{
    use JoinColumnProperties;
}
