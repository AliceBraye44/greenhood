<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Criteria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CriteriaType extends AbstractType
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
            ->add('data', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Data link',
                ),
                'label' => 'Data : ',
            ))
            ->add('indexReference', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Index de référence',
                ),
                'label' => 'Index : ',
            ))
            ->add('perimeter', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Perimeter',
                ),
                'label' => 'Perimeter : ',
            ))
            ->add('coefficient', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Coefficient d\'importance',
                ),
                'label' => 'Coefficient : ',
            ))
            ->add('methodology', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Comment est calculée la note de ce critère',
                ),
                'label' => 'Méthodologie : ',
            ))
            ->add('pin', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Pin sur la map',
                ),
                'label' => 'Pin : ',
            ))
            ->add('category', EntityType::class, array(
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisir une catégorie',
                'label' => 'Catégorie',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Criteria::class,
        ]);
    }
}
