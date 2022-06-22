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
                    'placeholder' => 'Criteria\'s name',
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
                    'placeholder' => 'Reference index',
                ),
                'label' => 'Index : ',
            ))
            ->add('perimeter', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Scale',
                ),
                'label' => 'Perimeter : ',
            ))
            ->add('coefficient', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Coefficient',
                ),
                'label' => 'Coefficient : ',
            ))
            ->add('methodology', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'How the score is calculated',
                ),
                'label' => 'Methodology : ',
            ))
            ->add('pin', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Pin',
                ),
                'label' => 'Pin : ',
            ))
            ->add('category', EntityType::class, array(
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose a category',
                'label' => 'Category',
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
