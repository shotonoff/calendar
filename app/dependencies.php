<?php declare(strict_types = 1);

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use JMS\Serializer\Serializer;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use JMS\Serializer\SerializerBuilder;
use Doctrine\ORM\Tools\Setup;
use LiteCQRS\Bus\DirectCommandBus;
use Aulinks\Entity;
use LiteCQRS\Bus\EventMessageHandlerFactory;
use Aulinks\CQRS;
use Aulinks\Repository as Repo;
use Slim\Middleware\JwtAuthentication;
use Monolog\Logger;
use Aulinks\Security\JwtAuthProcessor;
use LiteCQRS\Bus\InMemoryEventMessageBus;

return [

    Twig::class => function (ContainerInterface $c) {
        $config = $c->get('config')['twig'];
        $twig = new Twig($config['template_path'], [ /** @todo set cache dir */ ]
        );
        $basePath = rtrim(str_ireplace('index.php', '', $c->get('request')->getUri()->getBasePath()), '/');
        $twig->addExtension(new TwigExtension($c->get('router'), $basePath));
        return $twig;
    },
    Serializer::class => function () {
        return SerializerBuilder::create()->build();
    },
    EntityManager::class => function (ContainerInterface $c) {
        $doctrineConfig = $c->get('config')['doctrine'];
        $config = Setup::createAnnotationMetadataConfiguration(
            $doctrineConfig['meta']['entity_path'],
            $doctrineConfig['meta']['auto_generate_proxies'],
            $doctrineConfig['meta']['proxy_dir'],
            $doctrineConfig['meta']['cache'],
            false
        );
        return EntityManager::create($doctrineConfig['connection'], $config);
    },
    Logger::class => function ($c) {
        $config = $c->get('config')['logger'];
        $logger = new Logger($config['name']);
        $logger->pushProcessor(new Monolog\Processor\UidProcessor());
        $logger->pushHandler(new Monolog\Handler\StreamHandler($config['path'], $config['level']));
        return $logger;
    },
    InMemoryEventMessageBus::class => function (ContainerInterface $c) {
        return new \LiteCQRS\Bus\InMemoryEventMessageBus();
    },
    DirectCommandBus::class => function (ContainerInterface $c) {

        $commandBus = new DirectCommandBus();
        $commandBus->register(CQRS\UserCreateCommand::class, $c->get(CQRS\UserService::class));
        $commandBus->register(CQRS\UserUpdateCommand::class, $c->get(CQRS\UserService::class));
        $commandBus->register(CQRS\EventCreateCommand::class, $c->get(CQRS\EventService::class));
        $commandBus->register(CQRS\EventPartUpdateCommand::class, $c->get(CQRS\EventService::class));
        $commandBus->register(CQRS\EventDeleteCommand::class, $c->get(CQRS\EventService::class));
        $commandBus->register(CQRS\InviteCreateCommand::class, $c->get(CQRS\InviteService::class));

        return $commandBus;
    },
    Repo\UserRepository::class => function (ContainerInterface $c) {
        return $c->get(EntityManager::class)->getRepository(Entity\User::class);
    },
    Repo\EventRepository::class => function (ContainerInterface $c) {
        return $c->get(EntityManager::class)->getRepository(Entity\Event::class);
    },
    Repo\InviteRepository::class => function (ContainerInterface $c) {
        return $c->get(EntityManager::class)->getRepository(Entity\Invite::class);
    },
    JwtAuthentication::class => function (ContainerInterface $c) {
        return new JwtAuthentication([
            "path" => "/_api/v1",
            "passthrough" => [
                "/_api/v1/token",
                "/registration",
            ],
            "secret" => getenv("JWT_SECRET"),
            "logger" => $c->get(Logger::class),
            "secure" => false,
            "error" => function ($request, $response, $arguments) {
                $data["status"] = "error";
                $data["message"] = $arguments["message"];
                return $response
                    ->withHeader("Content-Type", "application/json")
                    ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
            },
            "callback" => function ($request, $response, $arguments) use ($c) {
                $c->get(JwtAuthProcessor::class)->processes($arguments['decoded']);
            },
        ]);
    },
    Swift_FileSpool::class => function () {
        return new \Swift_FileSpool(__DIR__ . '/spool');
    },
    \Swift_Transport_SpoolTransport::class => function (ContainerInterface $c) {
        return new \Swift_Transport_SpoolTransport(
            new \Swift_Events_SimpleEventDispatcher(),
            $c->get(\Swift_FileSpool::class)
        );
    },
    Swift_Mailer::class => function (ContainerInterface $c) {
        return Swift_Mailer::newInstance($c->get(\Swift_Transport_SpoolTransport::class));
    },
    Swift_SmtpTransport::class => function (ContainerInterface $c) {
        $config = $c->get('config')['mailer'];
        $security = null;
        if (array_key_exists('security', $config['smtp'])) {
            $security = $config['smtp']['security'];
        }
        $transport = new Swift_SmtpTransport(
            $config['smtp']['host'],
            $config['smtp']['port'],
            $security
        );
        $transport
            ->setUsername($config['smtp']['username'])
            ->setPassword($config['smtp']['password']);
        return $transport;
    },
];