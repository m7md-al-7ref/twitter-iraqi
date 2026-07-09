<?php
$pageTitle = 'الرسائل';
$active = 'messages';
require __DIR__ . '/../partials/layout_start.php';
?>
<div class="main-header">الرسائل</div>

<div class="messages-layout" style="height:auto;">
    <?php if (empty($conversations)): ?>
        <div class="empty-state" style="width:100%;">
            <h3>ماكو محادثات هسه</h3>
            <p>سوّي بحث عن شخص وابعثله رسالة من صفحة البروفايل تبعه</p>
        </div>
    <?php endif; ?>

    <?php foreach ($conversations as $c): ?>
        <a href="<?= url('/messages/' . $c['username']) ?>" class="conv-item" style="width:100%;">
            <img class="avatar avatar-sm" src="<?= $c['avatar'] ? url($c['avatar']) : 'https://api.dicebear.com/7.x/initials/svg?seed=' . urlencode($c['name']) ?>" alt="">
            <div style="flex:1;min-width:0;">
                <div style="font-weight:700;"><?= e($c['name']) ?> <span style="color:#536471;font-weight:400;">@<?= e($c['username']) ?></span></div>
                <div style="color:#536471;font-size:14px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?= e($c['last_message']) ?></div>
            </div>
            <div class="tweet-time"><?= timeAgo($c['created_at']) ?></div>
        </a>
    <?php endforeach; ?>
</div>

<?php require __DIR__ . '/../partials/layout_end.php'; ?>
