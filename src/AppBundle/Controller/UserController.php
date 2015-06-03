<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

use AppBundle\Entity\User;
use AppBundle\Form\RegistrationType;
use AppBundle\Form\ChangePasswordType;
use AppBundle\Form\LostPasswordType;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class UserController extends Controller 
{
    
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        if($this->getUser()) {
            return $this->redirect($this->generateUrl("listMovies"));
        }
        
        $session = $request->getSession();

    // get the login error if there is one
    if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
        $error = $request->attributes->get(
            Security::AUTHENTICATION_ERROR
        );
    } elseif (null !== $session && $session->has(Security::AUTHENTICATION_ERROR)) {
        $error = $session->get(Security::AUTHENTICATION_ERROR);
        $session->remove(Security::AUTHENTICATION_ERROR);
    } else {
        $error = '';
    }
      // last username entered by the user
    $lastUsername = (null === $session) ? '' : $session->get(Security::LAST_USERNAME);

    return $this->render(
        'User/login.html.twig',
        array(
            // last username entered by the user
            'last_username' => $lastUsername,
            'error'         => $error,
            )
        );
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
        
    }
    
     /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        
    }
            
    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request)
    {
        
        if($this->getUser()) {
            return $this->redirect($this->generateUrl("listMovies"));
        }
        
//on crée un utilisateur vide
        $user = new User();
        
        //on récupère une instance du formulaire associé à l'utilisateur vide
        $registrationForm = $this->createForm(new RegistrationType(), $user);
        
        //traitement du formulaire
        $registrationForm->handleRequest( $request);
//        dump($user);
        
        
        if( $registrationForm->isValid() ){
            //hydrate les autres propriétes du User
            
            //générer un salt
            $salt = $this->get('string_helper')->randomString(50); 
            $user->setSalt( $salt );
            
            //générer un token
            $token = $this->get('string_helper')->randomString(30); 
            $user->setToken( $token);
            
//            dump($user);
            
            //hacher le mot de passe sha 512, 5000 fois
            $encoder = $this->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $user->getPassword() );
            $user->setPassword( $encoded );
            
            // date d'inscription et de modification
            $user->setDateRegistered( new\DateTime() );
            $user->setDateModified( new\DateTime() );
            
            //assigne toujours ce rôle auxs utilisateurs du front office
            $user->setRoles( array("ROLE_USER") );
            
            //sauvegarde le User en BDD
            $em = $this->get("doctrine")->getManager();
            $em->persist( $user );
            $em->flush();
            
        }
        
        // on shoot le formulaire à twig (on n'oublie pas le createView !)
        $params = array(
            "registrationForm" => $registrationForm->createView()
                );
               
        return $this->render('User/register.html.twig', $params);
    }
       
    
     /**
     * @Route("/forgot_password", name="forgotPassword")
     */
    public function forgotPasswordAction(Request $request)
    {
        $user = new User();
        
        $lostPasswordForm = $this->createForm(new LostPasswordType(), $user);
        
         //injecte les données postées dans notre $user
        $lostPasswordForm->handleRequest( $request );
        
        //si soumis, traiter le formulaire contenant l'email
        if ($lostPasswordForm->isValid()){
            
        }
        //si l'email existe en base de donnée
        $userRepo = $this->getDoctrine()->getRepository("AppBundle:User");
        $foundUser = $userRepo->findOneByEmail( $user->getEmail() );
        
         //si on a trouvé le user en bdd
        if($foundUser) {
        
        $message = \Swift_Message::newInstance()
                ->setCharset("utf-8")
                ->setSubject("Bonjour site Movies")
                ->setFrom(array('peyacom@mail.com' => "Movies"))
                ->setTo("peyae@yahoo.fr")
                ->setBody($this->renderView
                        ("email/forgot_password_email.html.twig", 
                        array("user" =>$foundUser)), "text/html");
        
        $this->get('mailer')->send($message);
        
        // demande à l'utilisateur d'aller consulter ses mails
        return $this->render("User/lost_password_check.html.twig");
                
    }
    else {
        // prévenir l'utilisateur de l'erreur
         $this->addFlash("error", "This email is not registered here.");
        
    }
  
   return $this->render("User/forgot_password_email.html.twig", 
           array( "lostPasswordForm" => $lostPasswordForm->createView()
           ));
   
}


        /**
         * L'utilisateur ayant oublié son mdp aboutira sur cette page après avoir cliqué sur le lien reçu par email
         * Cette page redirige toujours vers une autre page
         * @Route("/test_email_token/{email}/{token}", name="checkEmailToken")
         */
        public function checkEmailTokenAction($email, $token) {

                    //faire une requête en bdd pour récupérer l'utilisateur ayant cet email ET ce token
                $userRepo = $this->getDoctrine()->getRepository("AppBundle:User");
                $userFound= $userRepo->findOneBy(
                array("email" => $email, "token" => $token)
                );
                
                //** faire bcp de tests pour s'assurer qu'il n'y a pas de faille **
                //éventuellement, ralentir volontairement ce code pour limiter les attaques en brute force
                sleep(1);
                
                //si l'utilisateur est trouvé
                if ($userFound){
                    
                //connecter programmatiquement l'utilisateur trouvé
                $token = new UsernamePasswordToken($userFound, null, "secured_area", $userFound->getRoles());
                $this->get("security.context")->setToken($token); //now the user is logged in
               
                //now dispatch the login event
                $request = $this->get("request");
                $event = new InteractiveLoginEvent($request, $token);
                $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
                
                //rediriger vers une autre page qui affichera et traitera le formulaire de nouveau mdp
                return $this->redirect($this->generateUrl("changePassword"));
        }
                //sinon
                //le rediriger vers l'accueil ou vers un site pour mécréant
                return $this->redirect( $this->generateUrl("listMovies") );
        }
        /**
        * Cette page affiche et traite le formulaire de changement de mot de passe
        * L'utilisateur doit être connecté pour y accéder
        * @Route("/User/change_password", name="changePassword")
        */
        public function changePasswordAction(Request $request)
        {
        //récupère le user loggué depuis la session
        $user = $this->getUser();
        $changePasswordForm = $this->createForm(new ChangePasswordType(), $user);
        $changePasswordForm->handleRequest($request);
        if ($changePasswordForm->isValid()){
            
        //générer un nouveau token
        $token = $this->get('string_helper')->randomString(30);
        $user->setToken( $token );
        
        //hacher le mot de passe
        $encoder = $this->get('security.password_encoder');
        $encoded = $encoder->encodePassword( $user, $user->getPassword() );
        $user->setPassword( $encoded );
        
        //on change la dernière date de modif
        $user->setDateModified( new \DateTime() );
        
        //sauvegarde le User en bdd
        $em = $this->getDoctrine()->getManager();
        $em->persist( $user );
        $em->flush();
        $this->addFlash("success", "New password saved !");
        return $this->redirect( $this->generateUrl("listMovies") );
        }
        return $this->render("User/change_password.html.twig", array("changePasswordForm" => $changePasswordForm->createView()));
        }

}
