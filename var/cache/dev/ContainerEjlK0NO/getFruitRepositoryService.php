<?php

namespace ContainerEjlK0NO;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getFruitRepositoryService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'App\Repository\FruitRepository' shared autowired service.
     *
     * @return \App\Repository\FruitRepository
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/src/Persistence/ObjectRepository.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/collections/src/Selectable.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/src/EntityRepository.php';
        include_once \dirname(__DIR__, 4).'/src/Repository/ProductRepositoryInterface.php';
        include_once \dirname(__DIR__, 4).'/src/Traits/SearchQueryBuilderTrait.php';
        include_once \dirname(__DIR__, 4).'/src/Repository/FruitRepository.php';

        return $container->privates['App\\Repository\\FruitRepository'] = new \App\Repository\FruitRepository(($container->services['doctrine.orm.default_entity_manager'] ?? $container->load('getDoctrine_Orm_DefaultEntityManagerService')));
    }
}
