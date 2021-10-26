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

        $user = $options['user'];

        $builder
            //->add('uuid')
            //->add('user')
            ->add('crypto', EntityType::class, [
                'placeholder' => 'Veuillez choisir une crypto',
                'class' => Crypto::class,
                'label' => 'Cryptomonnaie',
                'choice_label' => 'name',
                'query_builder' => function(\Doctrine\ORM\EntityRepository $er)  {
                    return $er->createQueryBuilder('c')->orderBy('c.name', 'ASC');
                },
            ])

            ->add('quantity', NumberType::class, [
                'label' => 'Combien en avez-vous acheté ? ',
            ])

            ->add('originalprice', NumberType::class, [
                'label' => 'Quel est le prix total que vous avez payé ?',
            ])

            ->add('wallet', EntityType::class, [
                'required' => false,
                'placeholder' => 'Veuillez choisir un portefeuille',
                'label' => 'Portefeuille',
                'class' => Wallet::class,
                'choice_label' => 'name',
                'query_builder' => function(\Doctrine\ORM\EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('w')->orderBy('w.name', 'ASC')->where('w.user = '.$user.'');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);

        $resolver->setRequired(['user']);
    }
}
