<?php

class MessageController
{
    public function index(): void
    {
        requireAuth();
        $user = currentUser();
        $conversations = Message::conversationsList($user['id']);
        require __DIR__ . '/../../resources/views/messages/index.php';
    }

    public function show(string $username): void
    {
        requireAuth();
        $user = currentUser();
        $otherUser = User::findByUsername($username);

        if (!$otherUser) {
            http_response_code(404);
            echo 'المستخدم غير موجود';
            return;
        }

        $messages = Message::conversation($user['id'], $otherUser['id']);
        $conversations = Message::conversationsList($user['id']);
        require __DIR__ . '/../../resources/views/messages/show.php';
    }

    public function send(): void
    {
        requireAuth();
        $user = currentUser();
        $receiverUsername = $_POST['username'] ?? '';
        $text = trim($_POST['message'] ?? '');

        $receiver = User::findByUsername($receiverUsername);
        if ($receiver && $text !== '') {
            Message::send($user['id'], $receiver['id'], $text);
        }

        redirect('/messages/' . $receiverUsername);
    }
}
