<?php

namespace Eccube\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Eccube\ORM\Mapping as ORM;
use Eccube\Repository\SampleRepository;

#[ORM\Entity(repositoryClass: SampleRepository::class)]
#[ApiResource]
class Sample
{
    #[ORM\Column(name: 'id', type: 'integer', options: ['unsigned' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    public int $id;

    #[ORM\Column(name: 'name', type: 'string', length: 255)]
    public string $name;
}
