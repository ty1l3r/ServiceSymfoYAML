<?php

namespace App\Form;

use App\Entity\Organizations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrganizationAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('userName', TextType::class)
            ->add('userRole', ChoiceType::class, [
                'choices' => [
                    '["ADMIN,CTO"]' => "ADMIN,CTO",
                    '["ADMIN, CEO"]' => "ADMIN, CEO",
                    '["SALES"]' => "SALES",
                ],
                'choice_attr' => [
                    '["ADMIN", "CTO"]' => ['data-color' => 'Red'],
                    '["ADMIN", "CEO"]' => ['data-color' => 'Yellow'],
                    '["SALES"]' => ['data-color' => 'Green'],
                ],
            ])

            ->add ('valider', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Organizations::class,
        ]);
    }
}
