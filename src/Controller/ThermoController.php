<?php

namespace App\Controller;

use App\Data\Filtres;

use App\Repository\ThermoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormTypeInterface;



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
     * @route("/" , name= "home")
     */
    public function home()
    {


        return $this->render('thermo/home.html.twig'
    );
    }
    /**
     * @route("/vueEnsemble" , name="vueEnsemble")
     */
    public function courbe(ThermoRepository $repository)
    {
        //filtre
        $data = new Filtres();
        $form= $this->createForm(Filtres::class, $data);

        $thermo = $repository->findFiltres();

        return $this->render('thermo/vueEnsemble.html.twig',[
            'thermo' => $thermo,
            'form' =>$form
        ]);
    }


    /**
     * @route("/detail" , name="detail")
     *
     */
    public function affichertableau()
    {


        $tableau = array(
            array(
                'date'=>'01/03/2020',
                'temperature'=>'19',
                'hygrometrie'=>'48'),
            array(
                'date'=>'02/03/2020',
                'temperature'=>'19',
                'hygrometrie'=>'48'),


        );

        //echo $tableau;
        return $this->render('thermo/detail.html.twig',[
            'tableau'=>$tableau,
        ]);
    }

}
