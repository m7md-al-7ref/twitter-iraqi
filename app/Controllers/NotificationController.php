<?php

class NotificationController
{
    public function index(): void
    {
        requireAuth();
        $user = currentUser();
        $notifications = Notification::forUser($user['id']);
        Notification::markAllRead($user['id']);
        require __DIR__ . '/../../resources/views/home/notifications.php';
    }
}
