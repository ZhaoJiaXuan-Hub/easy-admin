<?php
/**
 * This file is part of webman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link      http://www.workerman.net/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Psr\Container\ContainerInterface;
return [
    app\service\system\SystemServiceInterface::class => function(ContainerInterface $container) {
        return $container->make(app\service\system\socket\SystemService::class);
    },
    app\service\system\AccountAuthServiceInterface::class => function(ContainerInterface $container) {
        return $container->make(app\service\system\socket\AccountAuthService::class);
    },
    app\service\system\AccountServiceInterface::class => function(ContainerInterface $container) {
        return $container->make(app\service\system\socket\AccountService::class);
    },
    app\service\system\PluginsServiceInterface::class => function(ContainerInterface $container) {
        return $container->make(app\service\system\socket\PluginsService::class);
    },
    app\service\system\RoleRoutersServiceInterface::class => function(ContainerInterface $container) {
        return $container->make(app\service\system\socket\RoleRoutersService::class);
    },
    app\service\api\V1ServiceInterface::class => function(ContainerInterface $container) {
        return $container->make(app\service\api\socket\V1Service::class);
    }
];