<?php

class LikeController
{
    public function toggle(): void
    {
        requireAuth();
        header('Content-Type: application/json; charset=utf-8');
        $user = currentUser();
        $postId = (int) ($_POST['post_id'] ?? 0);

        if (!$postId) {
            echo json_encode(['ok' => false]);
            return;
        }

        $liked = Like::toggle($postId, $user['id']);

        if ($liked) {
            $post = Post::find($postId);
            if ($post) {
                Notification::create((int) $post['user_id'], $user['id'], 'like', $postId);
            }
        }

        echo json_encode([
            'ok' => true,
            'liked' => $liked,
            'count' => Like::count($postId),
        ]);
    }
}
