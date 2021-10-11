<?php

namespace App\Controller;
use League\Csv\Reader;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FusionController extends AbstractController
{

    /**
     * @Route ("/fusion", name= "fusion")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/FusionController.php',
        ]);
    }

    /**
     * @Route ("/readcsv")
     */
    public function read(): Response
    {
        $csv = Reader::createFromPath('C:\Users\laxha\OneDrive\Bureau\Cours\web_projets\vetux-line\csvFile\french-data.csv', 'r');
        $csv->setHeaderOffset(0);
        $header = $csv->getHeader(); //returns the CSV header record
        $records = $csv->getRecords(); //returns all the CSV records as an Iterator object


        return $this->render('/fusion/read.html.twig', array(
            'records' => $records,'header'=>$header
        ));
    }
}

