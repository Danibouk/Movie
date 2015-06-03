<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
    
   
                      
class WatchlistController extends Controller{
        /**
        * @Route("/watchlist/add/{movieId}", name="addToWatchlist")
        * 
        * 
        */
    
    public function addToWatchlist($movieId) {
        $user = $this->getuser();
        
        $movieRepo = $this->getDoctrine()->getRepository("AppBundle:Movie");
        $movie = $movieRepo->find($movieId);
        
        $movie->addUser($user);
        $user->addMovie($movie);
        
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        
        $this->addFlash("success", "Le film a bien été ajouté à votre watchlist !");
        return $this->redirect( $this->generateUrl("viewWatchlist") );
    }
    
        /**
        * @Route("/watchlist/remove/{movieId}", name="removeToWatchlist")
        * 
        * 
        */
    
    public function removeToWatchlist($movieId) {
        $user = $this->getuser();
        
        $movieRepo = $this->getDoctrine()->getRepository("AppBundle:Movie");
        $movie = $movieRepo->find($movieId);
        
        $movie->removeUser($user);
        $user->removeMovie($movie);
        
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        
        $this->addFlash("success", "Le film a bien été retiré de votre watchlist !");
        return $this->redirect( $this->generateUrl("viewWatchlist") );
    }
    
        /**
        * @Route("/watchlist", name="viewWatchlist")
        */
    
         public function viewWatchlistAction() {
             
             $user = $this->getUser();
             $movies = $user->getMovies();
             
             $params = array(
                 "movies" => $movies
             );
             
             return $this->render("watchlist/view.html.twig", $params);
             
             
         }
}
