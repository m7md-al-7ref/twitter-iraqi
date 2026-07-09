<?php
$pageTitle = 'محادثة مع ' . $otherUser['name'];
$active = 'messages';
require __DIR__ . '/../partials/layout_start.php';
?>
<div class="main-header">
    <a href="<?= url('/messages') ?>" style="margin-left:10px;">←</a>
    <?= e($otherUser['name']) ?>
    <span style="color:#536471;font-weight:400;">@<?= e($otherUser['username']) ?></span>
</div>

<div class="conv-messages" style="max-height:60vh;overflow-y:auto;padding:16px;">
    <?php if (empty($messages)): ?>
        <p style="text-align:center;color:#536471;">ابعث أول رسالة لـ<?= e($otherUser['name']) ?> 👋</p>
    <?php endif; ?>
    <?php foreach ($messages as $m): ?>
        <div class="msg-bubble <?= $m['sender_id'] == $user['id'] ? 'msg-mine' : 'msg-theirs' ?>">
            <?= nl2br(e($m['message'])) ?>
        </div>
    <?php endforeach; ?>
</div>

<form action="<?= url('/messages') ?>" method="POST" class="conv-form">
    <input type="hidden" name="username" value="<?= e($otherUser['username']) ?>">
    <input type="text" name="message" placeholder="اكتب رسالتك..." required autofocus>
    <button type="submit" class="btn-primary">إرسال</button>
</form>

<?php require __DIR__ . '/../partials/layout_end.php'; ?>
