<?php

class Message
{
    public static function send(int $senderId, int $receiverId, string $text): int
    {
        $stmt = db()->prepare(
            "INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)"
        );
        $stmt->execute([$senderId, $receiverId, $text]);
        return (int) db()->lastInsertId();
    }

    public static function conversation(int $userA, int $userB): array
    {
        $stmt = db()->prepare(
            "SELECT * FROM messages
             WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)
             ORDER BY created_at ASC"
        );
        $stmt->execute([$userA, $userB, $userB, $userA]);
        return $stmt->fetchAll();
    }

    /** آخر رسالة مع كل شخص حجينا وياه */
    public static function conversationsList(int $userId): array
    {
        $sql = "SELECT u.id, u.name, u.username, u.avatar, m.message AS last_message, m.created_at
                FROM users u
                JOIN messages m ON (m.sender_id = u.id OR m.receiver_id = u.id)
                WHERE (m.sender_id = ? OR m.receiver_id = ?) AND u.id != ?
                  AND m.id = (
                      SELECT MAX(id) FROM messages
                      WHERE (sender_id = u.id AND receiver_id = ?) OR (sender_id = ? AND receiver_id = u.id)
                  )
                ORDER BY m.created_at DESC";
        $stmt = db()->prepare($sql);
        $stmt->execute([$userId, $userId, $userId, $userId, $userId]);
        return $stmt->fetchAll();
    }
}
