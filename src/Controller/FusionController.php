<?php

namespace App\Controller;
use App\Service\FileUploader;
use ErrorException;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\Writer;

use SplFileObject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route ("/readcsv", name="read")
     * @throws Exception
     */
    public function read(Request $request, string $uploadDir,
                      FileUploader $uploader)
    {
        $file='../var/uploads/file1.csv'  ;
        $file2='../var/uploads/file2.csv';

        if (empty($file))
        {
            return new Response("No file specified",  Response::HTTP_UNPROCESSABLE_ENTITY,
                ['content-type' => 'text/plain']);
        }
        $csv = Reader::createFromPath($file, 'r');
        $csv->setHeaderOffset(0);
        $header = $csv->getHeader(); //returns the CSV header record
        $records = $csv->getRecords(); //returns all the CSV records as an Iterator object
        $output = Writer::createFromPath('C:\Users\laxha\OneDrive\Bureau\Cours\web_projets\vetux-line\csvFile\output.csv');
        foreach ($records as $record) {
            if ($record['Gender']=='male') {
                $output->insertOne($record);
            }
        }



        unlink('../var/uploads/file1.csv');
        unlink('../var/uploads/file2.csv');
        return $this->render('/fusion/read.html.twig', array(
            'records' => $records,'header'=>$header


        ));
    }
}

