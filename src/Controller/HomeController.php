<?php

namespace App\Controller;

use App\Entity\Employes;
use App\Form\EmployeType;
use App\Repository\EmployesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(EmployesRepository $repo): Response
    {

        $employes = $repo->findAll();

        return $this->render('home/index.html.twig', [
            'employes' => $employes
        ]);
    }

   /**
     * @Route("/new", name="nouv_emp")
     * @Route("/edit/{id}", name="edit_emp")
     */
    public function form(Request $superglobals, EntityManagerInterface $manager, Employes $employes = null)
    {
        if(!$employes) 
        {
            $employes = new Employes; 
            //$employes->setPoste("dev"); Pour mettre poste en developpeur par défaut
            // Le get : on va chercher l'information
            // Le set : On va modifier l'information
        }

        

        $form = $this->createForm(EmployeType::class, $employes);
        
        $form->handleRequest($superglobals);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($employes); 
            $manager->flush();

            $this->addFlash('add_OK', 'Employé correctement enregistré');
            return $this->redirectToRoute('accueil', [
                'id' => $employes->getId()
            ]);
        }
    
       
    return $this->renderForm("home/form.html.twig", [
        'formEmployes' => $form,
        'editMode' => ($employes->getId() !== null)
    ]);

    }

    /**
     * @Route("/delete/{id}", name="delete_emp")
     */
    public function delete(EntityManagerInterface $manager, $id, EmployesRepository $repo)
    {
        $employes = $repo->find($id);

        $manager->remove($employes);

        $manager->flush();

        $this->addFlash('delete_OK', "L'employé a bien été supprimé !");

        return $this->redirectToRoute('accueil');
    } 

}

