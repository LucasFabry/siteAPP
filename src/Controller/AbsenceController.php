<?php

namespace App\Controller;

use App\Entity\Absence;
use App\Entity\Utilisateur;
use App\Form\AbsenceType;
use App\Repository\AbsenceRepository;
use App\Repository\UtilisateurRepository;
use DateTime;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

#[Route('absence')]

class AbsenceController extends AbstractController
{

    //Permet d'afficher toutes les absences
    #[Route('/', name: 'absence.list')]
    public function selectAll(ManagerRegistry $manager): Response
    {
        $repository = $manager->getRepository(Absence::class);
        $absences = $repository->findAll();
        return $this->render('absence/index.html.twig', [
            'absences' => $absences,
            'css' => '../css/base2.css'
        ]);
    }

    #[Route('/add', name: 'absence.ajouter')]
    public function addAbsence(ManagerRegistry $doctrine, Request $request): Response
    {   
        

        $absence = new Absence();
        $form = $this->createForm(AbsenceType::class, $absence);
        $form->remove('justification');
        $form->remove('valide');

        $form->handleRequest($request);

        if($form->isSubmitted()){
            $entityManager = $doctrine->getManager();
            $entityManager->persist($absence);
            $entityManager->flush();
            return $this->redirectToRoute('absence.list'); 
        }else{
            return $this->render('absence/add-absence.html.twig', [
            'form' => $form->createView(),
            'css' => '../css/base2.css',
        ]);
        }

        
        /*$absence = new Absence();
        $repUser = new UtilisateurRepository($doctrine);
        $user = $repUser->findOneBySomeField($idEtu);

        $dateFormat = new DateTime($date);

        $absence->setIdEtu($user);
        $absence->setDate($dateFormat);
        //Ajouter l'opération d'insertion

        $entityManager->persist($absence);

        //Executez le code todo
        $entityManager->flush();
        return $this->redirectToRoute("absence.list");*/
        
    }

    //Permet de récupérer les absences avec un id
    #[Route('/{id<\d+>}', name: 'absence.getById')]
    public function getById(ManagerRegistry $doctrine, $id): Response
    {   
        $repository = $doctrine->getRepository(Utilisateur::class);
        $utilisateur = $repository->find($id);
        if($utilisateur){
            $repositoryAbs = new AbsenceRepository($doctrine);
            $listeAbs = $repositoryAbs->findByIdUtilisateur($id);
            return $this->render('absence/absenceParUser.html.twig', [
                'absencesUtilisateur' => $listeAbs,
                'css' => '../css/base2.css'
            ]);
        }
        else{
            $this->addFlash('error', 'La personne n\'existe pas');
            return $this->redirectToRoute('absence.list');
        }
        
    }

    #[Route('/justifier', name: 'absence.justifier')]
    public function justifierAbsence($idAbs, $texteJustif){
        //TODO
    }
}
