<?php

namespace App\Form;

use App\Validator\SymbolExisting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Date;

class CompanyHistoricalDataSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'symbol',
                TextType::class,
                [
                    'constraints' => [
                        new SymbolExisting()
                    ]
                ]
            )
            ->add(
                'startDate',
                TextType::class,
                [
                    'constraints' => [
                        new NotBlank(),
                        new Date(),
                    ]
                ]
            )
            ->add(
                'endDate',
                TextType::class,
                [
                    'constraints' => [
                        new NotBlank(),
                        new Date(),
                        new GreaterThan(
                            [
                                'propertyPath' => 'parent.all[startDate].data'
                            ]
                        ),
                    ]
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'constraints' => [
                        new NotBlank(),
                        new Email(),
                    ]
                ]
            )
            ->add('Submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
