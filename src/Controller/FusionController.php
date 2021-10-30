<?php

namespace App\Controller;

use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\Writer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Service\FusionClass;

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



//Number,Gender,NameSet,Title,GivenName,MiddleInitial,Surname,StreetAddress,City,State,StateFull,ZipCode,Country,CountryFull,EmailAddress,Username,Password,BrowserUserAgent,TelephoneNumber,TelephoneCountryCode,MothersMaiden,Birthday,TropicalZodiac,CCType,CCNumber,CVV2,CCExpires,NationalID,UPS,WesternUnionMTCN,MoneyGramMTCN,Color,Occupation,Company,Vehicle,Domain,BloodType,Pounds,Kilograms,FeetInches,Centimeters,Latitude,Longitude

    /**
     * @Route ("/readcsv", name="readcsv")
     * @throws Exception
     */
    public function read(FusionClass $fusion)
    {
        //$source="/home/laupa/Vidéos/Vetux-Line/Vetux/Vetux-Line/csvFile/";
        $file2 = '../var/uploads/file2.csv';
        $file1 = '../var/uploads/file1.csv';
        $csv2 = Reader::createFromPath($file2, 'r');
        $csv1 = Reader::createFromPath($file1, 'r');
        $csv2->setHeaderOffset(0);
        $csv1->setHeaderOffset(0);
        $header = $csv1->getHeader(); //returns the CSV header record
        $records1 = $csv1->getRecords(); //returns all the CSV records as an Iterator object
        $records2 = $csv2->getRecords(); //returns all the CSV records as an Iterator object
        $output = Writer::createFromPath('../public/csv/output.csv');
        $tabName = ["Number", "GivenName", "Surname", "Birthday", "StreetAddress", 'NameSet', "EmailAddress", "TelephoneNumber", "Kilograms", "CCType", "CCNumber", "CVV2", "CCExpires", "Vehicle"];
        $output->insertOne($tabName);
        $fusion->melange(true, $records1, $records2, $tabName, $output);

        return $this->render('/fusion/read.html.twig', array(
            'records' => $records1, 'header' => $header
        ));
    }


    /**
     * @Route("/download",name="download")
     */
    public function download(): BinaryFileResponse
    {
        $response = new BinaryFileResponse('../public/csv/output.csv');
        $response->headers->set('Content-Type', 'text/csv');
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'fusion.csv'
        );
        return $response;
    }
}

