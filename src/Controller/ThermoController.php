<?php

namespace App\Controller;



use App\Entity\Salle;
use App\Entity\Thermo;
use App\Form\SallesType;
use App\Form\SalleType;
use App\Form\ThermohType;
use App\Repository\SalleRepository;
use App\Repository\ThermoRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function courbe()
    {
        $repo = $this->getDoctrine()->getRepository(Salle::class);

        $salles = $repo->findAll();

        //filtre
       // $data = new Filtres();
      //  $form = $this->createForm(Filtres::class, $data);

     //  $thermo = $repository->findFiltres();

        return $this->render('thermo/vueEnsemble.html.twig',[
            'salles' =>$salles
        ]);
    }

    //fonction pour creer un thermo

    /**
     * @route("/detail" , name="creerThermo")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param ThermoRepository $repository
     * @return Response
     */

    public function creerThermo(Request $request, EntityManagerInterface $manager,ThermoRepository $repository)
    {
        // création  du formulaire
        $thermoh = new Thermo();

        $form = $this->createForm(ThermohType::class , $thermoh);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager-> persist($thermoh);
            $manager-> flush();

            return $this->redirectToRoute('creerThermo');
        }

        return $this->render('thermo/detail.html.twig', [
            'formThermoh' => $form->createView(),
            'thermoh'=>$thermoh,
        ]);

    }

    /**
     * @route("/detail" , name="detail")
     * @param ThermoRepository $repo
     * @return Response
     */
    public function afficherDetail()
    {

        $repo = $this->getDoctrine()->getRepository(ThermoRepository::class);

        $thermos = $repo->findAll();

        return $this->render('thermo/gererSalle.html.twig',[
                'thermos' => $thermos,
            ]
        );

         //$tabThermos = array(
         //  'date' =>'03/01/2020',
         //   'temperature'=>25,
          //  'hygrometrie' => 35,

       // );

//essaie pour afficher ce que j'insere dans le textatrea
            //if (isset($_POST['copier/coller']))
            //  echo $_POST['copier/coller'];

//var_dump($tabThermos);



       // $repository = $this->getDoctrine()->getRepository(Thermo::class);
      //  $thermo = $repository->findAll();


      //  return $this->render('thermo/detail.html.twig'
      //      , [
                //'thermo' => $thermo,
         //     'tabThermos' => $tabThermos,


         //  ]);
    }



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
   //$select = mysqli_query($conn,"SELECT * FROM nom = "'".$_POST['nom']"'");

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
    //gerer les salles
//par la suite afficher le detail des salles par leur id?
    /**
     * @route("/gererSalle" , name = "salle")
     * @param $id
     * @return Response
     */
  /*  public function afficherSalle($id)
    {
        $repository = $this->getDoctrine()->getRepository(Salle::class);
        $salles = $repository->find($id);


        return $this->render('thermo/gererSalle.html.twig',[
            'salles' => $salles,
        ]);

    }*/


    /**
     * @route("/gererSalle" , name = "salle")
     * @param SalleRepository $repo
     * @return Response
     */
     public function afficherSalle()
      {
          $repo = $this->getDoctrine()->getRepository(Salle::class);

          $salles = $repo->findAll();

          return $this->render('thermo/gererSalle.html.twig',[
              'salles' => $salles
              ]
              );
      }

      //Modifier une salle

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
            'salles' =>$salles
        ]) ;
}
      //Suprimer une salle ok
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
     * @route("/detail" , name= "graph")
     * @return Response
     */

    public function creerGraphique(){
        //$graph1=new Chart();

        return $this->render('thermo/detail.html.twig');
    }

}
