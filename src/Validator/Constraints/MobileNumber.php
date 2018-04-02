<?php

declare(strict_types=1);

namespace MajidMvulle\Bundle\UtilityBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\RegexValidator;

/**
 * Class MobileNumber.
 *
 * @author Majid Mvulle <majid@majidmvulle.com>
 */
class MobileNumber extends Regex
{
    /**
     * @var string
     */
    public $message = 'Mobile number is not valid';

    /**
     * @var string
     */
    public $pattern = '/^(0|((\+|00)?971))(50|51|52|53|54|55|56|57|58|59)\d{7}$/';

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
