<?php


namespace App\Controller\Api;


use App\Entity\Team;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class TeamController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(path="/team")
     * @Rest\View(serializerGroups={"team"}, serializerEnableMaxDepthChecks=true)
     */
    public function getAction(TeamRepository $repository)
    {
        return $repository->findAll();
    }

    /**
     * @Rest\Post(path="/team")
     * @Rest\View(serializerGroups={"team"}, serializerEnableMaxDepthChecks=true)
     */
    public function postAction(
        EntityManagerInterface $em
    ) {
        $team = new Team();
        $team->setName("new team");
        $em->persist($team);
        $em->flush();
    }

    /**
     * @Rest\Put(path="/team/{id}")
     * @Rest\View(serializerGroups={"team"}, serializerEnableMaxDepthChecks=true)
     */
    public function editAction(
        string $id,
        BookFormProcessor $bookFormProcessor,
        Request $request
    ) {
        try {
            [$book, $error] = ($bookFormProcessor)($request, $id);
            $statusCode = $book ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST;
            $data = $book ?? $error;
            return View::create($data, $statusCode);
        } catch (Throwable $t) {
            return View::create('Book not found', Response::HTTP_BAD_REQUEST);
        }
    }
}