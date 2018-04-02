<?php

declare(strict_types=1);

namespace MajidMvulle\Bundle\UtilityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class LanguageType.
 *
 * @author Majid Mvulle <majid@majidmvulle.com>
 */
class LanguageType extends AbstractType
{
    /**
     * @var array
     */
    protected $choices;

    public function __construct()
    {
        $this->choices = ['en' => 'English', 'ar' => 'Arabic'];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['choices' => $this->choices, 'empty_value' => '-- Choose your Preferred Language --']);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
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
