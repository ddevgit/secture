<?php

namespace App\Service\Team;

use App\Entity\Team;
use App\Form\Model\CategoryDto;
use App\Form\Model\TeamDto;
use App\Form\Type\TeamFormType;
use App\Repository\TeamRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class TeamFormProcessor
{

    private  $getTeam;
    private  $teamRepository;
    private  $formFactory;

    public function __construct(
        GetTeam $getCategory,
        TeamRepository $categoryRepository,
        FormFactoryInterface $formFactory
    ) {
        $this->getTeam = $getCategory;
        $this->teamRepository = $categoryRepository;
        $this->formFactory = $formFactory;
    }

    public function __invoke(Request $request, ?string $teamId = null): array
    {
        $team = null;
        $teamDto = null;

        if ($teamId === null) {
            $teamDto = new CategoryDto();
        } else {
            $team = ($this->getTeam)($teamId);
            $teamDto = TeamDto::createFromTeam($team);
        }
        
        $form = $this->formFactory->create(TeamFormType::class, $teamDto);
        $form->handleRequest($request);
        if (!$form->isSubmitted()) {
            return [null, 'Form is not submitted'];
        }
        if (!$form->isValid()) {
            return [null, $form];
        }

        if ($team === null) {
            $team = Team::create(
                $teamDto->getName()
            );
        } else {
            $team->update(
                $teamDto->getName()
            );
        }

        $this->teamRepository->save($team);
        return [$team, null];
    }
}
