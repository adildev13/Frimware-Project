<?php

namespace App\Form;

use App\Entity\SoftwareVersion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SoftwareVersionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('systemVersion', TextType::class)
            ->add('systemVersionAlt', TextType::class)
            ->add('link', TextType::class, ['required' => false])
            ->add('st', TextType::class, ['required' => false])
            ->add('gd', TextType::class, ['required' => false])
            ->add('latest', CheckboxType::class, ['required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SoftwareVersion::class,
        ]);
    }
}
