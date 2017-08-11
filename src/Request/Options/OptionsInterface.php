<?php

namespace MajidMvulle\UtilityBundle\Request\Options;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Interface OptionsInterface.
 *
 * @author Majid Mvulle <majid@majidmvulle.com>
 */
interface OptionsInterface
{
    /**
     * @param OptionsResolver $optionsResolver
     *
     * @return mixed
     */
    public function configureOptions(OptionsResolver $optionsResolver);
}
