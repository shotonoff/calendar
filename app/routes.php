<?php

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Aulinks\Middleware\RoleAccessChecker;
use Aulinks\Middleware\PermissionChecker;
use Aulinks\Controller\AuthController;
use Aulinks\Controller\InviteController;
use Aulinks\Controller\EventController;
use Aulinks\Controller\UserController;
use Aulinks\Validator\ValidatorCreator;

$app->post('/_api/v1/token', [AuthController::class, 'postTokenAction']);

$app->group('/_api/v1/invites', function () {
    $this->post('', [InviteController::class, 'postInviteCreateAction'])
        ->setArgument('action.permission', ['invite.create', 'invite.all']);
    $this->get('', [InviteController::class, 'getInvitesAction'])
        ->setArgument('action.permission', ['invite.all', 'invite.list']);
})
    ->add($app->getContainer()->get(PermissionChecker::class));

$app->group('/_api/v1/events', function () {
    $this->get('/{id:[0-9]+}', [EventController::class, 'getEventAction'])
        ->setArgument('action.permission', ['event.all', 'event.get']);
    $this->post('', [EventController::class, 'postEventCreateAction'])
        ->setArgument('action.permission', ['event.create', 'event.all']);
    $this->patch('/{id:[0-9]+}', [EventController::class, 'patchChangeDateAction'])
        ->setArgument('action.permission', ['event.update', 'event.all']);
    $this->get('', [EventController::class, 'getEventsAction'])
        ->setArgument('action.permission', ['event.all', 'event.list']);
    $this->get('/feed', [EventController::class, 'getEventsFeedAction'])
        ->setArgument('action.permission', ['event.list', 'event.all'])
        ->add(ValidatorCreator::createEventFeedValidator());
    $this->delete('/{id:[0-9]+}', [EventController::class, 'deleteEventAction'])
        ->setArgument('action.permission', ['event.delete', 'event.all']);
})->add($app->getContainer()->get(PermissionChecker::class));

$app->group('/_api/v1/users', function () {
    $this->get('', [UserController::class, 'getUsersAction']);
    $this->post('', [UserController::class, 'postUserCreateAction']);
    $this->put('/{id:[0-9]+}', [UserController::class, 'putUserUpdateAction']);
    $this->get('/{id:[0-9]+}', [UserController::class, 'getUserAction']);
})->add($app->getContainer()->get(RoleAccessChecker::class));

$app->post('/registration', [UserController::class, 'postUserCreateAction']);

$app->get('/', function (RequestInterface $request, ResponseInterface $response) {
    return $this->get(\Slim\Views\Twig::class)->render($response, 'index.twig');
});