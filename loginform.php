<?php
// ...existing code...
// يجب وضع إعدادات الجلسة قبل session_start()
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_lifetime', 0);

session_start();

// الاتصال بقاعدة البيانات
$conn = mysqli_connect('localhost', 'root', '', 'eva');
if (!$conn) {
    $error = 'فشل الاتصال بقاعدة البيانات.';
}

// إذا كان المستخدم مسجلاً بالفعل، توجيهه مباشرة بعد التحقق من وجوده في قاعدة البيانات
if (empty($error) && !empty($_SESSION['Id_student'])) {
    $query = "SELECT Id_student FROM student WHERE Id_student = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $_SESSION['Id_student']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        header('Location: EvaluationStudent.php');
        exit();
    } else {
        session_unset();
        session_destroy();
    }
}

// معالجة إرسال النموذج (مصحح: لا تكرار if)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit']) && empty($error)) {
    $Id_student = trim($_POST['Id_student'] ?? '');
    $phone = trim($_POST['phone_no'] ?? '');

    // اضبط القواعد حسب طولهما الفعلي؛ هنا نسمح حتى 10 أرقام للهوية و7-9 للهاتـف
    if ($Id_student === '' || !preg_match('/^\d{1,10}$/', $Id_student)) {
        $error = 'رقم الهوية غير صالح.';
    } elseif ($phone === '' || !preg_match('/^\d{7,9}$/', $phone)) {
        $error = 'رقم الهاتف غير صالح.';
    } else {
        $query = "SELECT Id_student FROM student WHERE Id_student = ? AND phone_no = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $Id_student, $phone);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            session_regenerate_id(true);
            $_SESSION['Id_student'] = $Id_student;
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header('Location: EvaluationStudent.php');
            exit();
        } else {
            $error = 'بيانات الدخول غير صحيحة.';
            mysqli_stmt_close($stmt);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link href="loginform.css" rel="stylesheet">
    <meta charset="utf-8">
    <title>تسجيل دخول الطالب</title>
</head>
<body>
    <div class="login-wrap">
        <div class="login-html">
            <input id="tab-1" type="radio" name="tab" class="sign-in" checked>
            <label for="tab-1" class="tab">تسجيل الدخول</label>
            <div class="login-form">
                <?php if(!empty($error)): ?>
                    <div class="error-message" style="color:red; margin-bottom:15px;">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <form action="" method="post" autocomplete="off">    
                <div class="group">
                <label for="Id_student" class="label">رقم الهوية</label>
                <input type="text" name="Id_student" id="Id_student" class="input" maxlength="10" value="<?php echo htmlspecialchars($Id_student ?? ''); ?>" required>
            </div>
            
            <div class="group">
                <label for="phone_no" class="label">رقم الهاتف</label>
                <input id="phone_no" type="text" name="phone_no" class="input" data-type="phone_no" maxlength="9" value="<?php echo htmlspecialchars($phone ?? ''); ?>" required>
            </div>
            
            <div class="group">
                <input id="check" name="remember" type="checkbox" class="check" <?php echo !empty($_POST['remember']) ? 'checked' : ''; ?>>
                <label for="check"><span class="icon"></span> تذكرني</label>
            </div>
                    
                    <div class="group">
                        <button type="submit" name="submit" class="button">تسجيل الدخول</button>
                    </div>
                </form>
                
                <div class="group">
                    <a class="small" href="RegisterStudent.php">إنشاء حساب جديد</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>