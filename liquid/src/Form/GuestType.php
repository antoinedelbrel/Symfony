<?php

namespace App\Form;

use App\Entity\Guest;
use App\Form\EventType;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class GuestType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                $this->getConfiguration("Invité", "Tapez le nom de votre invité"),
            )
            ->add(
                'email',
                EmailType::class,
                $this->getConfiguration("Email", "Entrez l'adresse mail de votre invité"),
            )
            ->add(
                'slug',
                TextType::class,
                $this->getConfiguration("Adresse web", "Tapez l'adresse web (automatique)")
            )
            // ->add(
            //     'events',
            //     CollectionType::class,
            //     [
            //         'entry_type' => EventType::class,
            //         'entry_options' => ['label' => false],
            //         'allow_add' => true,
            //     ]
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Guest::class,
        ]);
    }
}
