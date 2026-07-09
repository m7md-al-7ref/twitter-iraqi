<?php
/** @var array $post */
/** @var array $user current logged in user */
$liked = !empty($post['liked_by_me']);
?>
<div class="tweet">
    <a href="<?= url('/profile/' . $post['username']) ?>">
        <img class="avatar" src="<?= $post['avatar'] ? url($post['avatar']) : 'https://api.dicebear.com/7.x/initials/svg?seed=' . urlencode($post['name']) ?>" alt="">
    </a>
    <div class="tweet-body">
        <div class="tweet-header">
            <a href="<?= url('/profile/' . $post['username']) ?>" class="tweet-name"><?= e($post['name']) ?></a>
            <span class="tweet-username">@<?= e($post['username']) ?></span>
            <span class="tweet-username">·</span>
            <span class="tweet-time"><?= timeAgo($post['created_at']) ?></span>

            <?php if ($post['user_id'] == $user['id']): ?>
                <form action="<?= url('/posts/' . $post['id'] . '/delete') ?>" method="POST" style="margin-right:auto;"
                      onsubmit="return confirm('متأكد تريد تحذف التغريدة؟');">
                    <button type="submit" class="tweet-action delete" title="حذف">🗑️</button>
                </form>
            <?php endif; ?>
        </div>

        <a href="<?= url('/posts/' . $post['id']) ?>" style="display:block;">
            <?php if (!empty($post['content'])): ?>
                <div class="tweet-content"><?= nl2br(e($post['content'])) ?></div>
            <?php endif; ?>
            <?php if (!empty($post['image'])): ?>
                <img class="tweet-image" src="<?= url($post['image']) ?>" alt="">
            <?php endif; ?>
        </a>

        <div class="tweet-actions">
            <a href="<?= url('/posts/' . $post['id']) ?>" class="tweet-action">
                💬 <span><?= (int) ($post['comments_count'] ?? 0) ?></span>
            </a>
            <button class="tweet-action like-btn <?= $liked ? 'liked' : '' ?>" data-post-id="<?= $post['id'] ?>">
                <span class="like-icon"><?= $liked ? '❤️' : '🤍' ?></span>
                <span class="like-count"><?= (int) ($post['likes_count'] ?? 0) ?></span>
            </button>
        </div>
    </div>
</div>
