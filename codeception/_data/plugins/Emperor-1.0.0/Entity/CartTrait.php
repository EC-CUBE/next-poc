<?php

namespace Plugin\Emperor\Entity;


use Eccube\Annotation\EntityExtension;
use Eccube\ORM\Mapping as ORM;

/**
 * @EntityExtension("Eccube\Entity\Cart")
 */
trait CartTrait
{
    #[ORM\JoinColumn(name: 'foo_id', referencedColumnName: 'id')]
    #[ORM\OneToOne(targetEntity: 'Plugin\Emperor\Entity\Foo')]
    public $foo;
}
