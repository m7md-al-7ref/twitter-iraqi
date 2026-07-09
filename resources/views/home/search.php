<?php
$pageTitle = 'البحث';
$active = '';
require __DIR__ . '/../partials/layout_start.php';
?>
<div class="main-header">نتائج البحث عن: "<?= e($_GET['q'] ?? '') ?>"</div>

<?php if (empty($results)): ?>
    <div class="empty-state">
        <h3>ماكو نتائج</h3>
        <p>جرب تدور باسم مختلف</p>
    </div>
<?php endif; ?>

<?php foreach ($results as $r): ?>
    <div class="tweet">
        <a href="<?= url('/profile/' . $r['username']) ?>">
            <img class="avatar" src="<?= $r['avatar'] ? url($r['avatar']) : 'https://api.dicebear.com/7.x/initials/svg?seed=' . urlencode($r['name']) ?>" alt="">
        </a>
        <div class="tweet-body">
            <a href="<?= url('/profile/' . $r['username']) ?>" class="tweet-name"><?= e($r['name']) ?></a><br>
            <span class="tweet-username">@<?= e($r['username']) ?></span>
            <?php if (!empty($r['bio'])): ?><div class="tweet-content"><?= e($r['bio']) ?></div><?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>

<?php require __DIR__ . '/../partials/layout_end.php'; ?>
