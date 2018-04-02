<?php

declare(strict_types=1);

namespace MajidMvulle\Bundle\UtilityBundle\ORM;

use Doctrine\ORM\QueryBuilder;

/**
 * Class EntityRepository.
 *
 * @author Majid Mvulle <majid@majidmvulle.com>
 */
class EntityRepository extends \Doctrine\ORM\EntityRepository
{
    protected function getResults(QueryBuilder $queryBuilder): array
    {
        $maxResults = $queryBuilder->getMaxResults();

        if ($maxResults) {
            ++$maxResults;
        }

        $queryBuilder->setMaxResults($maxResults);

        return $queryBuilder->getQuery()->execute();
    }
}
