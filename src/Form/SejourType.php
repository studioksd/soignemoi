<?php

namespace App\Form;

use App\Entity\Medecin;
use App\Entity\Sejour;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



class SejourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut', DateType::class, [
                'label' => 'Date de début du séjour',
                'html5' => false,
                'required' => true,
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
            ])
            ->add('dateFin', DateType::class, [
                'label' => 'Date de fin du séjour',
                'html5' => false,
                'required' => true,
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
            ])
            ->add('motif', TextType::class, [
                'label' => 'Motif du séjour',
                'required' => true,
            ])
            ->add('specialiteNecessaire', ChoiceType::class, [
                'label' => 'Spécialité nécessaire',
                'choices' => [
                    'Cardiologie' => 'Cardiologie',
                    'Pédiatrie' => 'Pédiatrie',
                    'Gynécologie' => 'Gynécologie',
                    'Orthopédie' => 'Orthopédie',
                    'Neurologie' => 'Neurologie',
                    'Dermatologie' => 'Dermatologie',
                    'Ophtalmologie' => 'Ophtalmologie',
                ]                
            ])
            ->add('utilisateur', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'id',
            ])
            ->add('medecin', EntityType::class, [
                'class' => Medecin::class,
                'choice_label' => function ($medecin) {
                    return $medecin->getNom() . ' ' . $medecin->getPrenom() . ' - ' . $medecin->getSpecialite();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sejour::class,
        ]);
    }
}
