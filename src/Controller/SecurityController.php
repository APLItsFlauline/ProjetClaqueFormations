<?php

namespace App\Controller;

use App\Form\RegistrationType;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder) {

        if($this->isGranted('ROLE_USER')){
            return $this->redirectToRoute('home');
        }

        $user= new User();

        $form=$this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $teacher = $user->getIsTeacher();

            if($teacher) {
                $user->setRoles(['ROLE_TEACHER']);}
            else {
                $user->setRoles(['ROLE_USER']);
            }

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Vous vous êtes bien inscrit!'
            );

            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/connexion",name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response{

        if($this->isGranted('ROLE_USER')){
            return $this->redirectToRoute('home');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['lastUsername' => $lastUsername, 'error' => $error]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/deconnexion",name="security_logout")
     */
    public function logout() {
        $this->addFlash(
            'success',
            'Vous vous êtes bien déconnecté!'
        );
    }
}
