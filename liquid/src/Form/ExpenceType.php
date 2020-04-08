<?php

namespace App\Form;

use App\Entity\Expence;
use App\Form\EventType;
use App\Form\GuestType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ExpenceType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                $this->getConfiguration("Nom", "Qu'avez vous acheté")
            )
            ->add(
                'price',
                MoneyType::class,
                $this->getConfiguration("Prix", "Combien ça vous a couté")
            )
            ->add(
                'guest',
                CollectionType::class,
                [
                    'entry_type' => GuestType::class,

                ]
            )
            ->add(
                'event',
                CollectionType::class,[
                    'entry_type' => EventType::class,
                    
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Expence::class,
        ]);
    }
}
