<?php

namespace App\Form;

use App\DataTransformer\MediumTransformer;
use App\Entity\Medium;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of GalleryImageType
 *
 * @author cevantime
 */
class MediumType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('apiId', HiddenType::class)
            ->add('mimeType', HiddenType::class)
            ->add('source', HiddenType::class)
            ->add('browsed', ButtonType::class, [
                'label' => 'Choisir dans mes fichiers'
            ])
            ->add('uploaded', FileType::class, [
                'label' => false,
                'required' => false
            ]);

        $builder->addEventListener(FormEvents::POST_SUBMIT, function(FormEvent $form) use($options) {
           if( $form->getForm()->getData() && ! $form->getForm()->getData()->getDirectoryTarget()) {
               $form->getForm()->getData()->setDirectoryTarget($options['upload_directory']);
           }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Medium::class,
            'mime_filters' => 'all',
            'opened_folder' => '/',
            'upload_directory' => '/'
        ));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);
        $view->vars = array_merge($view->vars, [
            'mime_filters' => $options['mime_filters'],
            'opened_folder' => $options['opened_folder'],
            'upload_directory' => $options['upload_directory']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'medium';
    }
}
