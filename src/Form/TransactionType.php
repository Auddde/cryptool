<?php

namespace App\Form;

use App\Entity\Crypto;
use App\Entity\Transaction;
use App\Entity\Wallet;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;


class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('uuid')
            //->add('user')
            ->add('crypto', EntityType::class, [
                'class' => Crypto::class,
                'label' => 'Cryptomonnaie',
                'choice_label' => 'name',
            ])

            ->add('quantity', NumberType::class, [
                'label' => 'Combien de BTC avez vous achetez ? '
            ])

            ->add('originalprice', NumberType::class, [
                'label' => 'Quel est le prix total que vous avez payé ?',
            ])

            ->add('wallet', EntityType::class, [
                'label' => 'Portefeuille',
                'help' => 'Champ non obligatoire. Choisissez le portefeuille où se trouve vos BTC',
                'class' => Wallet::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);
    }
}
