<?php
namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UserRegistrationFormType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Security;

class AuthController extends AbstractController
{
    private $passwordEncoder;
    
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;

    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordEncoder): Response
    {
        // If the user is already authenticated, redirect them to the homepage or another appropriate route
        if ($this->getUser()) {
            return $this->redirectToRoute('homepage');
        }

        // Handle registration form submission
        $user = new Utilisateur();
        $form = $this->createForm(UserRegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $plaintextPassword = $form->get('password')->getData();

            // hash the password (based on the security.yaml config for the $user class)
            $hashedPassword = $passwordEncoder->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);
            $entityManager = $this->entityManager;
            $entityManager->persist($user);
            $entityManager->flush();

            // Flash success message
            $this->addFlash('success', 'Votre compte a été créé avec succès.');

            // Redirect to login page or another appropriate route
            return $this->redirectToRoute('app_login');
        }

        // Render registration form template
        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
?>