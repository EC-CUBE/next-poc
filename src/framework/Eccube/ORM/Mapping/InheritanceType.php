<?php

declare(strict_types=1);

namespace Eccube\ORM\Mapping;

use Attribute;
use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor;
use Doctrine\ORM\Mapping\MappingAttribute;

/**
 * @Annotation
 * @NamedArgumentConstructor()
 * @Target("CLASS")
 */
#[Attribute(Attribute::TARGET_CLASS)]
final class InheritanceType implements MappingAttribute
{
    /**
     * The inheritance type used by the class and its subclasses.
     *
     * @var string
     * @psalm-var 'NONE'|'JOINED'|'SINGLE_TABLE'|'TABLE_PER_CLASS'
     * @readonly
     * @Enum({"NONE", "JOINED", "SINGLE_TABLE", "TABLE_PER_CLASS"})
     */
    public $value;

    /** @psalm-param 'NONE'|'JOINED'|'SINGLE_TABLE'|'TABLE_PER_CLASS' $value */
    public function __construct(string $value)
    {
        $this->value = $value;
    }
}
