<?php

declare(strict_types=1);

namespace Eccube\ORM\Mapping;

use Attribute;
use Doctrine\ORM\Mapping\AssociationOverride;
use Doctrine\ORM\Mapping\MappingAttribute;
use Doctrine\ORM\Mapping\MappingException;

use function array_values;
use function is_array;

/**
 * This attribute is used to override association mappings of relationship properties.
 *
 * @Annotation
 * @NamedArgumentConstructor()
 * @Target("CLASS")
 */
#[Attribute(Attribute::TARGET_CLASS)]
final class AssociationOverrides implements MappingAttribute
{
    /**
     * Mapping overrides of relationship properties.
     *
     * @var list<AssociationOverride>
     * @readonly
     */
    public $overrides = [];

    /** @param array<AssociationOverride>|AssociationOverride $overrides */
    public function __construct($overrides)
    {
        if (! is_array($overrides)) {
            $overrides = [$overrides];
        }

        foreach ($overrides as $override) {
            if (! ($override instanceof AssociationOverride)) {
                throw MappingException::invalidOverrideType('AssociationOverride', $override);
            }
        }

        $this->overrides = array_values($overrides);
    }
}
