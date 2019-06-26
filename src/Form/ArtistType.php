<?php

namespace App\Form;

use App\Entity\Artist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArtistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudonym', TextType::class, [
                'required' => true,
                'label' => "Nom d'usage"
            ])
            ->add('firstname')
            ->add('lastname')
            ->add('photo', MediumType::class, [
                'required' => false,
                'label' => 'Photo'
            ])
            ->add('bio')
            ->add('age')
            ->add('gender')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Artist::class,
        ]);
    }
}
