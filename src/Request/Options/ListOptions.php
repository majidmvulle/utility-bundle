<?php

declare(strict_types=1);

namespace MajidMvulle\Bundle\UtilityBundle\Request\Options;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ListOptions.
 *
 * @author Majid Mvulle <majid@majidmvulle.com>
 */
class ListOptions extends AbstractOptions
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['page' => 1, 'per_page' => 30]);
        $resolver->setAllowedTypes('page', ['null', 'int', 'string']);
        $resolver->setAllowedTypes('per_page', ['null', 'int', 'string']);
    }

    public function getOffset(): int
    {
        $page = $this->get('page');
        $per_page = $this->get('per_page');

        if ($page < 1) {
            return 0;
        }

        return ($page - 1) * $per_page;
    }

    public function getLimit(): ?int
    {
        return $this->get('per_page');
    }
}
