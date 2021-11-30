<?php

namespace App\Service\Product;

use App\Entity\Product;
use App\Repository\ProductRepository;

class CreateProduct
{
    private  $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(string $name): ?Product
    {
        $product = Product::create($name);
        $this->productRepository->save($product);
        return $product;
    }
}