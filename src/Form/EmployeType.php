<?php

namespace App\Form;

use App\Entity\Employes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class EmployeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom')
            ->add('nom')
            ->add('telephone', null , [
                'help' => 'Les chiffres peuvent être séparés par un espace, un point ou un tiret'
            ])
            ->add('email')
            ->add('adresse')
            ->add('poste')
            ->add('salaire', null , [
                'help' => 'Le salaire doit être positif ou nul'
            ])
            ->add('datedenaissance', DateType::class, array(
                'widget' => 'choice',
                'years' => range(date('Y')-100, date('Y')-14),
                'format' => 'dd MMMM yyyy', 
                'help' => 'La date doit être au format jj/mm/aaaa'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employes::class,
        ]);
    }
}
