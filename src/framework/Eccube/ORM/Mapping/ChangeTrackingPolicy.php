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
final class ChangeTrackingPolicy implements MappingAttribute
{
    /**
     * The change tracking policy.
     *
     * @var string
     * @psalm-var 'DEFERRED_IMPLICIT'|'DEFERRED_EXPLICIT'|'NOTIFY'
     * @readonly
     * @Enum({"DEFERRED_IMPLICIT", "DEFERRED_EXPLICIT", "NOTIFY"})
     */
    public $value;

    /** @psalm-param 'DEFERRED_IMPLICIT'|'DEFERRED_EXPLICIT'|'NOTIFY' $value */
    public function __construct(string $value)
    {
        $this->value = $value;
    }
}
