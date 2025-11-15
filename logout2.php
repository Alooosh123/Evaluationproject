<?php
// إعدادات الجلسة أولاً
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_lifetime', 0);

session_start();

// تدمير كامل للجلسة
$_SESSION = array();

// حذف كوكيز الجلسة
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

session_unset();
session_destroy();

// التوجيه لصفحة الدخول مع إضافة بارامتر
header('Location: loginform.php?logout=success');
exit();
?>