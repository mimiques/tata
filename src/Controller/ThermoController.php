<?php

namespace App\Controller;



use App\Entity\Import;
use App\Entity\Mesure;
use App\Entity\Salle;
use App\Entity\Thermo;
use App\Form\ImportFormType;
use App\Form\MesureFormType;
use App\Form\RechercheSalleType;
use App\Form\SallesType;
use App\Form\SalleType;
use App\Form\ThermohType;
use App\Repository\MesureRepository;
use App\Repository\SalleRepository;
use App\Repository\ThermoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\OrderBy;
use Doctrine\ORM\Query\Expr\Select;
use phpDocumentor\Reflection\Types\Array_;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Constraints\Date;


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
//accueil
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


//pour le moment c juste pour le visuel
    /**
     * @route("/vueEnsemble" , name="vueEnsemble")
     */
    public function vuEnsemble()
    {
        $repo = $this->getDoctrine()->getRepository(Salle::class);
        $salles = $repo->findAll();
        return $this->render('thermo/vueEnsemble.html.twig',[
            'salles' =>$salles
        ]);
    }

//creation des mesures en bdd ok dans la twig creerLesMesures

    /**
     * @route("/creerLesMesures" , name= "creer_mesure")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param MesureRepository $repository
     * @return Response
     */
    public function creerMesure(Request $request,EntityManagerInterface $manager ,MesureRepository $repository)
    {
        $mesures= new Mesure();
        $form = $this->createForm(MesureFormType::class,$mesures);
        $form->handleRequest($request);
        //enregistrer  la mesure
        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($mesures);
            $manager->flush();
            return $this->redirectToRoute('detail',[
                'id'=>$mesures->getSalle()->getId()
            ]);
        }
        return $this->render('thermo/creerLesMesures.html.twig',[
            'formMesure' =>$form->createView(),
            'mesures'=>$mesures
        ]);
    }

//fonction qui recupere les mesures date-temp-hygro de la bdd sur la twig detail
    /**
     * @route("/detail/{id}" , name="detail")
     * @param Request $request
     * @param $id
     * @param EntityManagerInterface $manager
     * @param ThermoRepository $repository
     * @return Response
     */
    public function detail(Request $request, EntityManagerInterface $manager, ThermoRepository $repository, $id)
    {
        $repo = $this->getDoctrine()->getRepository(Salle::class);
        $sallesid = $repo->find($id);
        //recuperation dans la bdd
        $repo = $this->getDoctrine()->getRepository(Mesure::class);
        //afficher par odre des dates
        $mesures = $repo->findBy(array('salle'=>$sallesid), array('date' => 'ASC'));
        //creation du formulaire d'un import
        $import = new Import();
        $form = $this->createForm(ImportFormType::class,$import);
        $form->handleRequest($request);
        //enregistrer l'import
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($import);
            $manager->flush();
            return $this->redirectToRoute('vueEnsemble');
        }
        return $this->render('thermo/detail.html.twig', [
            'mesures' => $mesures,
            'sallesid'=>$sallesid,
            'formImport'=>$form->createView()
        ]);

    }

//ok
    /**
     * @route ("/salle_mesures/{id}", name ="salle_mesures")
     * @param $id
     * @return Response
     */
    public function salle_mesures($id,Request $request){
        $repo = $this->getDoctrine()->getRepository(Salle::class);
        $sallesid = $repo->find($id);
        $repo = $this->getDoctrine()->getRepository(Mesure::class);
        //afficher par odre des dates
        $mesures = $repo->findBy(array('salle'=>$sallesid), array('date' => 'ASC'));
        return $this->render('thermo/salle_mesures.html.twig',[
            'sallesid'=>$sallesid,
            'mesures'=>$mesures
        ]);
    }

