<?php
$pageTitle = 'الإعدادات';
$active = 'settings';
require __DIR__ . '/../partials/layout_start.php';
?>
<div class="main-header">تعديل البروفايل</div>

<div style="padding:20px;">
    <form action="<?= url('/settings') ?>" method="POST" enctype="multipart/form-data">

        <div class="profile-cover" style="margin:-20px -20px 0;<?= $user['cover'] ? 'background-image:url(' . url($user['cover']) . ')' : '' ?>"></div>
        <div style="display:flex;align-items:center;gap:16px;margin-top:-50px;margin-bottom:16px;">
            <img class="avatar avatar-lg" style="margin-top:0" src="<?= $user['avatar'] ? url($user['avatar']) : 'https://api.dicebear.com/7.x/initials/svg?seed=' . urlencode($user['name']) ?>" alt="">
        </div>

        <div class="form-group">
            <label>صورة الغلاف</label>
            <input type="file" name="cover" accept="image/*">
        </div>

        <div class="form-group">
            <label>الصورة الشخصية</label>
            <input type="file" name="avatar" accept="image/*">
        </div>

        <div class="form-group">
            <label>الاسم</label>
            <input type="text" name="name" value="<?= e($user['name']) ?>">
        </div>

        <div class="form-group">
            <label>نبذة عنك</label>
            <textarea name="bio" rows="3"><?= e($user['bio'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label>المكان</label>
            <input type="text" name="location" value="<?= e($user['location'] ?? '') ?>" placeholder="مثلاً: بغداد، العراق">
        </div>

        <button type="submit" class="btn-primary" style="padding:12px 30px;">حفظ التغييرات</button>
    </form>
</div>

<?php require __DIR__ . '/../partials/layout_end.php'; ?>
