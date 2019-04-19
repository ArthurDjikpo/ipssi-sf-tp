<?php

namespace App\Form;

use App\Entity\Bet;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

class BetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array  $options)
    {
        $builder
            ->add('playerName', TextType::class, [
            'label'=> 'Nom Joueur',])


            ->add('betCase', TextType::class, [
                'label'=> 'Nombre misé',])

            ->add('colorCase', TextType::class, [
                'label'=> 'couleur misé',

            ])

            ->add('money', TextType::class, [
                'label' => 'Montant misé',



            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bet::class,
        ]);
    }
}
