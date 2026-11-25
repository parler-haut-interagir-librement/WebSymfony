<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Dto\Form\Type\SignupFormDto;
use Override;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * The sign-up form: a user name, an email address and the password typed twice.
 *
 * @extends AbstractType<SignupFormDto>
 *
 * @see templates/App/Controller/Security/SignupAction.html.twig
 */
final class SignupForm extends AbstractType
{
    #[Override]
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class)
            ->add('email', EmailType::class)
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'signup.password.mismatch',
            ])
        ;
    }

    #[Override]
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SignupFormDto::class,
        ]);
    }

    #[Override]
    public function getBlockPrefix(): string
    {
        return 'signup';
    }
}
