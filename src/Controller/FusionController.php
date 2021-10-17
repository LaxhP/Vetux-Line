<?php

namespace App\Controller;

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



//Number,Gender,NameSet,Title,GivenName,MiddleInitial,Surname,StreetAddress,City,State,StateFull,ZipCode,Country,CountryFull,EmailAddress,Username,Password,BrowserUserAgent,TelephoneNumber,TelephoneCountryCode,MothersMaiden,Birthday,TropicalZodiac,CCType,CCNumber,CVV2,CCExpires,NationalID,UPS,WesternUnionMTCN,MoneyGramMTCN,Color,Occupation,Company,Vehicle,Domain,BloodType,Pounds,Kilograms,FeetInches,Centimeters,Latitude,Longitude
    /**
     * @Route ("/readcsv", name="readcsv")
     * @throws Exception
     */
    public function read()
    {
        //$source="/home/laupa/Vidéos/Vetux-Line/Vetux/Vetux-Line/csvFile/";
        $file='../var/uploads/file1.csv'  ;
        $csv = Reader::createFromPath($file, 'r');
        $csv->setHeaderOffset(0);
        $header = $csv->getHeader(); //returns the CSV header record
        $records = $csv->getRecords(); //returns all the CSV records as an Iterator object
        $output = Writer::createFromPath('../public/csv/output.csv');
        //$tabName = ["Gender", "GivenName","Surname","Birthday","StreetAddress","Title","EmailAddress","TelephoneNumber","Kilograms","CCType","CCNumber","CVV2","CCExpires","Vehicle"];
          $tabName = ["Gender", "GivenName","Surname","Birthday","StreetAddress","EmailAddress","Centimeters","FeetInches"];
        $output->insertOne($tabName);//0,
        $carte=[];


        foreach ($records as $record) {

            for ( $i=0; $i<count($tabName);$i++) {
                $para = $tabName[$i];
                $tab[$i] = $record[$para];

            }
            $t=$record["FeetInches"];
            $tb= explode("'", $t);
            $boo=((int)$tb[0]+((int)$tb[1]/10))*30.48;
            $bo =($boo-2 <= $record['Centimeters']  &&  $boo+2 >= $record['Centimeters']);

            $t=$record["Birthday"];
            $tb= explode("/", $t);
            $bo= $bo && ((int)$tb[2]<=2003);

            $ccn=$record["CCNumber"];


            if((!in_array($ccn,$carte) )) {
                array_push($carte, $ccn);
                if($bo)
                $output->insertOne($tab);
            }
        }


        return $this->render('/fusion/read.html.twig', array(
            'records' => $records,'header'=>$header ,"boo"=>$boo
        ));
    }




    /**
     * @Route ("/sel")
     */
    public function selesct()
    {
        $source="/home/laupa/Vidéos/Vetux-Line/Vetux/Vetux-Line/csvFile/";
        $csv = Reader::createFromPath($source . 'french-data.csv', 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords(); //returns all the CSV records as an Iterator object


        return $this->render('/fusion/read.html.twig', array(
            'records' => $records,
        ));
    }
}

