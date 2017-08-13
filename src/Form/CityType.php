<?php

namespace MajidMvulle\Bundle\UtilityBundle\Form;

use JMS\DiExtraBundle\Annotation as DI;
use MajidMvulle\Bundle\UtilityBundle\Model\City;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CityType.
 *
 * @author Majid Mvulle <majid@majidmvulle.com>
 *
 * @DI\FormType("majidmvulle.utility.form.city")
 * @DI\Tag(name="form.type", attributes={"alias": "majidmvulle_utility_form_city"})
 */
class CityType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['label' => 'City', 'choices' => City::getCitiesList(), 'empty_value' => '']);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return ChoiceType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'majidmvulle_utility_form_city';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
