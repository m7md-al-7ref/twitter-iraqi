<?php

class AuthController
{
    public function showRegister(): void
    {
        require __DIR__ . '/../../resources/views/auth/register.php';
    }

    public function showLogin(): void
    {
        require __DIR__ . '/../../resources/views/auth/login.php';
    }

    public function register(): void
    {
        $name = trim($_POST['name'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $errors = [];
        if ($name === '' || mb_strlen($name) < 3) $errors[] = 'الاسم لازم يكون 3 أحرف أو أكثر';
        if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) $errors[] = 'اسم المستخدم لازم يكون حروف إنكليزية وأرقام بس (3-20 حرف)';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'الإيميل غير صحيح';
        if (strlen($password) < 6) $errors[] = 'كلمة السر لازم تكون 6 أحرف أو أكثر';
        if (User::findByUsername($username)) $errors[] = 'اسم المستخدم هذا مستخدم من قبل';
        if (User::findByEmail($email)) $errors[] = 'الإيميل هذا مسجل من قبل';

        if ($errors) {
            $old = compact('name', 'username', 'email');
            require __DIR__ . '/../../resources/views/auth/register.php';
            return;
        }

        $userId = User::create(compact('name', 'username', 'email', 'password'));
        $_SESSION['user_id'] = $userId;
        redirect('/');
    }

    public function login(): void
    {
        $login = trim($_POST['login'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = User::findByEmail($login) ?? User::findByUsername($login);

        if (!$user || !password_verify($password, $user['password'])) {
            $errors = ['بيانات الدخول غير صحيحة'];
            require __DIR__ . '/../../resources/views/auth/login.php';
            return;
        }

        $_SESSION['user_id'] = $user['id'];
        redirect('/');
    }

    public function logout(): void
    {
        session_destroy();
        redirect('/login');
    }
}
