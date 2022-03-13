<?php

namespace App\Service\Player;

use App\Entity\Player;
use App\Model\Exception\Player\PlayerNotFound;
use App\Repository\PlayerRepository;
use Ramsey\Uuid\Uuid;

class GetPlayer
{
    private  $playerRepository;

    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    public function __invoke(string $id): ?Player
    {
        $player = $this->playerRepository->find(Uuid::fromString($id));
        if (!$player) {
            PlayerNotFound::throwException();
        }
        return $player;
    }
}
