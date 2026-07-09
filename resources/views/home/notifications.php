<?php
$pageTitle = 'الإشعارات';
$active = 'notifications';
require __DIR__ . '/../partials/layout_start.php';

$labels = [
    'like' => ['🤍', 'عجبته تغريدتك'],
    'comment' => ['💬', 'رد على تغريدتك'],
    'follow' => ['👤', 'صار يتابعك'],
    'mention' => ['📣', 'ذكرك بتغريدة'],
];
?>
<div class="main-header">الإشعارات</div>

<?php if (empty($notifications)): ?>
    <div class="empty-state">
        <h3>ماكو إشعارات هسه</h3>
        <p>لمن حد يتفاعل وياك راح تشوفه هنا</p>
    </div>
<?php endif; ?>

<?php foreach ($notifications as $n): ?>
    <?php [$icon, $text] = $labels[$n['type']] ?? ['🔔', 'إشعار جديد']; ?>
    <div class="notif-item <?= !$n['is_read'] ? 'unread' : '' ?>">
        <div class="notif-icon"><?= $icon ?></div>
        <a href="<?= $n['username'] ? url('/profile/' . $n['username']) : '#' ?>">
            <img class="avatar avatar-sm" src="<?= $n['avatar'] ? url($n['avatar']) : 'https://api.dicebear.com/7.x/initials/svg?seed=' . urlencode($n['name'] ?? 'user') ?>" alt="">
        </a>
        <div class="notif-text">
            <b><?= e($n['name'] ?? 'مستخدم') ?></b> <?= $text ?>
            <div class="tweet-time"><?= timeAgo($n['created_at']) ?></div>
        </div>
    </div>
<?php endforeach; ?>

<?php require __DIR__ . '/../partials/layout_end.php'; ?>
