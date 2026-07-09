<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>تسجيل الدخول - تويتر عراقي</title>
<link rel="stylesheet" href="<?= url('resources/css/style.css') ?>">
</head>
<body>
<div class="auth-page">
    <div class="auth-box">
        <div class="logo">𝕏 <span style="color:#0f1419">تويتر عراقي</span></div>
        <h1>سجّل دخولك</h1>

        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <?php foreach ($errors as $err): ?><div><?= e($err) ?></div><?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="<?= url('/login') ?>" method="POST">
            <div class="form-group">
                <label>الإيميل أو اسم المستخدم</label>
                <input type="text" name="login" required autofocus>
            </div>
            <div class="form-group">
                <label>كلمة السر</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn-block">دخول</button>
        </form>

        <div class="auth-switch">
            ماعندك حساب؟ <a href="<?= url('/register') ?>">أنشئ حساب جديد</a>
        </div>
    </div>
</div>
</body>
</html>
