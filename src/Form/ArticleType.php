<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'attr' => [
                    'placeholder' => 'Add a title',
                ],
            ])
            ->add('content', null, [
                'attr' => [
                    'placeholder' => 'Add some content',
                ],
            ])
            ->add('creationDate', null, [
                'widget' => 'single_text',
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'multiple' => true,
                'by_reference' => false,
            ])
            ->add('draft', SubmitType::class, [
                'label' => 'Save as draft',
            ])
            ->add('publish', SubmitType::class, [
                'label' => 'Publish',
            ])
            ->add('delete', SubmitType::class, [
                'label' => 'Delete',
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
