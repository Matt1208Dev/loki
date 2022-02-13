<?php

namespace App\Form;

use App\Entity\Owner;
use App\Entity\Apartment;
use App\Repository\OwnerRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ApartmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('street', TextType::class, [
                'label' => 'Adresse',
                'attr' => [
                    'placeholder' => 'Entrez le numéro et la rue'
                ],
                'required' => false
            ])
            ->add('zip', TextType::class, [
                'label' => 'Code postal',
                'attr' => [
                    'placeholder' => 'Entrez le code postal'
                ],
                'required' => false
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => 'Entrez la ville'
                ],
                'required' => false
            ])
            ->add('owner', EntityType::class, [
                'label' => 'Propriétaire',
                'placeholder' => '-- Sélectionner un propriétaire --',
                'class' => Owner::class,
                'query_builder' => function (OwnerRepository $ownerRepository) {
                    return $ownerRepository->createQueryBuilder('o')
                        ->orderBy('o.lastName', 'ASC');
                },
                'choice_label' => function (Owner $owner) {
                    return $owner->getLastName() . " " . $owner->getFirstName();
                },
                'required' => false
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Commentaire',
                'attr' => [
                    'placeholder' => 'Complément d\'adresse, observations...'
                ],
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Apartment::class,
        ]);
    }
}
