<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\Genre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('genre', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'name',
                'label' => 'Genre personnalise',
                'placeholder' => '-- Selectionnez un genre --',
                'required' => false,
                'attr' => ['class' => 'form-select'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description personnalisee',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 4,
                    'placeholder' => 'Une description personnelle...',
                ],
            ])
            ->add('isPlayed', ChoiceType::class, [
                'label' => 'Statut du jeu',
                'choices' => [
                    'Joue' => true,
                    'A jouer' => false,
                ],
                'expanded' => true,
                'multiple' => false,
                'attr' => ['class' => 'form-check'],
            ])
            ->add('rating', ChoiceType::class, [
                'label' => 'Ma note',
                'required' => false,
                'placeholder' => 'Pas encore noté',
                'choices' => [
                    '⭐ 1/10' => 1,
                    '⭐ 2/10' => 2,
                    '⭐ 3/10' => 3,
                    '⭐ 4/10' => 4,
                    '⭐ 5/10' => 5,
                    '⭐ 6/10' => 6,
                    '⭐ 7/10' => 7,
                    '⭐ 8/10' => 8,
                    '⭐ 9/10' => 9,
                    '⭐ 10/10' => 10,
                ],
                'attr' => ['class' => 'form-select'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
