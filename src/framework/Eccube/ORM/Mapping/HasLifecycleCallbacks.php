<?php

declare(strict_types=1);

namespace Eccube\ORM\Mapping;

use Attribute;
use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor;
use Doctrine\ORM\Mapping\MappingAttribute;

/**
 * @Annotation
 * @Target("CLASS")
 */
#[Attribute(Attribute::TARGET_CLASS)]
final class HasLifecycleCallbacks implements MappingAttribute
{
}
