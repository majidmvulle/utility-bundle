<?php

namespace MajidMvulle\Bundle\UtilityBundle\Form;

use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class LanguageType.
 *
 * @author Majid Mvulle <majid@majidmvulle.com>
 *
 * @DI\FormType("majidmvulle.utility.form.language")
 * @DI\Tag(name="form.type", attributes={"alias": "majidmvulle_utility_form_language"})
 */
class LanguageType extends AbstractType
{
    /**
     * @var array
     */
    protected $choices;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->choices = ['en' => 'English', 'ar' => 'Arabic'];
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['choices' => $this->choices, 'empty_value' => '-- Choose your Preferred Language --']);
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
        return 'majidmvulle_utility_form_language';
    }
}
