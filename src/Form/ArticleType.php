<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Subcategory;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('publicationDate', null, [
                'widget' => 'single_text',
            ])
            ->add('title')
            ->add('summary')
            ->add('content')
            ->add('active')
            ->add('Category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
            ])
            ->add('Subcategory', EntityType::class, [
                'class' => Subcategory::class,
                'choice_label' => 'name',
            ])
            ->add('Users', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'login',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
