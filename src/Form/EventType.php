<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\TypeEvent;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre :'
            ])
            ->add('typeevent', EntityType::class, [
                'class' => TypeEvent::class,
                'choice_label' => 'name',
                'label' => 'Type de l\'événement :'
            ])
            ->add('date', null, [
                'widget' => 'single_text',
                'label' => 'Date :'
            ])
            ->add('time', null, [
                'widget' => 'single_text',
                'label' => 'L\'heure'
            ])
            ->add('location',TextType::class, [
                'label' => 'Lieu :'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description : '
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'L\'image :'
            ])
//            ->add('organiser', EntityType::class, [
//                'class' => User::class,
//                'choice_label' => 'name',
//                'label' => 'Type de l\'événement'
//            ])
            ->add('save', SubmitType::class, [
                'label' => 'Valider'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
