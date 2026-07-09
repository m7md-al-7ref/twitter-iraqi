<?php

class UserController
{
    public function profile(string $username): void
    {
        requireAuth();
        $viewer = currentUser();
        $profileUser = User::findByUsername($username);

        if (!$profileUser) {
            http_response_code(404);
            echo 'المستخدم غير موجود';
            return;
        }

        $posts = Post::byUser($profileUser['id'], $viewer['id']);
        $isFollowing = Follow::isFollowing($viewer['id'], $profileUser['id']);
        $followersCount = User::followersCount($profileUser['id']);
        $followingCount = User::followingCount($profileUser['id']);

        require __DIR__ . '/../../resources/views/profile/show.php';
    }

    public function editForm(): void
    {
        requireAuth();
        $user = currentUser();
        require __DIR__ . '/../../resources/views/settings/edit.php';
    }

    public function update(): void
    {
        requireAuth();
        $user = currentUser();

        $name = trim($_POST['name'] ?? $user['name']);
        $bio = trim($_POST['bio'] ?? '');
        $location = trim($_POST['location'] ?? '');

        $fields = [
            'name' => $name !== '' ? $name : $user['name'],
            'bio' => $bio,
            'location' => $location,
        ];

        $avatar = UploadService::uploadImage($_FILES['avatar'] ?? null, 'avatars');
        if ($avatar) $fields['avatar'] = $avatar;

        $cover = UploadService::uploadImage($_FILES['cover'] ?? null, 'covers');
        if ($cover) $fields['cover'] = $cover;

        User::update($user['id'], $fields);
        redirect('/profile/' . $user['username']);
    }
}
