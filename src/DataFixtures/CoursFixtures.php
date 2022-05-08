<?php

namespace App\DataFixtures;

use App\Entity\Classe;
use App\Entity\Cours;
use App\Entity\Etudiant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class CoursFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        //Création du Faker
        $faker = Factory::create("fr_FR");;

        //On récupère tous les profs
        $repoProf = $manager->getRepository(Etudiant::class);
        $profs = $repoProf->getParRoles(0);

        //On récupère toutes les classes
        $repoClasse = $manager->getRepository(Classe::class);
        $classes = $repoClasse->findAll();


        //Tableau des noms de cours 
        $listeCours = ["INFO841", "INFO842", "EASI742", "EASI821", "PACI841", "PACI842", "SHES803", "LANG801", "SHES804"];

        //Création d'une cinquantaine de cours
        for ($i=0; $i <50; $i++){
            $cours = new Cours();
            shuffle($profs);
            shuffle($classes);
            shuffle($listeCours);

            $cours->setNomCours($listeCours[0]);
            
            $cours->setHeureCours($faker->dateTimeThisYear($max = 'now', $timezone = null)->format('Y-m-d H:i:s'));
            $cours->addClasse($classes[0]);
            $cours->addProf($profs[0]);
            $manager->persist($cours);
        }
        $manager->flush();
    }

    public static function getGroups() : array{
        return ['cours'];
    }
}
