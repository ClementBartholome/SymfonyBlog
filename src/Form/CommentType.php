<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bundle\SecurityBundle\Security ;

class CommentType extends AbstractType
{
    private $user;

    public function __construct(Security $security)
    {
        $this->user = $security->getUser();
    }
 

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', null, [
                'label' => 'Your comment',
                'attr' => [
                    'placeholder' => 'Your comment',
                ],
            ])
            ->add('author', null, [
                'label' => 'Your name',
                'attr' => [
                    'placeholder' => 'Your name',
                ],
            ]);

            $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event){
                $form = $event->getForm();
                if($this->user !== null) {
                    $form->get('author')->setData($this->user->getUsername());
                }
            });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
