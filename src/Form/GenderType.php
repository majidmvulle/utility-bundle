<?php

declare(strict_types=1);

namespace MajidMvulle\Bundle\UtilityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class GenderType.
 *
 * @author Majid Mvulle <majid@majidmvulle.com>
 */
class GenderType extends AbstractType
{
    const GENDER_MALE = 'm';
    const GENDER_FEMALE = 'f';

    /**
     * @var array
     */
    protected $choices;

    public function __construct()
    {
        $this->choices = [
            self::GENDER_FEMALE => 'Female',
            self::GENDER_MALE => 'Male',
        ];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['choices' => $this->choices, 'empty_value' => '-- Choose your Gender --']);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(): string
    {
        return ChoiceType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->getBlockPrefix();
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return '';
    }
}
