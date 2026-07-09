<?php
$pageTitle = 'الرئيسية';
$active = 'home';
$sugg = $suggestions;
require __DIR__ . '/../partials/layout_start.php';
?>
<div class="main-header">الرئيسية</div>

<div class="compose">
    <img class="avatar" src="<?= $user['avatar'] ? url($user['avatar']) : 'https://api.dicebear.com/7.x/initials/svg?seed=' . urlencode($user['name']) ?>" alt="">
    <form action="<?= url('/posts') ?>" method="POST" enctype="multipart/form-data" style="flex:1">
        <textarea id="composeText" name="content" placeholder="شنو صاير؟ گول شي..." maxlength="280"></textarea>
        <div class="compose-actions">
            <label title="أضف صورة">
                🖼️
                <input type="file" name="image" accept="image/*">
            </label>
            <button type="submit" class="btn-primary">غرّد</button>
        </div>
    </form>
</div>

<?php if (empty($posts)): ?>
    <div class="empty-state">
        <h3>ماكو تغريدات هسه</h3>
        <p>تابع ناس أو غرّد أول تغريدة عندك!</p>
    </div>
<?php endif; ?>

<?php foreach ($posts as $post): ?>
    <?php require __DIR__ . '/../partials/tweet.php'; ?>
<?php endforeach; ?>

<?php require __DIR__ . '/../partials/layout_end.php'; ?>
