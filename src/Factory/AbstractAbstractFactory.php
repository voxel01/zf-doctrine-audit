<?php

namespace ZF\Doctrine\Audit\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\AbstractFactoryInterface;
use ZF\Doctrine\Audit\Persistence;

/**
 * This module uses many classes which implement the same interfaces.
 * Instead of assigning instantiators for Controllers, View Plugins,
 * and the Global Service Manager, all classes in this module are
 * instead created by this abstract factory.
 */

abstract class AbstractAbstractFactory implements
    AbstractFactoryInterface
{
    protected $factoryClasses = [
        'ZF\Doctrine\Audit\Controller\IndexController',
        'ZF\Doctrine\Audit\Controller\SchemaToolController',
        'ZF\Doctrine\Audit\Controller\EpochController',
    ];

    protected $initializers;

    public function getInitializers()
    {
        if ($this->initializers) {
            return $this->initializers;
        }

        $this->initializers[] = new Persistence\ObjectManagerInitializer();
        $this->initializers[] = new Persistence\AuditObjectManagerInitializer();
        $this->initializers[] = new Persistence\AuditServiceInitializer();
        $this->initializers[] = new Persistence\AuditOptionsInitializer();
        $this->initializers[] = new Persistence\AuditEntitiesInitializer();
        $this->initializers[] = new Persistence\AuthenticationServiceInitializer();

        return $this->initializers;
    }

    public function canCreateServiceWithName(
        ServiceLocatorInterface $serviceLocator,
        $name,
        $requestedName)
    {
        return in_array($requestedName, array_keys($this->factoryClasses));
    }

    public function createServiceWithName(
        ServiceLocatorInterface $serviceLocator,
        $name,
        $requestedName)
    {
echo ($requestedName . "<BR>");
        $instance = new $this->factoryClasses[$requestedName]();

        if (method_exists($serviceLocator, 'getServiceLocator')) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        foreach ($this->getInitializers() as $initializer) {
            $initializer->initialize($instance, $serviceLocator);
        }

        return $instance;
    }
}