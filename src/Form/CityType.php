<?php

declare(strict_types=1);

namespace MajidMvulle\Bundle\UtilityBundle\Form;

use MajidMvulle\Bundle\UtilityBundle\Model\City;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CityType.
 *
 * @author Majid Mvulle <majid@majidmvulle.com>
 */
class CityType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['label' => 'City', 'choices' => City::getCitiesList(), 'empty_value' => '']);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }

    public function getBlockPrefix(): string
    {
        return '';
    }

    public function getName(): string
    {
        return $this->getBlockPrefix();
    }
}
