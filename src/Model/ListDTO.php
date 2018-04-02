<?php

declare(strict_types=1);

namespace MajidMvulle\Bundle\UtilityBundle\Model;

use MajidMvulle\Bundle\UtilityBundle\Request\Options\ListOptions;

/**
 * Class ListDTO.
 *
 * @author Majid Mvulle <majid@majidmvulle.com>
 */
class ListDTO
{
    /**
     * @var int
     */
    public $page;

    /**
     * @var int
     */
    public $perPage;

    /**
     * @var array
     */
    public $items;

    public function __construct(ListOptions $listOptions, $items = [])
    {
        $this->page = $listOptions->get('page');
        $this->perPage = $listOptions->get('per_page');
        $this->items = $items;
    }
}
