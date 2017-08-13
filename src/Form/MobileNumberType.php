<?php

namespace MajidMvulle\Bundle\UtilityBundle\Form;

use JMS\DiExtraBundle\Annotation as DI;
use MajidMvulle\Bundle\UtilityBundle\Validator\Constraints\MobileNumber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class MobileNumberType.
 *
 * @author Majid Mvulle <majid@majidmvulle.com>
 *
 * @DI\FormType("majidmvulle.utility.form.mobile_number")
 * @DI\Tag(name="form.type", attributes={"alias": "majidmvulle_utility_form_mobile_number"})
 */
class MobileNumberType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'constraints' => [
                new NotBlank(),
                new MobileNumber(),
            ],
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
        return 'majidmvulle_utility_form_mobile_number';
    }
}
