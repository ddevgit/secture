<?php

namespace App\Service\Team;


use App\Entity\Team;
use App\Repository\TeamRepository;

class CreateTeam
{
    private  $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function __invoke(string $name): ?Team
    {
        $team = Team::create($name);
        $this->teamRepository->save($team);
        return $team;
    }
}