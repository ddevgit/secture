<?php


namespace App\Service;

use Doctrine\ORM\EntityManager;


class ConversionCurrencyService
{
    private $em;

    private $apiKey = "e532f4b799fec52e1107d185599c3e59";

    /**
     * HomeQueryManager constructor.
     * @param $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function callApi()
    {


    }



}