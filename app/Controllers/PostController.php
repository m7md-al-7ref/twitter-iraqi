<?php

class PostController
{
    public function home(): void
    {
        requireAuth();
        $user = currentUser();
        $posts = Post::feedFor($user['id']);
        $suggestions = Follow::suggestions($user['id']);
        require __DIR__ . '/../../resources/views/home/index.php';
    }

    public function explore(): void
    {
        requireAuth();
        $user = currentUser();
        $posts = Post::explore($user['id']);
        require __DIR__ . '/../../resources/views/home/explore.php';
    }

    public function store(): void
    {
        requireAuth();
        $user = currentUser();
        $content = trim($_POST['content'] ?? '');

        if ($content === '' && empty($_FILES['image']['name'])) {
            redirect('/');
        }
        if (mb_strlen($content) > 280) {
            redirect('/');
        }

        $imagePath = UploadService::uploadImage($_FILES['image'] ?? null, 'posts');
        Post::create($user['id'], $content, $imagePath);

        redirect('/');
    }

    public function destroy(int $id): void
    {
        requireAuth();
        $user = currentUser();
        Post::delete($id, $user['id']);
        $back = $_SERVER['HTTP_REFERER'] ?? '/';
        header('Location: ' . $back);
        exit;
    }

    public function show(int $id): void
    {
        requireAuth();
        $viewer = currentUser();
        $post = Post::find($id);
        if (!$post) {
            http_response_code(404);
            echo 'التغريدة غير موجودة';
            return;
        }
        $post['likes_count'] = Like::count($id);
        $post['liked_by_me'] = Like::isLiked($id, $viewer['id']);
        $comments = Comment::forPost($id);
        require __DIR__ . '/../../resources/views/home/show.php';
    }
}
