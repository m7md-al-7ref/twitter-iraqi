<?php

class Notification
{
    public static function create(int $userId, ?int $fromUserId, string $type, ?int $targetId): void
    {
        // ما نسوي إشعار لنفس الشخص
        if ($userId === $fromUserId) return;

        $stmt = db()->prepare(
            "INSERT INTO notifications (user_id, from_user_id, type, target_id) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$userId, $fromUserId, $type, $targetId]);
    }

    public static function forUser(int $userId): array
    {
        $stmt = db()->prepare(
            "SELECT notifications.*, users.name, users.username, users.avatar
             FROM notifications
             LEFT JOIN users ON users.id = notifications.from_user_id
             WHERE notifications.user_id = ?
             ORDER BY notifications.created_at DESC LIMIT 50"
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public static function markAllRead(int $userId): void
    {
        db()->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ?")->execute([$userId]);
    }

    public static function unreadCount(int $userId): int
    {
        $stmt = db()->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = 0");
        $stmt->execute([$userId]);
        return (int) $stmt->fetchColumn();
    }
}
