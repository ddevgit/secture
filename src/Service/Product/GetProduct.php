<?php

namespace App\Service\Product;

use App\Entity\Product;
use App\Model\Exception\Product\ProductNotFound;
use App\Repository\CategoryRepository;
use Ramsey\Uuid\Uuid;

class GetProduct
{

    private  $productRepository;

    public function __construct(CategoryRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(string $id): ?Product
    {
        $product = $this->productRepository->find(Uuid::fromString($id));
        if (!$product) {
            try {
                ProductNotFound::throwException();
            } catch (ProductNotFound $e) {
            }
        }
        return $product;
    }
}
