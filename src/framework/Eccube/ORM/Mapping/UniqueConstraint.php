<?php

declare(strict_types=1);

namespace Eccube\ORM\Mapping;

use Attribute;
use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor;
use Doctrine\ORM\Mapping\MappingAttribute;

/**
 * @Annotation
 * @NamedArgumentConstructor()
 * @Target("ANNOTATION")
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
final class UniqueConstraint implements MappingAttribute
{
    /**
     * @var string|null
     * @readonly
     */
    public $name;

    /**
     * @var array<string>|null
     * @readonly
     */
    public $columns;

    /**
     * @var array<string>|null
     * @readonly
     */
    public $fields;

    /**
     * @var array<string,mixed>|null
     * @readonly
     */
    public $options;

    /**
     * @param array<string>       $columns
     * @param array<string>       $fields
     * @param array<string,mixed> $options
     */
    public function __construct(
        ?string $name = null,
        ?array $columns = null,
        ?array $fields = null,
        ?array $options = null
    ) {
        $this->name    = $name;
        $this->columns = $columns;
        $this->fields  = $fields;
        $this->options = $options;
    }
}
