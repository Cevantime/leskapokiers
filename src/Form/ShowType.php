<?php

namespace App\Form;

use App\DataTransformer\ArtistCollectionTransformer;
use App\DataTransformer\ArtistTransformer;
use App\Entity\Show;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShowType extends AbstractType
{
    /**
     * @var ArtistCollectionTransformer
     */
    private $artistCollectionTransformer;

    /**
     * @var ArtistTransformer
     */
    private $artistTransformer;

    /**
     * ShowType constructor.
     * @param ArtistCollectionTransformer $artistCollectionTransformer
     * @param ArtistTransformer $artistTransformer
     */
    public function __construct(
        ArtistCollectionTransformer $artistCollectionTransformer,
        ArtistTransformer $artistTransformer
    ) {
        $this->artistCollectionTransformer = $artistCollectionTransformer;
        $this->artistTransformer = $artistTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('creationDate', DateType::class, [
                'label' => 'Date de création'
            ])
            ->add('summary', CKEditorType::class, [
                'required' => false,
                'label' => 'Résumé'
            ])
            ->add('tape', UrlType::class, [
                'label' => 'Lien vers une vidéo',
                'required' => false,
            ])
            ->add('critics', CKEditorType::class, [
                'label' => 'Critiques',
                'required' => false,
            ])
            ->add('rewards', CKEditorType::class, [
                'label' => 'Récompenses',
                'required' => false,
            ])
            ->add('images', CollectionType::class, [
                'label' => 'Gallerie d\'images',
                'entry_type' => MediumType::class,
                'entry_options' => [
                    'mime_filters' => 'image/png,image/jpeg,image/gif,image/jpg'
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'prototype' => true
            ])
            ->add('presskit', MediumType::class, [
                'label' => 'Dossier de presse',
                'mime_filters' => 'application/pdf',
                'upload_directory' => 'Dossiers de Presse',
                'required' => false
            ])
            ->add('bigImage', MediumType::class, [
                'label' => 'Image de couverture',
                'upload_directory' => 'Grandes images',
                'mime_filters' => 'image/png,image/jpeg,image/gif,image/jpg'
            ])
            ->add('smallImage', MediumType::class, [
                'label'=>'Petite image',
                'upload_directory' => 'Petites images',
                'mime_filters' => 'image/png,image/jpeg,image/gif,image/jpg'
            ])
            ->add('actors', TextType::class, [
                'required' => false
            ])
            ->add('author', ChoiceType::class, [
                'required' => false
            ])
            ->add('director', ChoiceType::class, [
                'required' => false
            ])
        ->get('actors')->addModelTransformer($this->artistCollectionTransformer);
        $builder->get('author')->resetViewTransformers();
        $builder->get('author')->addModelTransformer($this->artistTransformer);
        $builder->get('director')->resetViewTransformers();
        $builder->get('director')->addModelTransformer($this->artistTransformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Show::class,
        ]);
    }
}
