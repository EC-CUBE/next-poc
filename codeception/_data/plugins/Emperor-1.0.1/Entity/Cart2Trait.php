<?php

namespace Plugin\Emperor\Entity;


use Eccube\Annotation\EntityExtension;
use Doctrine\ORM\Mapping as ORM;

/**
 * @EntityExtension("Eccube\Entity\Cart")
 */
trait Cart2Trait
{
    #[ORM\JoinColumn(name: 'bar_id', referencedColumnName: 'id')]
    #[ORM\OneToOne(targetEntity: 'Plugin\Emperor\Entity\Bar')]
    public $bar;
}
