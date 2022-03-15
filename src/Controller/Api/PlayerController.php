<?php


namespace App\Controller\Api;

use App\Entity\Player;
use App\Form\Model\PlayerDto;
use App\Form\PlayerBasicFormType;
use App\Repository\PlayerRepository;
use App\Service\Player\PlayerFormProcessor;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;


class PlayerController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(path="/player")
     * @Rest\View(serializerGroups={"player"}, serializerEnableMaxDepthChecks=true)
     */
    public function getAction(PlayerRepository $repository)
    {
        return $repository->findAll();
    }

    /**
     * @Rest\Post(path="/player")
     * @Rest\View(serializerGroups={"player"}, serializerEnableMaxDepthChecks=true)
     */
    public function postAction(
        EntityManagerInterface $em, Request $request
    )
    {
        $playerDto = new PlayerDto();
        $form = $this->createForm(PlayerBasicFormType::class, $playerDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $player = new Player();
            $player->setName($playerDto->name);
            $em->persist($player);
            $em->flush();
            return $playerDto;
        }

        return $form;
    }


    /**
     * @Rest\Put(path="/player/{id}")
     * @Rest\View(serializerGroups={"player"}, serializerEnableMaxDepthChecks=true)
     */
    public function editAction(
        string $id,
        PlayerFormProcessor $playerFormProcessor,
        Request $request
    ) {
        try {
            [$player, $error] = ($playerFormProcessor)($request, $id);
            $statusCode = $player ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST;
            $data = $player ?? $error;
            return View::create($data, $statusCode);
        } catch (Throwable $t) {
            return View::create('Player not found', Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Delete(path="/books/{id}")
     * @Rest\View(serializerGroups={"book"}, serializerEnableMaxDepthChecks=true)
     */
    public function deleteAction(string $id, DeleteBook $deleteBook)
    {
        try {
            ($deleteBook)($id);
        } catch (Throwable $t) {
            return View::create('Book not found', Response::HTTP_BAD_REQUEST);
        }
        return View::create(null, Response::HTTP_NO_CONTENT);
    }
}