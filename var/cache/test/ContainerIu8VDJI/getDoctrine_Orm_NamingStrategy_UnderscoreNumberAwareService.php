<?php

namespace ContainerIu8VDJI;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getDoctrine_Orm_NamingStrategy_UnderscoreNumberAwareService extends App_KernelTestDebugContainer
{
    /**
     * Gets the private 'doctrine.orm.naming_strategy.underscore_number_aware' shared service.
     *
     * @return \Doctrine\ORM\Mapping\UnderscoreNamingStrategy
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/src/Mapping/NamingStrategy.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/src/Mapping/UnderscoreNamingStrategy.php';

        return $container->privates['doctrine.orm.naming_strategy.underscore_number_aware'] = new \Doctrine\ORM\Mapping\UnderscoreNamingStrategy(0, true);
    }
}
