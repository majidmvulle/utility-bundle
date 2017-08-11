<?php

namespace MajidMvulle\UtilityBundle\Form;

use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class GenderType.
 *
 * @author Majid Mvulle <majid@majidmvulle.com>
 *
 * @DI\FormType("majidmvulle.utility.form.gender")
 * @DI\Tag(name="form.type", attributes={"alias": "majidmvulle_utility_form_gender"})
 */
class GenderType extends AbstractType
{
    const GENDER_MALE = 'm';
    const GENDER_FEMALE = 'f';

    /**
     * @var array
     */
    protected $choices;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->choices = [
            self::GENDER_FEMALE => 'Female',
            self::GENDER_MALE => 'Male',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['choices' => $this->choices, 'empty_value' => '-- Choose your Gender --']);
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
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'majidmvulle_utility_form_gender';
    }
}
