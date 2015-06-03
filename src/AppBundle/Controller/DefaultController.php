<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Acme\StoreBundle\Entity\Movie;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="listMovies")
     */
//    public function indexAction()
//    {
//        return $this->render('default/index.html.twig');
//    }
    
    public function createAction()
{
       
    $em = $this->getDoctrine()->getManager();
    
    $repository = $em->getRepository("AppBundle:Movie");    
       
    $movie = $repository->findBy(
    
    array(),
    
    array('year' => 'ASC'), 50 
);
    return $this->render('default/index.html.twig', array("films" => $movie));
}
     
 }
