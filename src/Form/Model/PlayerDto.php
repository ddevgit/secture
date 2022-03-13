<?php

namespace App\Form\Model;

use App\Entity\Player;
use Ramsey\Uuid\UuidInterface;

class PlayerDto
{
    public  $id = null;
    public  $name = null;

    public static function createFromPlayer(Player $player): self
    {
        $dto = new self();
        $dto->id = $player->getId();
        $dto->name = $player->getName();
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
