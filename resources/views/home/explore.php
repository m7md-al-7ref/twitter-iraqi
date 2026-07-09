<?php
$pageTitle = 'استكشف';
$active = 'explore';
require __DIR__ . '/../partials/layout_start.php';
?>
<div class="main-header">استكشف</div>

<?php if (empty($posts)): ?>
    <div class="empty-state">
        <h3>ماكو تغريدات هسه</h3>
    </div>
<?php endif; ?>

<?php foreach ($posts as $post): ?>
    <?php require __DIR__ . '/../partials/tweet.php'; ?>
<?php endforeach; ?>

<?php require __DIR__ . '/../partials/layout_end.php'; ?>
