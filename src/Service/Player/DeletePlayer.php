<?php

namespace App\Service\Player;

use App\Repository\PlayerRepository;


class DeletePlayer
{
    private  $getPlayer;
    private  $playerRepository;

    public function __construct(GetPlayer $getTeam, PlayerRepository $playerRepository)
    {
        $this->getPlayer = $getTeam;
        $this->playerRepository = $playerRepository;
    }

    public function __invoke(string $id)
    {
        $team = ($this->getPlayer)($id);
        $this->playerRepository->delete($team);
    }
}
