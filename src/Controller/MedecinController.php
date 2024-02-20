<?php
namespace App\Controller;
use App\Entity\Medecin;
use App\Form\MedecinType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


class MedecinController extends AbstractController
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route(path: '/medecin/create', name: 'medecin_create')]
    public function create(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $medecin = new Medecin();
        $form = $this->createForm(MedecinType::class, $medecin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist and flush the Medecin entity
            $entityManager = $this->entityManager;
            $entityManager->persist($medecin);
            $entityManager->flush();

            // Redirect or do whatever is necessary after successful form submission
            return $this->redirectToRoute('medecin_index');
        }

        return $this->render('medecin/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/medecin/index', name: 'medecin_index')]
    public function index(): Response
    {
        // Get all Medecins from the database
        $medecins = $this->entityManager->getRepository(Medecin::class)->findAll();

        // Render the template and pass the Medecins to it
        return $this->render('medecin/index.html.twig', [
            'medecins' => $medecins,
        ]);
    }
}
