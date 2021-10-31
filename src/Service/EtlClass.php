<?php

namespace App\Service;

use App\Entity\Client;
use App\Entity\Marque;
use App\Entity\Vehicule;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\MarqueRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use Iterator;

class EtlClass
{
    public function etl(Iterator $records, ManagerRegistry $doctrine){

        $entityManager=$doctrine->getManager();

        foreach ($records as $pers){
            $voiture=explode(" ", $pers["Vehicle"]);

            $marque = new Marque();
            $marque->setNom($voiture[1]);

            $vehicule = new Vehicule();
            $vehicule->setAnnee($voiture[0]);
            $vehicule->setModele($voiture[2]);
            $vehicule->setMarque($marque);

            $client = new Client();
            $client->setNom($pers["Surname"]);
            $client->setPrenom($pers["GivenName"]);
            $client->setVehicule($vehicule);



            $listMarque=$doctrine->getRepository(Marque::class);
            $bool=$listMarque->findOneBy(["nom"=>$voiture[1]]);
            if(!$bool){
                $entityManager->persist($marque);
            }
            else{
                $vehicule->setMarque($bool);
            }
            $entityManager->persist($vehicule);
            $entityManager->persist($client);
            $entityManager->flush();
        }
    }
}