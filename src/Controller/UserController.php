<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Task;
use App\Form\RegisterType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        //Crear Formulario
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        //Rellenar el objeto con los datos del formulario
        $form->handleRequest($request);

        //Comprobar si se envio el formulario
        if($form->isSubmitted()){
            //Modificando el objeto para guardarlo
            $user->setRole("ROLE_USER");
            $user->setCreatedAt(new \DateTime("now"));

            //Cifrar Contraseña
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);

            var_dump($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute("login");
        }

        return $this->render('user/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function login(AuthenticationUtils $authenticationUtils){
        $error = $authenticationUtils->getLastAuthenticationError();
      
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render("user/login.html.twig", [
            "error" => $error,
            "last_username" =>$lastUsername
        ]);
    }
}
