<?php

namespace ContainerIu8VDJI;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getDoctrine_Dbal_ConnectionFactory_DsnParserService extends App_KernelTestDebugContainer
{
    /**
     * Gets the private 'doctrine.dbal.connection_factory.dsn_parser' shared service.
     *
     * @return \Doctrine\DBAL\Tools\DsnParser
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/dbal/src/Tools/DsnParser.php';

        return $container->privates['doctrine.dbal.connection_factory.dsn_parser'] = new \Doctrine\DBAL\Tools\DsnParser(['db2' => 'ibm_db2', 'mssql' => 'pdo_sqlsrv', 'mysql' => 'pdo_mysql', 'mysql2' => 'pdo_mysql', 'postgres' => 'pdo_pgsql', 'postgresql' => 'pdo_pgsql', 'pgsql' => 'pdo_pgsql', 'sqlite' => 'pdo_sqlite', 'sqlite3' => 'pdo_sqlite']);
    }
}
