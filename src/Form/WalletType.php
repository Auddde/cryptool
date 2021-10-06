<?php

namespace App\Form;

use App\Entity\Wallet;
use App\Entity\WalletCategory;

use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            //->add('user')
            ->add('name', TextType::class, [
                'label'=>'Intitulé',
            ])

            ->add('description')

            ->add('walletcategory', EntityType::class, [
                'class' => WalletCategory::class,
                'label' => 'Catégorie',
                'choice_label' => 'name',
                'placeholder' => 'Veuillez choisir une catégorie',
                'query_builder' => function(\Doctrine\ORM\EntityRepository $er)  {
                    return $er->createQueryBuilder('c')->orderBy('c.name', 'ASC');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wallet::class,
        ]);
    }
}
