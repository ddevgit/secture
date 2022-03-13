<?php

namespace App\Service\Player;


use App\Entity\Player;
use App\Repository\PlayerRepository;

class CreatePlayer
{
    private  $playerRepository;

    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    public function __invoke(string $name): Player
    {
        $player = Player::create($name);
        $this->playerRepository->save($player);
        return $player;
    }
}