<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

class MovieController extends Controller {
     /**
     * @Route("/{page}", name="listMovies", requirements={"page"="\d+"},
       * 
       * defaults = {"page" = 1}))
     */
    public function listMoviesAction(Request $request, $page)
    {
        $minYear = $request->query->get("minYear") ? $request->query->get("minYear") : 1900;
        $maxYear = $request->query->get("maxYear") ? $request->query->get("maxYear") : date("Y");
        
        $numPerPage = 56;
        
        $offset = ($page - 1) * $numPerPage;  
        
        //récupération des données dans la BDD via nom de l'entité
        $movieRepo = $this->getDoctrine()->getRepository("AppBundle:Movie");
        
        $moviesNumber = $movieRepo->countAll($minYear, $maxYear); 
        
        $maxPages = ceil($moviesNumber/$numPerPage);
                      
        
        //  en cas d'erreur sur l'affichage des pages dans l'url redirection
        
         if($page > $maxPages)
         {
             return $this->redirect(
                     $this->generateUrl("listMovies", array("page" => $maxPages) )
                     );
         }
         elseif ($page < 1)
         {
             return $this->redirect(
                     $this->generateUrl("listMovies", array("page" => 1))
                     );
         }
                                
        // pour faire un select on utilise le repository de notre entité
        $pageRepository = $this->getDoctrine()->getRepository("AppBundle:Movie");
                                 
        // $movies = $pageRepository->findBy(array(), array("year" => "DESC"), $numPerPage, $offset); remplace !
        
        $movies = $pageRepository->findByYear($minYear, $maxYear, $numPerPage, $offset);
        
        $params = array(
           "movies" => $movies,
           "page" => $page,
           "numPerPage" => $numPerPage,
            "moviesNumber" => $moviesNumber,
            "minYear" => $minYear,
            "maxYear" => $maxYear,
            "maxPages" =>$maxPages
        );        
        
        return $this->render('movie/list_movies.html.twig', $params);
         
         }
        
     /**
     * @Route("/movie/{id}", name="movieDetails")
     */
    public function detailsAction($id) 
    {
        $movieRepo = $this->getDoctrine()->getRepository("AppBundle:Movie");       
        $movie = $movieRepo->find($id);
                
        //render retourne une réponse
        return $this->render('movie/movie_details.html.twig', array("movie" =>$movie));
        
    }
        

}