<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Policy;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\ModuleManager\Feature\ConfigProviderInterface; 

class Module
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
     public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\PolicyTable::class => function ($container) {
                    $tableGateway = $container->get(Model\PolicyTableGateway::class);
                    return new Model\PolicyTable($tableGateway);
                },
                Model\PolicyTableGateway::class => function ($container) {
                    $adapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Policy);
                    return new TableGateway('tbl_policy', $adapter, null, $resultSetPrototype);
                }
            ]

        ];
    }

    public function getControllerConfig()
    {
          return [
              'factories' => [
                  Controller\IndexController::class => function ($container) {

                      return new Controller\IndexController(
                          $container->get(Model\PolicyTable::class)
                      );

                  }
              ]
          ];
    }
}
