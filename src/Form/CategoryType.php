<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Nom de la catégorie',
                ),
                'label' => 'Nom : ',
            ))
            ->add('image', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Ajouter l\'URL de l\'image',
                ),
                'label' => 'Image : ',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
