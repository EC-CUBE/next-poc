<?php

declare(strict_types=1);

namespace Eccube\ORM\Mapping;

use Attribute;
use Doctrine\ORM\Mapping\MappingAttribute;

/**
 * @Annotation
 * @Target("METHOD")
 */
#[Attribute(Attribute::TARGET_METHOD)]
final class PreFlush implements MappingAttribute
{
}
