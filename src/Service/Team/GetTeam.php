<?php

namespace App\Service\Team;

use App\Entity\Team;
use App\Model\Exception\Team\TeamNotFound;
use App\Repository\TeamRepository;
use Ramsey\Uuid\Uuid;

class GetTeam
{
    private  $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function __invoke(string $id): ?Team
    {
        $team = $this->teamRepository->find(Uuid::fromString($id));
        if (!$team) {
            TeamNotFound::throwException();
        }
        return $team;
    }
}
