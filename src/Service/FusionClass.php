<?php

namespace App\Service;

use Iterator;
use League\Csv\Writer;

class FusionClass
{
    public function fusion(bool $type, Iterator $records, array $tabName, Writer $output)
    {
        $total = [];
        $tab = [];
        foreach ($records as $record1) {
            if ($this->filtre($record1)) {
                for ($i = 0; $i < count($tabName); $i++) {
                    $para = $tabName[$i];
                    $tab[$para] = $record1[$para];
                }

                if ($type)
                    $output->insertOne($tab);
                else
                    $total[] = $tab;

            }
        }
        return $total;
    }


    public function filtre(array $record)
    {
        $carte = [];
        $t = $record["FeetInches"];
        $tb = explode("'", $t);
        $comv = ((int)$tb[0] + ((int)$tb[1] / 10)) * 30.48;
        $bool = ((int)$comv - 1 <= $record["Centimeters"]) && ((int)$comv + 1 >= $record["Centimeters"]);
        if ($bool) {
            $t = $record["Birthday"];
            $tb = explode("/", $t);
            if (((int)$tb[2] <= (date('Y') - 18))) {
                $ccn = $record["CCNumber"];
                if ((!in_array($ccn, $carte))) {
                    array_push($carte, $ccn);
                    return true;
                }
            }
        }
        return false;
    }


    public function melange(bool $type, Iterator $array1, Iterator $array2, array $tabname, Writer $output)
    {
        $array12 = $this->fusion($type, $array1, $tabname, $output);
        $array22 = $this->fusion($type, $array2, $tabname, $output);
        if (!$type) {
            $i = 0;
            $sizemax = count($array12) + count($array22);
            while ($i < $sizemax) {
                if ($i < count($array22))
                    $output->insertOne($array22[$i]);
                if ($i < count($array12))
                    $output->insertOne($array12[$i]);
                $i++;
            }
        }
    }


}