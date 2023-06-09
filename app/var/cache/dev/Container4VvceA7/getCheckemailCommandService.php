<?php

namespace Container4VvceA7;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getCheckemailCommandService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'App\Command\CheckemailCommand' shared autowired service.
     *
     * @return \App\Command\CheckemailCommand
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/console/Command/Command.php';
        include_once \dirname(__DIR__, 4).'/src/Command/CheckemailCommand.php';

        $container->privates['App\\Command\\CheckemailCommand'] = $instance = new \App\Command\CheckemailCommand(($container->services['doctrine.orm.default_entity_manager'] ?? $container->load('getDoctrine_Orm_DefaultEntityManagerService')));

        $instance->setName('app:checkemail');
        $instance->setDescription('Add a short description for your command');

        return $instance;
    }
}
