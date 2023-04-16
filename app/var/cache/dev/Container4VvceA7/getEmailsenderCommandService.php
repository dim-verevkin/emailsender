<?php

namespace Container4VvceA7;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getEmailsenderCommandService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'App\Command\EmailsenderCommand' shared autowired service.
     *
     * @return \App\Command\EmailsenderCommand
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/console/Command/Command.php';
        include_once \dirname(__DIR__, 4).'/src/Command/EmailsenderCommand.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/mailer/MailerInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/mailer/Mailer.php';

        $container->privates['App\\Command\\EmailsenderCommand'] = $instance = new \App\Command\EmailsenderCommand(($container->services['doctrine.orm.default_entity_manager'] ?? $container->load('getDoctrine_Orm_DefaultEntityManagerService')), new \Symfony\Component\Mailer\Mailer(($container->privates['mailer.transports'] ?? $container->load('getMailer_TransportsService')), NULL, ($container->services['event_dispatcher'] ?? $container->getEventDispatcherService())));

        $instance->setName('app:emailsender');
        $instance->setDescription('Add a short description for your command');

        return $instance;
    }
}