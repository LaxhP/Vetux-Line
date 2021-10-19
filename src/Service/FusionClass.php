<?php

namespace App\Service;

use Iterator;
use League\Csv\Writer;
use PhpParser\Node\Expr\Array_;

class FusionClass
{
    public function fusion(Iterator $records, Writer $output, Array $tabName ){
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
    }

}