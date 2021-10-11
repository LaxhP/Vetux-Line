<?php

namespace App\Controller;
use ErrorException;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\Writer;

use SplFileObject;
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
     * @throws Exception
     */
    public function read()
    {
        $csv = Reader::createFromPath('C:\Users\laxha\OneDrive\Bureau\Cours\web_projets\vetux-line\csvFile\french-data.csv', 'r');
        $csv->setHeaderOffset(0);
        $header = $csv->getHeader(); //returns the CSV header record
        $records = $csv->getRecords(); //returns all the CSV records as an Iterator object
        $output = Writer::createFromPath('C:\Users\laxha\OneDrive\Bureau\Cours\web_projets\vetux-line\csvFile\output.csv');
        foreach ($records as $record) {
            if ($record['Gender']=='male') {
                $output->insertOne($record);
            }
        }



        return $this->render('/fusion/read.html.twig', array(
            'records' => $records,'header'=>$header
        ));
    }
}

