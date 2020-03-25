<?php

namespace App\Form;

use App\Entity\Event;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EventType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                $this->getConfiguration("Name", "Tapez le nom de votre évenement")
            )
            ->add(
                'slug',
                TextType::class,
                $this->getConfiguration("Adresse web", "Tapez l'adresse web (automatique)")
            )
            ->add(
                'date',
                DateType::class,
                $this->getConfiguration("Date de l'évenement", "La date de votre évenement")
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
