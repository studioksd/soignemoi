<?php
namespace App\Controller;

use App\Entity\Utilisateur;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\UserDemandeResetPasswordType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class MainController extends AbstractController
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

    #[Route('/user/dashboard', name: 'user_dashboard')]
    public function userDashboard(): Response
    {
        $user = $this->getUser();
        
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $sejours = $user->getSejours();

        return $this->render('user/dashboard.html.twig', [
            'user' => $user,
            'sejours' => $sejours
        ]);
    }

    #[Route('/user/{id}/show', name: 'user_show')]
    public function userShow($id): Response
    {
        $user = $this->entityManager->getRepository(Utilisateur::class)->find($id);

        if (!$user) {
            return $this->redirectToRoute('home');
        }

        $sejours = $user->getSejours();
        $prescriptions = $user->getPrescriptions();
        $avis = $user->getAvisMedecins();

        return $this->render('user/dossier.html.twig', [
            'user' => $user,
            'sejours' => $sejours,
            'prescriptions' => $prescriptions,
            'avis' => $avis,
        ]);
    }

    #[Route('/user/index', name: 'user_index')]
    public function userIndex(): Response
    {
        $users = $this->entityManager->getRepository(Utilisateur::class)->findAll();

        if (!$users) {
            return $this->redirectToRoute('home');
        }

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

}