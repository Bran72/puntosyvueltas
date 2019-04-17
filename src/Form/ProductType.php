<?php

namespace App\Form;

use App\Entity\Gamme;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, ['label' => 'Nom : '])
            ->add('description', TextareaType::class, ['label' => 'Description : ', 'label_attr' => ['class' => 'label-top'], 'required' => false])
            ->add('Fil', TextareaType::class, ['label' => 'Fil : ', 'label_attr' => ['class' => 'label-top'], 'attr' => ['placeholder' => 'description du fil (nom, composition)'], 'required' => false])
            ->add('taillefils', IntegerType::class, ['label' => 'Taile du fil (m) : ', 'attr' => ['class' => 'number'], 'required' => false])
            ->add('gamme', EntityType::class, ['label' => 'Choisir une gamme : ', 'choice_label' => 'nom', 'class' => Gamme::class, 'label_attr' => ['class' => 'label-gamme']])
            ->add('dimensions', TextType::class, ['label' => 'Dimensions : ', 'attr' => ['placeholder' => 'longueur x largeur'], 'required' => false])
            ->add('duree', IntegerType::class, ['label' => 'Temps de travail : ', 'attr' => ['class' => 'number'], 'required' => false])
            ->add('Surmesure', CheckboxType::class, ['label' => 'Disponnible à la vente : ', 'attr' => ['class' => 'checkbox'], 'required' => false])
            ->add('Prix', IntegerType::class, ['label' => 'Prix : ', 'attr' => ['placeholder' => 'ne pas écrire la devise (€)'], 'attr' => ['class' => 'number'], 'required' => false])
            ->add('Photos', FileType::class, [
                'label' => 'Ajouter des photos : ',
                'multiple' => true,
                'by_reference' => false,
                'required' => false,
                'attr'     => [
                    'accept' => 'image/*',
                ]
            ]);

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function ($event) {
            $builder = $event->getForm(); // The FormBuilder
            $entity = $event->getData(); // The Form Object

            if ($entity["Photos"] == [] || !(isset($entity))) {
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
            } else {
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
