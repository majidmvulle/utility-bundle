<?php

declare(strict_types=1);

namespace MajidMvulle\Bundle\UtilityBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\RegexValidator;

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
    public $pattern = '/^(0|((\+|00)?971))(2|3|4|6|7|9)\d{7}$/';

    /**
     * @var bool
     */
    public $match = true;

    public function validatedBy(): string
    {
        return RegexValidator::class;
    }

    public function getRequiredOptions(): array
    {
        return [];
    }
}