//fonction modifier les mesures par l'id ok
    /**
     * @route ("/creerLesMesures/modif/{id}" , name = "modif_Mesure")
     * @param Mesure $mesures
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function modifierMesure(Mesure $mesures,Request $request,EntityManagerInterface $manager){
        $form = $this->createForm(MesureFormType::class, $mesures);
        $form->handleRequest($request);
//enregistrer les mesures
        if($form->isSubmitted() && $form->isValid()){
            $manager->flush();
            return $this->redirectToRoute('detail',[
            'id'=>$mesures->getSalle()->getId()
            ]);
        }
        return $this->render('thermo/creerLesMesures.html.twig',[
            'formMesure' =>$form->createView(),
            'mesuresid' => $mesures
        ]) ;
    }

//fonction supprimer les mesures ok seulement sur la twig gerer les mesures!!
    /**
     * @route ("/creerLesMesures/delete/{id}" , name = "mesure_delete")
     * @ParamConverter("post", options={"id" ="post_id"})
     * @param Mesure $mesures
     * @return Response
     */
    public function supprimerMesures(Mesure $mesures){
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($mesures);
        $manager->flush();
        // return new Response('Salle supprimée');
        return $this->redirectToRoute('affichage_mesure');
        return $this->render('thermo/creerLesMesures.html.twig',[
            'mesure'=>$mesure
        ]);

    }


//afficher les mesures stocké en bdd dans la twig gererLesMesures ok
    /**
     * @route("/gererLesMesures" , name= "affichage_mesure")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param MesureRepository $mesures
     * @return Response
     */
    public function afficherMesure(Request $request,EntityManagerInterface $manager){
        $repository = $this->getDoctrine()->getRepository(Mesure::class);
        $mesures = $repository->findBy(array(), array('date' => 'DESC'));
        return $this->render('thermo/gererLesMesures.html.twig', [
            'mesures' =>$mesures
        ]);
    }

//creation d'une salle dans la twig creerSalle ok
    /**
     * @route("/creerSalle" , name= "creerSalle")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param SalleRepository $repository
     * @return Response
     */
    public function creerSalle(Request $request,EntityManagerInterface $manager, SalleRepository $repository)
    {
        //creation du formulaire d'une salle
        $salles = new Salle();
        $form = $this->createForm(SalleType::class, $salles);
        $form->handleRequest($request);
        //enregistrer le nom de la salle
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($salles);
            $manager->flush();
            return $this->redirectToRoute('salle');
        }
      return $this->render('thermo/creerSalle.html.twig',[
          'formSalle' =>$form->createView(),
            'salles' =>$salles
      ]) ;
}

//affichage de la salle dans la twig gererSalle ok
    /**
     * @route("/gererSalle" , name = "salle")
     * @param SalleRepository $repo
     * @return Response
     */
     public function afficherSalle(Request $request)
      {
          $search =new Salle();
          $formR = $this->createForm(RechercheSalleType::class, $search);
          $formR->handleRequest($request);

          $repo = $this->getDoctrine()->getRepository(Salle::class);
          $salles = $repo->findAll();
          return $this->render('thermo/gererSalle.html.twig',[
              'salles' => $salles,
                  'formR' =>$formR->createView(),
              ]
              );
      }


//Modifier une salle dans la twig gerersalle ok
    /**
     * @Route("/creerSalle/modif/{id}" , name="modif")
     * @param Salle $salles
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function modifierSalle(Salle $salles, Request $request, EntityManagerInterface $manager){

        $form = $this->createForm(SalleType::class, $salles);

        $form->handleRequest($request);

//enregistrer le nom de la salle
        if($form->isSubmitted() && $form->isValid()){

            $manager->flush();

            return $this->redirectToRoute('salle');
        }

        return $this->render('thermo/creerSalle.html.twig',[
            'formSalle' =>$form->createView(),
            'sallesid' =>$salles
        ]) ;
}


//Suprimer une salle dans la twig gererSalle ok
    /**
     * @Route("/gererSalle/delete/{id}" , name="salleDelete")
     * @ParamConverter("post", options={"id" ="post_id"})
     * @param Salle $salle
     * @return Response
     */
    public function supprimerSalle(Salle $salle){
        $manager = $this->getDoctrine()->getManager();
         $manager->remove($salle);
         $manager->flush();

        // return new Response('Salle supprimée');
        return $this->redirectToRoute('salle');

         return $this->render('thermo/gererSalle.html.twig',[
             'salle'=>$salle
         ]);

    }


    /**
     * @Route("/import" , name= "import")
     */
    public function creerImport(Request $request,EntityManagerInterface $manager){
        //creation du formulaire d'un import
        $import = new Import();
        $form = $this->createForm(ImportFormType::class,$import);
        $form->handleRequest($request);
        //enregistrer l'import
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($import);
            $manager->flush();
            return $this->redirectToRoute('vueEnsemble');
        }
        return $this->render('thermo/creerImport.html.twig',[
            'formImport' =>$form->createView(),
        ]) ;

    }

}
