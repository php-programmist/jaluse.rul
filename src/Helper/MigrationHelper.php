<?php

namespace App\Helper;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use RuntimeException;

class MigrationHelper
{
    /**
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws Exception
     */
    public static function getPageIdByUri(Connection $connection, string $uri): int
    {
        $pageId = (int)($connection
            ->executeQuery('SELECT id FROM page where uri=?', [$uri])
            ->fetchOne()
        );
        if (0 === $pageId) {
            throw new RuntimeException(sprintf('Не удалось найти страницу с URI "%s".',
                $uri));
        }
        
        return $pageId;
    }
}