<?php

namespace App\Form;

use App\Entity\Medecin;
use App\Entity\Prescription;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrescriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('dateDebut', DateType::class, [
            'label' => 'Date de début de prescription',
            'html5' => false,
            'required' => true,
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
        ])
        ->add('dateFin', DateType::class, [
            'label' => 'Date de fin de prescription',
            'html5' => false,
            'required' => true,
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
        ])
        ->add('medicaments')
            ->add('medecin', EntityType::class, [
                'class' => Medecin::class,
                'choice_label' => function ($medecin) {
                    return 'Dr. ' . strtoupper($medecin->getNom()) . ' ' . ucfirst(strtolower($medecin->getPrenom())) . ' - ' . $medecin->getSpecialite();
                },
            ])
            ->add('patient', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => function ($user) {
                    if (in_array('ROLE_VISITEUR',$user->getRoles())) {
                        return $user->getNom() . ' ' . $user->getPrenom();
                    }
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Prescription::class,
        ]);
    }
}
