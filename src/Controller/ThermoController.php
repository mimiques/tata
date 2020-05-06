<?php

namespace App\Controller;

use App\Data\Filtres;

use App\Entity\Thermo;
use App\Repository\ThermoRepository;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class ThermoController extends AbstractController
{
    /**
     * @Route("/thermo", name="thermo")
     */
    public function index()
    {
        return $this->render('thermo/index.html.twig', [
            'controller_name' => 'ThermoController',
        ]);
    }

    /**
     * @route("/home" , name= "home")
     * @param AuthenticationUtils $authenticationUtils
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function home(AuthenticationUtils $authenticationUtils, Request $request): \Symfony\Component\HttpFoundation\Response
    {
        if (!$this->getUser()) {
            return $this->render('security/login.html.twig');
        } else {
            $lastUsername = $authenticationUtils->getLastUsername();

        }

        return $this->render('thermo/home.html.twig', [
            'last_username' => $lastUsername
        ]);

    }

    /**
     * @route("/vueEnsemble" , name="vueEnsemble")
     */
    public function courbe(ThermoRepository $repository)
    {
        //filtre
        $data = new Filtres();
        $form = $this->createForm(Filtres::class, $data);

        $thermo = $repository->findFiltres();

        return $this->render('thermo/vueEnsemble.html.twig', [
            'thermo' => $thermo,
            'form' => $form
        ]);
    }


    /**
     * @route("/detail" , name="detail")
     * @return Response
     */
    public function afficherDetail()
    {
        $repository = $this->getDoctrine()->getRepository(Thermo::class);
        $thermo = $repository->findAll();


        return $this->render('thermo/detail.html.twig'
            , [
                'thermo' => $thermo,

            ]);
    }

    //fonction pour creer un thermo

    /**
     * @route("/detail" , name="creerThermo")
     * @param Request $request
     *
     */

     public function creerThermo(Request $request)
     {

         $thermo = new Thermo();
         $form = $this->createFormBuilder($thermo)
             ->add('date', DateType::class)
             ->add('temperature', NumberType::class)
             ->add('hygrometrie', NumberType::class)
             ->getForm();
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {

             $request->request->get('enregistrer');

             $manager = $this->getDoctrine()->getManager();




             $manager->persist($thermo);
             $manager->flush();
         }
         return $this->render('thermo/detail.html.twig', [
             'formThermo' => $form->createView()
         ]);

     }


    //gerer les salles
    /**
     * @route("/gererSalle" , name = "salle")
     */
    public function ajouterSalle()
    {

        return $this->render('thermo/gererSalle.html.twig');
    }


    /**
     * @route("/detail" , name= "graph")
     * @return Response
     */

    public function creerGraphique(){
        //$graph1=new Chart();

        return $this->render('thermo/detail.html.twig');
    }

}
