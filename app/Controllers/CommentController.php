<?php

class CommentController
{
    public function store(): void
    {
        requireAuth();
        $user = currentUser();
        $postId = (int) ($_POST['post_id'] ?? 0);
        $text = trim($_POST['comment'] ?? '');

        if ($postId && $text !== '') {
            Comment::create($postId, $user['id'], $text);
            $post = Post::find($postId);
            if ($post) {
                Notification::create((int) $post['user_id'], $user['id'], 'comment', $postId);
            }
        }

        $back = $_SERVER['HTTP_REFERER'] ?? '/';
        header('Location: ' . $back);
        exit;
    }

    public function destroy(int $id): void
    {
        requireAuth();
        $user = currentUser();
        Comment::delete($id, $user['id']);
        $back = $_SERVER['HTTP_REFERER'] ?? '/';
        header('Location: ' . $back);
        exit;
    }
}
