<?php
$pageTitle = $profileUser['name'];
$active = ($profileUser['id'] == $viewer['id']) ? 'profile' : '';
$user = $viewer;
require __DIR__ . '/../partials/layout_start.php';
?>
<div class="main-header">
    <div style="font-weight:800;"><?= e($profileUser['name']) ?></div>
    <div style="font-size:13px;color:#536471;font-weight:400;"><?= User::postsCount($profileUser['id']) ?> تغريدة</div>
</div>

<div class="profile-cover" style="<?= $profileUser['cover'] ? 'background-image:url(' . url($profileUser['cover']) . ')' : '' ?>"></div>

<div class="profile-info">
    <div class="profile-top">
        <img class="avatar avatar-lg" src="<?= $profileUser['avatar'] ? url($profileUser['avatar']) : 'https://api.dicebear.com/7.x/initials/svg?seed=' . urlencode($profileUser['name']) ?>" alt="">

        <?php if ($profileUser['id'] == $viewer['id']): ?>
            <a href="<?= url('/settings') ?>" class="edit-profile-btn">عدّل البروفايل</a>
        <?php else: ?>
            <div style="display:flex;gap:8px;">
                <a href="<?= url('/messages/' . $profileUser['username']) ?>" class="edit-profile-btn">✉️</a>
                <form action="<?= url('/follow') ?>" method="POST">
                    <input type="hidden" name="user_id" value="<?= $profileUser['id'] ?>">
                    <button type="submit" class="follow-btn <?= $isFollowing ? 'following' : '' ?>">
                        <?= $isFollowing ? 'متابَع' : 'متابعة' ?>
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <div class="profile-name"><?= e($profileUser['name']) ?></div>
    <div class="profile-username">@<?= e($profileUser['username']) ?></div>

    <?php if (!empty($profileUser['bio'])): ?>
        <div class="profile-bio"><?= nl2br(e($profileUser['bio'])) ?></div>
    <?php endif; ?>

    <div class="profile-meta">
        <?php if (!empty($profileUser['location'])): ?>📍 <?= e($profileUser['location']) ?> · <?php endif; ?>
        📅 انضم بـ<?= date('F Y', strtotime($profileUser['created_at'])) ?>
    </div>

    <div class="profile-stats">
        <span><b><?= $followingCount ?></b> يتابع</span>
        <span><b><?= $followersCount ?></b> متابع</span>
    </div>
</div>

<div style="border-bottom:1px solid #e1e8ed;padding:12px 16px;font-weight:700;">التغريدات</div>

<?php if (empty($posts)): ?>
    <div class="empty-state">
        <h3>ماكو تغريدات هسه</h3>
    </div>
<?php endif; ?>

<?php foreach ($posts as $post): ?>
    <?php require __DIR__ . '/../partials/tweet.php'; ?>
<?php endforeach; ?>

<?php require __DIR__ . '/../partials/layout_end.php'; ?>
