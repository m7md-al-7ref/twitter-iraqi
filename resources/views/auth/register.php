<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>حساب جديد - تويتر عراقي</title>
<link rel="stylesheet" href="<?= url('resources/css/style.css') ?>">
</head>
<body>
<div class="auth-page">
    <div class="auth-box">
        <div class="logo">𝕏 <span style="color:#0f1419">تويتر عراقي</span></div>
        <h1>سوّي حساب جديد</h1>

        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <?php foreach ($errors as $err): ?><div><?= e($err) ?></div><?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="<?= url('/register') ?>" method="POST">
            <div class="form-group">
                <label>الاسم الكامل</label>
                <input type="text" name="name" value="<?= e($old['name'] ?? '') ?>" required autofocus>
            </div>
            <div class="form-group">
                <label>اسم المستخدم (إنكليزي بدون مسافات)</label>
                <input type="text" name="username" value="<?= e($old['username'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>الإيميل</label>
                <input type="email" name="email" value="<?= e($old['email'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>كلمة السر</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn-block">إنشاء حساب</button>
        </form>

        <div class="auth-switch">
            عندك حساب أصلاً؟ <a href="<?= url('/login') ?>">سجّل دخولك</a>
        </div>
    </div>
</div>
</body>
</html>
