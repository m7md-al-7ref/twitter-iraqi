<?php

class FollowController
{
    public function toggle(): void
    {
        requireAuth();
        $user = currentUser();
        $targetId = (int) ($_POST['user_id'] ?? 0);

        $following = Follow::toggle($user['id'], $targetId);
        if ($following) {
            Notification::create($targetId, $user['id'], 'follow', $user['id']);
        }

        if (!empty($_POST['ajax'])) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['ok' => true, 'following' => $following]);
            return;
        }

        $back = $_SERVER['HTTP_REFERER'] ?? '/';
        header('Location: ' . $back);
        exit;
    }
}
