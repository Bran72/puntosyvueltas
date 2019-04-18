<?php

namespace App\Form;

use App\Entity\Gamme;
use App\Entity\Product;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, ['label' => 'Nom', 'attr'=>['placeholder'=>'cequetuveux']])
            ->add('description')
            ->add('Prix')
            ->add('Fil')
            ->add('Surmesure')
            ->add('gamme', EntityType::class, ['label' => 'Choisir une gamme', 'choice_label' => 'nom', 'class' => Gamme::class, 'label_attr' => array('class' => 'choose_gamme')])
            ->add('dimensions')
            ->add('duree')
            ->add('taillefils')
            ->add('Photos', FileType::class, [
                'multiple' => true,
                'by_reference' => false,
                'required' => false,
                'attr'     => [
                    'accept' => 'image/*',
                ]
            ])
        ;

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function ($event) {
            $builder = $event->getForm(); // The FormBuilder
            $entity = $event->getData(); // The Form Object

            if($entity["Photos"] == [] || !(isset($entity))){
                dump('empty photos: get them from Database');
                $builder
                ->add('Photos', FileType::class, [
                    'multiple' => true,
                    'by_reference' => false,
                    'required' => false,
                    'attr'     => [
                        'accept' => 'image/*',
                    ]
                ])
                ->add('titre');
            }else{
                dump('you can update photos');
            }
            dump($entity);
            dump($entity["Photos"]);
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
