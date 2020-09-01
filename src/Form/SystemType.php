<?php

namespace App\Form;

use App\Entity\System;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SystemType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $currencyOptions = array(
            "PLN" => "PLN",
            "EUR" => "EUR",
            "USD" => "USD"
        );
        $defaultCurrency = "PLN";

        $builder
                ->add('CompanyName', TextType::class, [
                    'label' => 'Company Name',
                ])
                ->add('CompanyAddress', TextareaType::class,  [
                    'label' => 'Company Address',
                ])
                ->add('CompanyTaxID', TextType::class,  [
                    'label' => 'Company Tax ID',
                ])
                ->add('DefaultCurrency', ChoiceType::class,
                        ['choices' => $currencyOptions,
                            'data' => $defaultCurrency,
                            'label' => 'Default Currency',
                ])
                ->add('CompanyAccount', TextType::class,  [
                    'label' => 'Company Account',
                ])
                ->add('DefaultVat', IntegerType::class,  [
                    'label' => 'Default VAT',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => System::class,
        ]);
    }

}
