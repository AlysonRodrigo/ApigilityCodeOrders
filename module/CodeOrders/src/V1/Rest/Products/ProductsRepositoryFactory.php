<?php
/**
 * Created by PhpStorm.
 * User: alyson
 * Date: 18/07/17
 * Time: 00:44
 */

namespace CodeOrders\V1\Rest\Products;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Hydrator\ClassMethods;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class ProductsRepositoryFactory implements FactoryInterface
{

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $dbAdapter = $container->get('DbAdapter');
        //$usersMapper = new UsersMapper();
        $hydrator = new HydratingResultSet(new ClassMethods(),new ProductsEntity());

        $tableGateway = new TableGateway('products',$dbAdapter, null, $hydrator);

        $productRepository = new ProductsRepository($tableGateway);

        return $productRepository;
    }
}