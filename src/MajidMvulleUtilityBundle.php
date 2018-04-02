<?php

declare(strict_types=1);

namespace MajidMvulle\Bundle\UtilityBundle;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
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
    public function getContainerExtension(): ?ExtensionInterface
    {
        $this->extension = $this->createContainerExtension();

        return parent::getContainerExtension();
    }
}
