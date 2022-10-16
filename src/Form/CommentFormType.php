<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class CommentFormType extends AbstractType
{
    public function __construct(private readonly UrlGeneratorInterface $urlGenerator)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 5, 'max' => 2000]),
                ],
                'label' => 'Message*',
                'attr' => [
                    'rows' => 5,
                    'class' => 'form-control',
                ],
            ])
            ->add('parent', HiddenType::class, [
                'constraints' => [
                    new Positive(),
                ],
            ])
            ->add('post', HiddenType::class, [
                'constraints' => [
                    new Positive(),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary font-weight-semi-bold py-2 px-3',
                ],
                'label' => 'Leave a comment',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'action' => $this->urlGenerator->generate('app_comment'),
            'data_class' => null,
            'csrf_protection' => true,
            'csrf_field_name' => '_csrf_token',
            'csrf_token_id'   => 'authenticate',
        ]);
    }
}
