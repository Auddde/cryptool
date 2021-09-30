<?php

namespace App\Form;

use App\Entity\Wallet;
use App\Entity\WalletCategory;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class WalletType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('uuid')
            ->add('name')
            ->add('description')

            ->add('walletcategory', EntityType::class, [
                'class' => WalletCategory::class,
                'choice_label' => 'name',
            ])

            //->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wallet::class,
        ]);
    }
}
