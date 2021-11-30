<?php


namespace App\Controller;



use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LibraryController extends AbstractController
{
    private  $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("/library/list", name="library_list")
     */
    public function list(Request $request)
    {
        $title = $request->get('title', '*******  // without title // ******');
        $this->logger->warning($title);
        $response = new JsonResponse();
        $response->setData([
           'success' =>true,
           'data'  =>
               [
                'id' => 1,
                'title' => 'Hacia rutas salvajes'
                ],
                [
                'id' => 2,
                'title' => $title
                ]
        ]);

        return $response;
    }



    /**
     * @Route("/book/create", name="create_book")
     */
    public function createBook(Request $request, EntityManagerInterface $em)
    {
        $book = new Book();
        $book->setTitle('Hacia rutas salvajes');
        $em->persist($book);
        $em->flush();

        $response = new JsonResponse();
        $response->setData([
           'success' => true,
           'data' =>
               [
                  'id' => $book->getId(),
                   'title' => $book->getTitle(),
               ]
        ]);

        return $response;

    }

}