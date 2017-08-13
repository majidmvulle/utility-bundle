<?php

namespace MajidMvulle\Bundle\UtilityBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraints\Regex;

/**
 * Class PhoneNumber.
 *
 * @author Majid Mvulle <majid@majidmvulle.com>
 */
class PhoneNumber extends Regex
{
    /**
     * @var string
     */
    public $message = 'Phone number is not valid';

    /**
     * @var string
     */
    public $pattern = '/^(0|((\+|00)?971))(2|3|4|6|7|9|50|52|54|55|56)\d{7}$/';

    /**
     * @var bool
     */
    public $match = true;

    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return 'Symfony\Component\Validator\Constraints\RegexValidator';
    }

    /**
     * {@inheritdoc}
     */
    public function getRequiredOptions()
    {
        return [];
    }
}
