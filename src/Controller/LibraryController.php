<?php


namespace App\Controller;



use App\Entity\Book;
use App\Repository\BookRepository;
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
     * @Route("/books", name="library_list")
     */
    public function list(Request $request, BookRepository $bookRepository)
    {
        $title = $request->get('title', '*******  // without title // ******');
        $books = $bookRepository->findAll();
        $booksAsArray = [];

        foreach ($books as $book)
        {
            $booksAsArray[] = [
              'id' => $book->getId(),
                'title' => $book->getTitle(),
                'image' => $book->getImage()
            ];
        }


        $this->logger->warning($title);
        $response = new JsonResponse();
        $response->setData([
           'success' =>true,
           'data'  => $booksAsArray
        ]);

        return $response;
    }



    /**
     * @Route("/book/create", name="create_book")
     */
    public function createBook(Request $request, EntityManagerInterface $em)
    {
        $book = new Book();
        $response = new JsonResponse();
        $title = $request->get('title', null);
        $book->setTitle('Hacia rutas salvajes');
        $em->persist($book);
        $em->flush();

        if(empty($title))
        {
            $response->setData([
                'success' => false,
                'error' => 'Title cannot be empty',
                'data' =>null
            ]);

            return $response;
        }

        $book->setTitle($title);
        $em->persist($book);
        $em->flush();

        return $response;

    }

}