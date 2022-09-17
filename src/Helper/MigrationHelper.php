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
    
    public static function insertPage(Connection $connection, array $page): int
    {
        $page = array_merge(
            [
                'published'   => 1,
                'modified_at' => date('Y-m-d H:i:s'),
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            $page
        );
    
        $fields       = array_keys($page);
        $values       = array_values($page);
        $placeholders = substr(str_repeat('?,', count($fields)), 0, -1);
        $connection->executeQuery('insert into page (' . implode(',', $fields) . ') values(' . $placeholders . ')',
            $values);
    
        return $connection->lastInsertId();
    }
}