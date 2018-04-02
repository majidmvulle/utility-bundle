<?php

declare(strict_types=1);

namespace MajidMvulle\Bundle\UtilityBundle\Form;

use MajidMvulle\Bundle\UtilityBundle\Validator\Constraints\PhoneNumber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PhoneNumberType.
 *
 * @author Majid Mvulle <majid@majidmvulle.com>
 */
class PhoneNumberType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['constraints' => [new PhoneNumber()]]);
    }

    public function getParent(): string
    {
        return TextType::class;
    }

    public function getName(): string
    {
        return $this->getBlockPrefix();
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
