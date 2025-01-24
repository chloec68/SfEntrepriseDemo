<?php

namespace App\Form;

use App\Entity\Employe;
use App\Entity\Entreprise;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class EmployeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, ['attr'=>[
                'class'=> 'form-control'  // là j'ajoute une classe bootstrap
            ]])
            ->add('prenom',TextType::class, ['attr'=>[
                'class'=> 'form-control'
            ]])
            ->add('dateNaissance', DateType::class, [
                'widget' => 'single_text',
                'attr'=>[
                    'class'=> 'form-control'
                ]
            ])
            ->add('dateEmbauche', DateType::class, [
                'widget' => 'single_text',
                'attr'=>[
                    'class'=> 'form-control'
                ]
                
            ])
            ->add('ville',TextType::class, ['attr'=>[
                'required'=> false,   // cohérence avec BDD
                'class'=>'form-control'
            ]])
            ->add('entreprise', EntityType::class, [
                'class' => Entreprise::class, // dès lors qu'on add un EntityType, l'option qui précise la classe à laquelle elle est liée est obligatoire
                'choice_label' => 'raisonSociale',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('valider', SubmitType::class, [
                'attr'=> [
                    'class' => 'btn btn-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employe::class,
        ]);
    }
}
