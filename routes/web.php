<?php

/** @var Router $router */

// المصادقة
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/logout', [AuthController::class, 'logout']);

// الرئيسية والاستكشاف والبحث
$router->get('/', [PostController::class, 'home']);
$router->get('/explore', [PostController::class, 'explore']);
$router->get('/search', [SearchController::class, 'index']);

// التغريدات
$router->post('/posts', [PostController::class, 'store']);
$router->get('/posts/{id}', [PostController::class, 'show']);
$router->post('/posts/{id}/delete', [PostController::class, 'destroy']);

// التعليقات
$router->post('/comments', [CommentController::class, 'store']);
$router->post('/comments/{id}/delete', [CommentController::class, 'destroy']);

// اللايكات
$router->post('/like', [LikeController::class, 'toggle']);

// المتابعة
$router->post('/follow', [FollowController::class, 'toggle']);

// البروفايل والإعدادات
$router->get('/profile/{username}', [UserController::class, 'profile']);
$router->get('/settings', [UserController::class, 'editForm']);
$router->post('/settings', [UserController::class, 'update']);

// الرسائل
$router->get('/messages', [MessageController::class, 'index']);
$router->get('/messages/{username}', [MessageController::class, 'show']);
$router->post('/messages', [MessageController::class, 'send']);

// الإشعارات
$router->get('/notifications', [NotificationController::class, 'index']);
