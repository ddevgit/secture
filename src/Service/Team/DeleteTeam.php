<?php

namespace App\Service\Team;

use App\Repository\TeamRepository;
use App\Service\Team\GetTeam;

class DeleteTeam
{
    private  $getTeam;
    private  $teamRepository;

    public function __construct(GetTeam $getTeam, TeamRepository $teamRepository)
    {
        $this->getTeam = $getTeam;
        $this->teamRepository = $teamRepository;
    }

    public function __invoke(string $id)
    {
        $team = ($this->getTeam)($id);
        $this->teamRepository->delete($team);
    }
}
