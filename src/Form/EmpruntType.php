<?php

namespace App\Form;

use App\Entity\Emprunt;
use App\Entity\Livre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class EmpruntType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_emprunt')
            ->add('date_fin_prevue')
            ->add('adherent')
            ->add('livre', EntityType::class, [
                'class' => Livre::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l')
                    ->andWhere('l.isDeleted = :deleted')
                    ->setParameter('deleted', false);
                },
                'choice_label' => 'titre',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Emprunt::class,
        ]);
    }
}
