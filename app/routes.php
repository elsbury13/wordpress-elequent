<?php
$app->get('/', App\Action\HomeAction::class);
$app->get('/menu/{id}', App\Action\HomeAction::class . ':getMenu');

$app->get('/post', App\Action\PostsAction::class . ':getPosts');
$app->get('/post/{id}', App\Action\PostsAction::class . ':getPost');

$app->get('/page', App\Action\PagesAction::class . ':getPages');
$app->get('/page/{id}', App\Action\PagesAction::class . ':getPage');
