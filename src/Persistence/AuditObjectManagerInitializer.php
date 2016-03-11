<?php

namespace ZF\Doctrine\Audit\Persistence;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuditObjectManagerInitializer implements InitializerInterface
{
    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        if ($instance instanceof AuditObjectManagerAwareInterface) {
            if (method_exists($serviceLocator, 'getServiceLocator')) {
                $serviceLocator = $serviceLocator->getServiceLocator();
            }

            $config = $serviceLocator->get('Config')['zf-doctrine-audit'];
            $instance->setAuditObjectManager(
                $serviceLocator->get($config['audit_object_manager'])
            );
        }
    }
}