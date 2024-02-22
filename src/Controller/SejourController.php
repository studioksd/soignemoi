<?php
namespace App\Controller;

use App\Entity\Sejour;
use App\Form\SejourType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

class SejourController extends AbstractController
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route(path: '/sejour/create', name: 'sejour_create')]
    public function create(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_VISITEUR');

        $sejour = new Sejour();

        $user = $this->getUser();
        $sejour->setUtilisateur($user);

        $form = $this->createForm(SejourType::class, $sejour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();

            $sejour->setUtilisateur($user);

            $entityManager = $this->entityManager;
            $entityManager->persist($sejour);
            $entityManager->flush();

            return $this->redirectToRoute('user_dashboard');
        }

        // Render a form template to create a new Sejour
        return $this->render('sejour/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/sejour/index', name: 'sejour_index')]
    public function index(): Response
    {
        // Get all Medecins from the database
        $sejours = $this->entityManager->getRepository(Sejour::class)->findAll();

        // Render the template and pass the Medecins to it
        return $this->render('sejour/index.html.twig', [
            'sejours' => $sejours,
        ]);
    }
}
