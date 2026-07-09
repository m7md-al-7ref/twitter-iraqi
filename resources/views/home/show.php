<?php
$pageTitle = 'التغريدة';
$active = '';
require __DIR__ . '/../partials/layout_start.php';
?>
<div class="main-header">
    <a href="javascript:history.back()" style="margin-left:10px;">←</a>
    التغريدة
</div>

<?php
$post['comments_count'] = count($comments);
require __DIR__ . '/../partials/tweet.php';
?>

<div class="compose">
    <img class="avatar avatar-sm" src="<?= $user['avatar'] ? url($user['avatar']) : 'https://api.dicebear.com/7.x/initials/svg?seed=' . urlencode($user['name']) ?>" alt="">
    <form action="<?= url('/comments') ?>" method="POST" style="flex:1;display:flex;gap:8px;">
        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
        <input type="text" name="comment" placeholder="اكتب ردّك..." required
               style="flex:1;border:1px solid #e1e8ed;border-radius:999px;padding:10px 16px;outline:none;font-family:inherit;">
        <button type="submit" class="btn-primary">رد</button>
    </form>
</div>

<?php foreach ($comments as $c): ?>
    <div class="tweet">
        <a href="<?= url('/profile/' . $c['username']) ?>">
            <img class="avatar" src="<?= $c['avatar'] ? url($c['avatar']) : 'https://api.dicebear.com/7.x/initials/svg?seed=' . urlencode($c['name']) ?>" alt="">
        </a>
        <div class="tweet-body">
            <div class="tweet-header">
                <a href="<?= url('/profile/' . $c['username']) ?>" class="tweet-name"><?= e($c['name']) ?></a>
                <span class="tweet-username">@<?= e($c['username']) ?></span>
                <span class="tweet-username">·</span>
                <span class="tweet-time"><?= timeAgo($c['created_at']) ?></span>

                <?php if ($c['user_id'] == $user['id']): ?>
                    <form action="<?= url('/comments/' . $c['id'] . '/delete') ?>" method="POST" style="margin-right:auto;"
                          onsubmit="return confirm('تحذف الرد؟');">
                        <button type="submit" class="tweet-action delete">🗑️</button>
                    </form>
                <?php endif; ?>
            </div>
            <div class="tweet-content"><?= nl2br(e($c['comment'])) ?></div>
        </div>
    </div>
<?php endforeach; ?>

<?php require __DIR__ . '/../partials/layout_end.php'; ?>
