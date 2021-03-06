<?php

namespace ZF\Doctrine\Audit;

use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\ServiceManager\ServiceManager;
use Doctrine\ORM\Mapping\Driver\XmlDriver;
use Doctrine\ORM\Events;
use Doctrine\DBAL\Events as DBALEvents;

class Module implements
    ConfigProviderInterface,
    ConsoleUsageProviderInterface
{
    public function getConsoleUsage(Console $console)
    {
        return array(
            'audit:trigger-tool:create' => 'Create trigger SQL for target database',
            'audit:epoch:import' => 'Create epoch stored procedures SQL for target database',
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        $serviceManager = $e->getParam('application')->getServiceManager();

        $config = $serviceManager->get('config')['zf-doctrine-audit'];

        $serviceManager->get('ZF\Doctrine\Audit\Loader\EntityAutoloader')->register();
        $serviceManager->get('ZF\Doctrine\Audit\Loader\JoinEntityAutoloader')->register();

        $mergedDriver = $serviceManager->get('ZF\Doctrine\Audit\Mapping\Driver\MergedDriver');
        $mergedDriver->addDriver($serviceManager->get('ZF\Doctrine\Audit\Mapping\Driver\EntityDriver'));
        $mergedDriver->addDriver($serviceManager->get('ZF\Doctrine\Audit\Mapping\Driver\JoinEntityDriver'));
        $mergedDriver->register();

        $postConnectListener = $serviceManager->get(EventListener\PostConnect::class);
        $postFlushListener = $serviceManager->get(EventListener\PostFlush::class);

        $objectManager = $serviceManager->get($config['target_object_manager']);
        $auditObjectManager = $serviceManager->get($config['audit_object_manager']);

        // Driver for zf-doctrine-audit entites
        $xmlDriver = new XmlDriver(__DIR__ . '/config/orm');
        $auditObjectManager
            ->getConfiguration()
            ->getMetadataDriverImpl()
            ->addDriver($xmlDriver, 'ZF\Doctrine\Audit\Entity')
            ;

        $objectManager->getEventManager()
            ->addEventListener([DBALEvents::postConnect], $postConnectListener);

        $objectManager->getEventManager()
            ->addEventListener([Events::postFlush], $postFlushListener);
    }
}
