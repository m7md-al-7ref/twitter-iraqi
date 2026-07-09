<?php
/**
 * يستخدم بالصفحات الداخلية (بعد تسجيل الدخول)
 * يتوقع وجود $user = currentUser()
 */
$user = $user ?? currentUser();
$unread = Notification::unreadCount($user['id']);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= isset($pageTitle) ? e($pageTitle) . ' - تويتر عراقي' : 'تويتر عراقي' ?></title>
<link rel="stylesheet" href="<?= url('resources/css/style.css') ?>">
</head>
<body>
<div class="container">

    <aside class="sidebar">
        <a href="<?= url('/') ?>" class="logo">𝕏 <span>تويتر عراقي</span></a>

        <a href="<?= url('/') ?>" class="nav-item <?= ($active ?? '') === 'home' ? 'active' : '' ?>">
            <span class="nav-icon">🏠</span><span class="nav-text">الرئيسية</span>
        </a>
        <a href="<?= url('/explore') ?>" class="nav-item <?= ($active ?? '') === 'explore' ? 'active' : '' ?>">
            <span class="nav-icon">🔍</span><span class="nav-text">استكشف</span>
        </a>
        <a href="<?= url('/notifications') ?>" class="nav-item <?= ($active ?? '') === 'notifications' ? 'active' : '' ?>">
            <span class="nav-icon">🔔</span><span class="nav-text">الإشعارات</span>
            <?php if ($unread > 0): ?><span class="badge"><?= $unread ?></span><?php endif; ?>
        </a>
        <a href="<?= url('/messages') ?>" class="nav-item <?= ($active ?? '') === 'messages' ? 'active' : '' ?>">
            <span class="nav-icon">✉️</span><span class="nav-text">الرسائل</span>
        </a>
        <a href="<?= url('/profile/' . $user['username']) ?>" class="nav-item <?= ($active ?? '') === 'profile' ? 'active' : '' ?>">
            <span class="nav-icon">👤</span><span class="nav-text">حسابي</span>
        </a>
        <a href="<?= url('/settings') ?>" class="nav-item <?= ($active ?? '') === 'settings' ? 'active' : '' ?>">
            <span class="nav-icon">⚙️</span><span class="nav-text">الإعدادات</span>
        </a>

        <form action="<?= url('/posts') ?>" method="POST" enctype="multipart/form-data" style="display:contents" id="quickComposeForm">
        </form>
        <button class="tweet-btn" onclick="document.getElementById('composeText')?.focus()"><span>غرّد</span> ✏️</button>

        <a href="<?= url('/profile/' . $user['username']) ?>" class="sidebar-user">
            <img class="avatar avatar-sm" src="<?= $user['avatar'] ? url($user['avatar']) : 'https://api.dicebear.com/7.x/initials/svg?seed=' . urlencode($user['name']) ?>" alt="">
            <div class="suggestion-info">
                <div class="suggestion-name"><?= e($user['name']) ?></div>
                <div class="suggestion-username">@<?= e($user['username']) ?></div>
            </div>
        </a>
        <a href="<?= url('/logout') ?>" class="nav-item" style="font-size:14px;color:#f4212e;">تسجيل خروج ⏻</a>
    </aside>

    <main class="main">
