<?php

namespace App\Form\Model;

use App\Entity\Team;
use Ramsey\Uuid\UuidInterface;

class TeamDto
{
    public  $id = null;
    public  $name = null;

    public static function createFromTeam(Team $team): self
    {
        $dto = new self();
        $dto->id = $team->getId();
        $dto->name = $team->getName();
        return $dto;
    }

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
