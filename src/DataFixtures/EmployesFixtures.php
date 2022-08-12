<?php

namespace App\DataFixtures;

use App\Entity\Employes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EmployesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 1; $i <= 8; $i++)
        {
            $employes = new Employes;

            $employes->setPrenom("Prenom $i")
                    ->setNom("Nom $i")
                    ->setTelephone("06060606$i")
                    ->setEmail("prenom.nom$i@gmail.com")
                    ->setAdresse("$i adresse 77100 ville")
                    //->setPoste("Développeur")
                    ->setSalaire(2000)
                    ->setDatedenaissance(new \DateTime());
            $manager->persist($employes);
                    
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
