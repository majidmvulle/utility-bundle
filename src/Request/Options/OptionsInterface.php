<?php

declare(strict_types=1);

namespace MajidMvulle\Bundle\UtilityBundle\Request\Options;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Interface OptionsInterface.
 *
 * @author Majid Mvulle <majid@majidmvulle.com>
 */
interface OptionsInterface
{
    public function configureOptions(OptionsResolver $optionsResolver);
}
