<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Repository\MarqueRepository;
use App\Service\EtlClass;
use League\Csv\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtlController extends AbstractController
{
    /**
     * @Route ("/etl", name="etl")
     */
    public function etl(EtlClass $etlClass)
    {
        $file = '../public/csv/output.csv';
        $csv = Reader::createFromPath($file, 'r');
        $csv->setHeaderOffset(0);
        $records=$csv->getRecords();
        $doctrine = $this->getDoctrine();
        $etlClass->etl($records,$doctrine);



        return $this->render('etl/index.html.twig', [
            'controller_name' => 'EtlController',
        ]);
    }
}
