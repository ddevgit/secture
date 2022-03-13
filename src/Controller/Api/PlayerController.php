<?php


namespace App\Controller\Api;


use App\Entity\Player;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;



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
        EntityManagerInterface $em
    ) {
        $player = new Player();
        $player->setName("my player");
        $player->setPosition("3");
        $player->setPrice(4324);

        $em->persist($player);
        $em->flush();
    }




}