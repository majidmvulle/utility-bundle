<?php

namespace MajidMvulle\Bundle\UtilityBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class MajidMvulleUtilityBundle.
 *
 * @author Majid Mvulle <majid@majidmvulle.com>
 */
class MajidMvulleUtilityBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        $this->extension = $this->createContainerExtension();

        return parent::getContainerExtension();
    }
}
