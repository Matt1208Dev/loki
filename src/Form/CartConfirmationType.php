<?php

namespace App\Form;

use App\Entity\Rent;
use App\Entity\Owner;
use App\Entity\Apartment;
use App\Repository\OwnerRepository;
use App\Repository\ApartmentRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CartConfirmationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('apartment', EntityType::class,[
                'label' => "Appartement",
                'placeholder' => "-- Choisir --",
                'class' => Apartment::class,
                'choice_label' => function ($apartment) {
                    return $apartment->getOwner()->getlastName() . " " . $apartment->getOwner()->getFirstName() . " - " . $apartment->getStreet() . " " . $apartment->getZip() . ", " . $apartment->getCity() ;
                }
            ])
            ->add('startingDate', DateType::class,[
                'label' => "Date d'entrée",
                
            ])
            ->add('endingDate', DateType::class,[
                'label' => "Date de sortie",
                
            ])
            ->add('rentType', ChoiceType::class,[
                'label' => "Type de location",
                'choices' => [
                    'Normale' => Rent::RENT_NORMAL,
                    'En ligne' => Rent::RENT_ONLINE
                    ]
            ])
            ->add('deposit', ChoiceType::class,[
                'label' => "Type de caution",
                'choices' => [
                    'En ligne' => Rent::DEPOSIT_ONLINE,
                    'Propriétaire' => Rent::DEPOSIT_OWNER,
                    'Chèque bancaire' => Rent::DEPOSIT_PAY_CHEQUE
                    ]
            ])
            ->add('comment', TextareaType::class, [
                'label' => "Commentaire",
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rent::class,
        ]);
    }
}
