<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\User;
use AppBundle\Form\RegistrationType;

class UserController extends Controller 
{
    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request)
    {
        //on crée un utilisatuer vide
        $user = new User();
        
        //on récupère une instance du formulaire associé à l'utilisateur vide
        $registrationForm = $this->createForm(new RegistrationType(), $user);
        
        //traitement du formulaire
        $registrationForm->handleRequest( $request);
        
        
        if( $registrationForm->isValid() ){
            //hydrate les autres propriétes du User
            
            //hacher le mot de passe
            
            //générer un salt
            $salt = md5(uniqid() );
            $user->setSalt( $salt );
            
            //générer un token
            $token = md5(uniqid() );
            $user->setToken( $token);
            
            
            //date d'inscription et de modification
            
            //sauvegarde le User en BDD
            dump($user);
        }
        
        // on shoot le formulaire à twig (on n'oublie pas le createView !)
        $params = array(
            "registrationForm" => $registrationForm->createView()
                );
               
        return $this->render('User/register.html.twig', $params);
    }
}
