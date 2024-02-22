<?php
namespace App\Controller;
use App\Entity\Medecin;
use App\Entity\Utilisateur;
use App\Entity\Prescription;
use App\Entity\AvisMedecin;
use App\Form\MedecinType;
use App\Form\PrescriptionType;
use App\Form\AvisMedecinType;
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

    #[Route('/prescriptions/create', name: 'prescription_create')]
    public function createPrescriptions(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MEDECIN');
        $prescription = new Prescription();
        $prescriptionForm = $this->createForm(PrescriptionType::class, $prescription);
    
        $prescriptionForm->handleRequest($request);
    
        if ($prescriptionForm->isSubmitted() && $prescriptionForm->isValid()) {
            $medicamentLibelles = $request->get('medicament_libelle');
            $medicamentPosologies = $request->get('medicament_posologie');

            $medicamentInfo = [];
            if ($medicamentLibelles && $medicamentPosologies) {
                foreach ($medicamentLibelles as $index => $libelle) {
                    $posologie = $medicamentPosologies[$index];
                    $medicamentInfo[$index] = ['libelle' => $libelle, 'posologie' => $posologie];
                }
            }
            

            $prescription->setMedicaments($medicamentInfo);
            $patient = $prescriptionForm->get('patient')->getData();
            $medecin = $prescriptionForm->get('medecin')->getData();
            $entityManager = $this->entityManager;
            $entityManager->persist($prescription);
            $entityManager->flush();
    
            // Redirect to the route for creating AvisMedecin
            return $this->redirectToRoute('avis_medecin_create', ['prescriptionId' => $prescription->getId(), 'patientId' => $patient->getId(), 'medecinId' => $medecin->getId()]);
        }
    
        // Render the prescription form view
        return $this->render('prescription/create.html.twig', [
            'prescriptionForm' => $prescriptionForm->createView(),
            
        ]);
    }
    
    #[Route('/avis-medecins/create/{medecinId}/{patientId}/{prescriptionId}', name: 'avis_medecin_create')]
    public function createAvisMedecins(Request $request, int $prescriptionId, int $patientId, int $medecinId): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MEDECIN');
        $avisMedecin = new AvisMedecin();
        $patient = $this->entityManager->getRepository(Utilisateur::class)->find($patientId);
        $medecin = $this->entityManager->getRepository(Medecin::class)->find($medecinId);
        $avisMedecin->setPatient($patient);
        $avisMedecin->setMedecin($medecin);
        $avisMedecinForm = $this->createForm(AvisMedecinType::class, $avisMedecin);
    
        $avisMedecinForm->handleRequest($request);
    
        if ($avisMedecinForm->isSubmitted() && $avisMedecinForm->isValid()) {
            // Get the prescription entity
            $entityManager = $this->entityManager;
            $prescription = $entityManager->getRepository(Prescription::class)->find($prescriptionId);
    
            if (!$prescription) {
                throw $this->createNotFoundException('Prescription not found.');
            }
    
            // Persist the avis medecin entity and associate it with the prescription
            
            $avisMedecin->setPrescription($prescription);
            $entityManager->persist($avisMedecin);
            $entityManager->flush();
    
            // Redirect or display a success message
            $this->addFlash('success', 'AvisMedecin created successfully.');
            return $this->redirectToRoute('user_show', ['id' => $patientId]);
        }
    
        // Render the avis medecin form view
        return $this->render('avis_medecin/create.html.twig', [
            'avisMedecinForm' => $avisMedecinForm->createView(),
            'prescriptionId' => $prescriptionId,
            'patientId' => $patientId,
            'medecinId' => $medecinId
        ]);
    }
    
}
