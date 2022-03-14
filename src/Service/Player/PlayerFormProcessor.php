<?php

namespace App\Service\Player;

use App\Entity\Player;
use App\Form\Model\PlayerDto;
use App\Form\Type\PlayerFormType;
use App\Repository\PlayerRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class PlayerFormProcessor
{
    private  $getPlayer;
    private  $playerRepository;
    private  $formFactory;

    public function __construct(
        GetPlayer $getPlayer,
        PlayerRepository $playerRepository,
        FormFactoryInterface $formFactory
    ) {
        $this->getPlayer = $getPlayer;
        $this->playerRepository = $playerRepository;
        $this->formFactory = $formFactory;
    }

    public function __invoke(Request $request, ?string $playerId = null): array
    {
        $player = null;
        $playerDto = null;

        if ($playerId === null) {
            $playerDto = new PlayerDto();
        } else {
            $player = ($this->getPlayer)($playerId);
            $playerDto = playerDto::createFromPlayer($player);
        }
        
        $form = $this->formFactory->create(PlayerFormType::class, $playerDto);
        $form->handleRequest($request);
        if (!$form->isSubmitted()) {
            return [null, 'Form is not submitted'];
        }
        if (!$form->isValid()) {
            return [null, $form];
        }

        if ($player === null) {
            $player = Player::create(
                $playerDto->getName()
            );
        } else {
            $player->update(
                $playerDto->getName()
            );
        }

        $this->playerRepository->save($player);
        return [$player, null];
    }
}
