<?php

namespace MajidMvulle\Bundle\UtilityBundle\Form;

use JMS\DiExtraBundle\Annotation as DI;
use MajidMvulle\Bundle\UtilityBundle\Validator\Constraints\PhoneNumber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PhoneNumberType.
 *
 * @author Majid Mvulle <majid@majidmvulle.com>
 *
 * @DI\FormType("majidmvulle.utility.form.phone_number")
 * @DI\Tag(name="form.type", attributes={"alias": "majidmvulle_utility_form_phone_number"})
 */
class PhoneNumberType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['constraints' => [new PhoneNumber()],
        ]);
    }

    public function getParent()
    {
        return TextType::class;
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
        return 'majidmvulle_utility_form_phone_number';
    }
}
