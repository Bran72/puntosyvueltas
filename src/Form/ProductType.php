<?php

namespace App\Form;

use App\Entity\Gamme;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('Photos')
            ->add('Prix')
            ->add('Fil')
            ->add('Surmesure')
            ->add('gamme', EntityType::class, ['label' => 'Choisir une gamme', 'choice_label' => 'nom', 'class' => Gamme::class, 'label_attr' => array('class' => 'choose_gamme')])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
