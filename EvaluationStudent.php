<?php
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_lifetime', 0);

session_start();

if (empty($_SESSION['Id_student'])) {
    header('Location: loginform.php?reason=not_logged_in');
    exit();
}

$conn = mysqli_connect('localhost', 'root', '', 'eva');
if (!$conn) {
    die("فشل الاتصال بقاعدة البيانات: " . mysqli_connect_error());
}

if (isset($_GET['clear_academic'])) {
    unset($_SESSION['Id_Academic_selected'], $_SESSION['eval_queue'], $_SESSION['eval_index']);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

function get_question_columns($conn, $table) {
    $cols = [];
    $res = @mysqli_query($conn, "DESCRIBE `{$table}`");
    if (!$res) return ['id'=>null,'text'=>null];
    while ($r = mysqli_fetch_assoc($res)) $cols[] = $r['Field'];

    $id_prior = ['Id_question_lecturer','Id_question_course','Id_question','id_question','Id','id','id_q','Id_q','Id_question'];
    $text_prior = ['text_question_lecturer','text_qestion_lecturer','text_question_course','text_qestion_course','question_text','text_question','text','question','name','title'];

    $found_id = null;
    foreach ($id_prior as $c) if (in_array($c, $cols, true)) { $found_id = $c; break; }
    if (!$found_id) {
        foreach ($cols as $c) {
            if (preg_match('/(^id$|^id[_A-Z]|_id$)/i', $c)) { $found_id = $c; break; }
        }
    }
    if (!$found_id) $found_id = $cols[0] ?? null;

    $found_text = null;
    foreach ($text_prior as $t) if (in_array($t, $cols, true)) { $found_text = $t; break; }
    if (!$found_text) {
        foreach ($cols as $c) {
            if ($c === $found_id) continue;
            if (preg_match('/(text|question|name|title)/i', $c)) { $found_text = $c; break; }
        }
    }
    if (!$found_text) {
        foreach ($cols as $c) {
            if ($c !== $found_id) { $found_text = $c; break; }
        }
    }
    if (!$found_text) $found_text = $found_id;

    return ['id' => $found_id, 'text' => $found_text];
}

$academic_list = [];
$academic_error = '';
$cols_res = @mysqli_query($conn, "DESCRIBE `acadmaicc`");
if ($cols_res) {
    $cols = [];
    while ($c = mysqli_fetch_assoc($cols_res)) { $cols[] = $c['Field']; }
    $name_col = in_array('Academic_name', $cols) ? 'Academic_name' : null;
    if (!$name_col) {
        foreach ($cols as $col) {
            if (stripos($col, 'id') === false) { $name_col = $col; break; }
        }
    }
    if (!$name_col) $name_col = 'Id_AcadmicC';
    $sql = "SELECT Id_AcadmicC, `$name_col` AS Academic_name FROM `acadmaicc` ORDER BY Id_AcadmicC DESC";
    $academic_q = mysqli_query($conn, $sql);
    if ($academic_q) {
        while ($row = mysqli_fetch_assoc($academic_q)) {
            $academic_list[] = ['Id_AcadmicC' => $row['Id_AcadmicC'], 'Academic_name' => $row['Academic_name']];
        }
    } else {
        $academic_error = "فشل جلب السنوات الأكاديمية: " . mysqli_error($conn);
    }
} else {
    $academic_error = "تعذّر الوصول إلى جدول acadmaicc أو وصف أعمدته: " . mysqli_error($conn);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['select_academic'])) {
    $selected = intval($_POST['select_academic']);
    $found = false;
    foreach ($academic_list as $a) { if ((int)$a['Id_AcadmicC'] === $selected) { $found = true; break; } }
    if ($found) {
        $_SESSION['Id_Academic_selected'] = $selected;
        unset($_SESSION['eval_queue'], $_SESSION['eval_index']);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $academic_error = "السنة الأكاديمية المختارة غير صالحة.";
    }
}

$selected_academic = isset($_SESSION['Id_Academic_selected']) ? (int)$_SESSION['Id_Academic_selected'] : null;

$query = "SELECT Id_student, id_semester FROM student WHERE Id_student = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $_SESSION['Id_student']);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
if (!$res || mysqli_num_rows($res) == 0) {
    session_unset();
    session_destroy();
    header('Location: loginform.php?reason=invalid_user');
    exit();
}
$student_row = mysqli_fetch_assoc($res);
$student_semester = isset($student_row['id_semester']) ? intval($student_row['id_semester']) : null;
$student_id = isset($student_row['Id_student']) ? intval($student_row['Id_student']) : 0;

if ($selected_academic && empty($_SESSION['eval_queue'])) {
    $queue = [];

    $pd_cols_raw = [];
    $pd_cols_res = @mysqli_query($conn, "DESCRIBE `plandetail`");
    if ($pd_cols_res) while ($r = mysqli_fetch_assoc($pd_cols_res)) $pd_cols_raw[] = $r['Field'];

    $plan_cols_raw = [];
    $plan_cols_res = @mysqli_query($conn, "DESCRIBE `plan`");
    if ($plan_cols_res) while ($r = mysqli_fetch_assoc($plan_cols_res)) $plan_cols_raw[] = $r['Field'];

    $pd_lower = array_map('strtolower', $pd_cols_raw);
    $plan_lower = array_map('strtolower', $plan_cols_raw);

    $pd_has_sem = in_array('id_semester', $pd_lower);
    $pd_has_lect = in_array('id_lecturer', $pd_lower);
    $pd_has_student = in_array('id_student', $pd_lower);

    $plan_fk_raw = null;
    foreach ($pd_cols_raw as $c) {
        $cl = strtolower($c);
        if (strpos($cl, 'plan') !== false && strpos($cl, 'plandetail') === false && strtolower($c) !== 'id_plandetail') {
            $plan_fk_raw = $c; break;
        }
    }

    $plan_pk_raw = null;
    foreach ($plan_cols_raw as $c) {
        $cl = strtolower($c);
        if (in_array($cl, ['id_plan','id','idplan','id_p'])) { $plan_pk_raw = $c; break; }
    }
    if (!$plan_pk_raw) {
        foreach ($plan_cols_raw as $c) {
            $cl = strtolower($c);
            if (strpos($cl,'plan') !== false && strpos($cl,'id') !== false) { $plan_pk_raw = $c; break; }
        }
    }
    if (!$plan_pk_raw) {
        foreach ($plan_cols_raw as $c) {
            if (stripos($c,'id') !== false) { $plan_pk_raw = $c; break; }
        }
    }

    $use_plan_join = ($plan_fk_raw && $plan_pk_raw && in_array(strtolower($plan_pk_raw), $plan_lower));

    if ($pd_has_lect) {
        if ($pd_has_sem) {
            $sql = "SELECT pd.id_planDetail, pd.id_course, c.name_course, pd.id_lecturer AS id_lecturer, l.name_lecturer
                    FROM plandetail pd
                    JOIN course c ON pd.id_course = c.id_course
                    LEFT JOIN lecturer l ON pd.id_lecturer = l.Id_lecturer
                    WHERE pd.id_student = ? AND pd.id_semester = ?";
            $params = [$student_id, $student_semester]; $types = "ii";
        } elseif ($use_plan_join) {
            $sql = "SELECT pd.id_planDetail, pd.id_course, c.name_course, pd.id_lecturer AS id_lecturer, l.name_lecturer
                    FROM plandetail pd
                    JOIN plan p ON pd.`" . $plan_fk_raw . "` = p.`" . $plan_pk_raw . "`
                    JOIN course c ON pd.id_course = c.id_course
                    LEFT JOIN lecturer l ON pd.id_lecturer = l.Id_lecturer
                    WHERE pd.id_student = ? AND p.id_semester = ?";
            $params = [$student_id, $student_semester]; $types = "ii";
        } else {
            $sql = "SELECT pd.id_planDetail, pd.id_course, c.name_course, pd.id_lecturer AS id_lecturer, l.name_lecturer
                    FROM plandetail pd
                    JOIN course c ON pd.id_course = c.id_course
                    LEFT JOIN lecturer l ON pd.id_lecturer = l.Id_lecturer
                    WHERE pd.id_student = ?";
            $params = [$student_id]; $types = "i";
        }
    } else {
        if ($pd_has_sem) {
            $sql = "SELECT pd.id_planDetail, pd.id_course, c.name_course
                    FROM plandetail pd
                    JOIN course c ON pd.id_course = c.id_course
                    WHERE pd.id_student = ? AND pd.id_semester = ?";
            $params = [$student_id, $student_semester]; $types = "ii";
        } elseif ($use_plan_join) {
            $sql = "SELECT pd.id_planDetail, pd.id_course, c.name_course
                    FROM plandetail pd
                    JOIN plan p ON pd.`" . $plan_fk_raw . "` = p.`" . $plan_pk_raw . "`
                    JOIN course c ON pd.id_course = c.id_course
                    WHERE pd.id_student = ? AND p.id_semester = ?";
            $params = [$student_id, $student_semester]; $types = "ii";
        } else {
            $sql = "SELECT pd.id_planDetail, pd.id_course, c.name_course
                    FROM plandetail pd
                    JOIN course c ON pd.id_course = c.id_course
                    WHERE pd.id_student = ?";
            $params = [$student_id]; $types = "i";
        }
    }

    if (!empty($sql)) {
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            if (!empty($params)) {
                $bind_names = []; $bind_names[] = $types;
                for ($i = 0; $i < count($params); $i++) $bind_names[] = & $params[$i];
                call_user_func_array([$stmt, 'bind_param'], $bind_names);
            }
            mysqli_stmt_execute($stmt);
            $q = mysqli_stmt_get_result($stmt);
            if ($q) {
                while ($r = mysqli_fetch_assoc($q)) {
                    $id_course = (int)$r['id_course'];
                    $lect_id = isset($r['id_lecturer']) ? (int)$r['id_lecturer'] : null;
                    $lect_name = $r['name_lecturer'] ?? null;
                    if (empty($lect_id)) {
                        $lk = mysqli_prepare($conn, "SELECT l.Id_lecturer, l.name_lecturer
                                                     FROM lecturer l
                                                     JOIN result rs ON rs.id_lecturer = l.Id_lecturer
                                                     WHERE rs.id_course = ? AND rs.Id_AcadmicC = ? LIMIT 1");
                        if ($lk) {
                            mysqli_stmt_bind_param($lk, "ii", $id_course, $selected_academic);
                            mysqli_stmt_execute($lk);
                            $lr = mysqli_stmt_get_result($lk);
                            if ($lr && mysqli_num_rows($lr) > 0) {
                                $lrrow = mysqli_fetch_assoc($lr);
                                $lect_id = (int)$lrrow['Id_lecturer'];
                                $lect_name = $lrrow['name_lecturer'];
                            }
                            mysqli_stmt_close($lk);
                        }
                    }
                    $queue[] = [
                        'id_planDetail' => $r['id_planDetail'],
                        'id_course' => $id_course,
                        'name_course' => $r['name_course'],
                        'id_lecturer' => $lect_id,
                        'name_lecturer' => $lect_name
                    ];
                }
            }
            mysqli_stmt_close($stmt);
        } else {
            error_log("Failed to prepare plandetail query: " . mysqli_error($conn));
        }
    }

    $_SESSION['eval_queue'] = $queue;
    $_SESSION['eval_index'] = 0;
}

$errors = [];
$success_message = $_SESSION['success_message'] ?? null;
unset($_SESSION['success_message']);

$ql_cols = get_question_columns($conn, 'question_lecturer');
$qc_cols = get_question_columns($conn, 'question_course');

if ($selected_academic && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit-evaluation'])) {
    $queue = $_SESSION['eval_queue'] ?? [];
    $index = $_SESSION['eval_index'] ?? 0;
    if (!isset($queue[$index])) {
        $errors[] = "لا يوجد عنصر للتقييم حالياً.";
    } else {
        $task = $queue[$index];
        $Avg_lecturer = isset($_POST['Avg_lecturer']) ? floatval($_POST['Avg_lecturer']) : 0;
        $Avg_course = isset($_POST['Avg_course']) ? floatval($_POST['Avg_course']) : 0;
        if ($Avg_lecturer < 0 || $Avg_lecturer > 5 || $Avg_course < 0 || $Avg_course > 5) {
            $errors[] = "قيم التقييم غير صالحة.";
        }
    }

    if (empty($errors)) {
        mysqli_begin_transaction($conn);
        try {
            $qL_idcol = $ql_cols['id'];
            $qC_idcol = $qc_cols['id'];
            $id_q_lect = null; $id_q_course = null;
            if ($qL_idcol) {
                $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT `" . $qL_idcol . "` AS idn FROM `question_lecturer` ORDER BY `" . $qL_idcol . "` LIMIT 1"));
                $id_q_lect = $r['idn'] ?? null;
            }
            if ($qC_idcol) {
                $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT `" . $qC_idcol . "` AS idn FROM `question_course` ORDER BY `" . $qC_idcol . "` LIMIT 1"));
                $id_q_course = $r['idn'] ?? null;
            }
            if (!$id_q_lect) $id_q_lect = 0;
            if (!$id_q_course) $id_q_course = 0;

            $insEval = mysqli_prepare($conn, "INSERT INTO evaluation (id_question_lecturer, id_question_course, date_time) VALUES (?, ?, NOW())");
            if (!$insEval) throw new Exception("فشل تحضير استعلام evaluation: " . mysqli_error($conn));
            mysqli_stmt_bind_param($insEval, "ii", $id_q_lect, $id_q_course);
            if (!mysqli_stmt_execute($insEval)) {
                throw new Exception("فشل في إدخال جدول evaluation: " . mysqli_stmt_error($insEval));
            }
            mysqli_stmt_close($insEval);
            $id_evaluation = mysqli_insert_id($conn);

            $insAvg = mysqli_prepare($conn, "INSERT INTO `avg` (Avg_lecturer, Avg_course, id_evaluation) VALUES (?, ?, ?)");
            if (!$insAvg) throw new Exception("فشل تحضير استعلام avg: " . mysqli_error($conn));
            mysqli_stmt_bind_param($insAvg, "ddi", $Avg_lecturer, $Avg_course, $id_evaluation);
            if (!mysqli_stmt_execute($insAvg)) {
                throw new Exception("فشل في إدخال avg: " . mysqli_stmt_error($insAvg));
            }
            mysqli_stmt_close($insAvg);
            $id_Avg = mysqli_insert_id($conn);

            $id_user = isset($_SESSION['Id_student']) ? intval($_SESSION['Id_student']) : 0;
            $id_lecturer = isset($task['id_lecturer']) ? intval($task['id_lecturer']) : 0;
            $id_course = isset($task['id_course']) ? intval($task['id_course']) : 0;
            $id_Academic = $selected_academic;

            $id_plan = null;
            $plan_pk = null;
            $pd_id = (int)($task['id_planDetail'] ?? 0);
            if ($pd_id) {
                $pd_cols = []; $res = @mysqli_query($conn, "DESCRIBE `plandetail`");
                if ($res) while ($r = mysqli_fetch_assoc($res)) $pd_cols[] = $r['Field'];

                $plan_cols = []; $res2 = @mysqli_query($conn, "DESCRIBE `plan`");
                if ($res2) while ($r = mysqli_fetch_assoc($res2)) $plan_cols[] = $r['Field'];

                $pk_prior = ['Id_plan','id_plan','Id','id','idplan','Id_Plan'];
                foreach ($pk_prior as $p) {
                    if (in_array($p, $plan_cols, true)) { $plan_pk = $p; break; }
                }
                if (!$plan_pk) $plan_pk = $plan_cols[0] ?? null;

                if ($plan_pk && !empty($pd_cols)) {
                    foreach ($pd_cols as $col) {
                        if ($col === 'id_planDetail') continue;
                        if (stripos($col, 'id') === false) continue;

                        $sql = "SELECT p.`{$plan_pk}` AS Id_plan
                                FROM `plandetail` pd
                                JOIN `plan` p ON pd.`{$col}` = p.`{$plan_pk}`
                                WHERE pd.`id_planDetail` = ? LIMIT 1";
                        $s = @mysqli_prepare($conn, $sql);
                        if (!$s) continue;
                        mysqli_stmt_bind_param($s, "i", $pd_id);
                        mysqli_stmt_execute($s);
                        $rr = mysqli_stmt_get_result($s);
                        if ($rr && mysqli_num_rows($rr) > 0) {
                            $prow = mysqli_fetch_assoc($rr);
                            $id_plan = (int)$prow['Id_plan'];
                            mysqli_stmt_close($s);
                            break;
                        }
                        mysqli_stmt_close($s);
                    }

                    if (!$id_plan) {
                        foreach ($pd_cols as $col) {
                            if (strcasecmp($col, $plan_pk) === 0) {
                                $s = @mysqli_prepare($conn, "SELECT `{$col}` AS val FROM `plandetail` WHERE `id_planDetail` = ? LIMIT 1");
                                if ($s) {
                                    mysqli_stmt_bind_param($s, "i", $pd_id);
                                    mysqli_stmt_execute($s);
                                    $rr = mysqli_stmt_get_result($s);
                                    if ($rr && mysqli_num_rows($rr) > 0) {
                                        $row = mysqli_fetch_assoc($rr);
                                        $val = intval($row['val']);
                                        $chk = mysqli_query($conn, "SELECT 1 FROM `plan` WHERE `{$plan_pk}` = " . intval($val) . " LIMIT 1");
                                        if ($chk && mysqli_num_rows($chk) > 0) { $id_plan = $val; }
                                    }
                                    mysqli_stmt_close($s);
                                }
                                break;
                            }
                        }
                    }
                }
            }

            if (!$id_plan) {
                throw new Exception("تعذّر تحديد الخطة (Id_plan) المرتبطة بعنصر الطابور. لا يمكن حفظ النتيجة بدون مرجع الخطة.");
            }

            $chk = function($sql) use ($conn) {
                $r = mysqli_query($conn, $sql);
                return ($r && mysqli_num_rows($r) > 0);
            };
            $plan_check_col = $plan_pk ?: 'Id_plan';
            if (!$chk("SELECT 1 FROM acadmaicc WHERE Id_AcadmicC = " . intval($id_Academic) . " LIMIT 1")
             || !$chk("SELECT 1 FROM course WHERE id_course = " . intval($id_course) . " LIMIT 1")
             || ($id_lecturer != 0 && !$chk("SELECT 1 FROM lecturer WHERE Id_lecturer = " . intval($id_lecturer) . " LIMIT 1"))
             || !$chk("SELECT 1 FROM plan WHERE `" . $plan_check_col . "` = " . intval($id_plan) . " LIMIT 1")) {
                throw new Exception("فشل فحص المراجع (course/lecturer/academic/plan).");
            }

            $insRes = mysqli_prepare($conn, "INSERT INTO `result` (id_evaluation, id_Avg, id_lecturer, id_user, Id_AcadmicC, id_course, Id_plan) VALUES (?, ?, ?, ?, ?, ?, ?)");
            if (!$insRes) {
                throw new Exception("فشل تحضير استعلام result: " . mysqli_error($conn));
            }
            mysqli_stmt_bind_param($insRes, "iiiiiii",
                $id_evaluation,
                $id_Avg,
                $id_lecturer,
                $id_user,
                $id_Academic,
                $id_course,
                $id_plan
            );
            if (!mysqli_stmt_execute($insRes)) {
                throw new Exception("فشل في إدخال result: " . mysqli_stmt_error($insRes));
            }
            mysqli_stmt_close($insRes);

            if (!mysqli_commit($conn)) {
                throw new Exception("فشل في إتمام المعاملة: " . mysqli_error($conn));
            }

            $_SESSION['eval_index'] = ($index + 1);
            $_SESSION['success_message'] = "تم حفظ التقييم للكورس '" . ($task['name_course'] ?? '') . "'";
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();

        } catch (Exception $e) {
            mysqli_rollback($conn);
            $errors[] = "حدث خطأ أثناء حفظ التقييم: " . $e->getMessage();
            error_log($e->getMessage());
        }
    }
}

$queue = $_SESSION['eval_queue'] ?? [];
$index = $_SESSION['eval_index'] ?? 0;
$remaining = max(0, count($queue) - $index);
$current = $queue[$index] ?? null;
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <title>نموذج التقييم</title>
  <style>
    body{font-family:Arial, sans-serif; background:#f7f7f7; padding:20px}
    .box{max-width:900px;margin:20px auto;background:#fff;padding:20px;border-radius:6px;box-shadow:0 2px 8px rgba(0,0,0,.05)}
    .btn{padding:10px 14px;background:#2e86de;color:#fff;border:none;border-radius:4px;cursor:pointer}
    .muted{color:#666}
    .error{background:#ffecec;color:#c0392b;padding:10px;border-radius:4px;margin-bottom:10px}
    .success{background:#e8f8f5;color:#088c6f;padding:10px;border-radius:4px;margin-bottom:10px}
    .questions { display:block; margin-top:12px; }
    .q-col { width:100%; }
    .q-item { margin-bottom:10px; padding-bottom:6px; border-bottom:1px solid #f0f0f0; }
    .q-item strong{display:block;margin-bottom:6px}
    .radios label{display:inline-block;margin-left:8px}
    .meta { margin-bottom:10px; color:#444 }
  </style>
</head>
<body>
  <div class="box">
    <h2>نموذج التقييم</h2>

    <?php if (!empty($academic_error)): ?>
      <div class="error"><?= htmlspecialchars($academic_error) ?></div>
    <?php endif; ?>

    <?php if (!$selected_academic): ?>
      <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <label>اختر السنة الدراسية:</label>
        <select name="select_academic" required>
          <option value="">-- اختر --</option>
          <?php foreach($academic_list as $a): ?>
            <option value="<?= (int)$a['Id_AcadmicC'] ?>"><?= htmlspecialchars($a['Academic_name']) ?></option>
          <?php endforeach; ?>
        </select>
        <button class="btn" type="submit">فتح التقييم</button>
      </form>

    <?php else: ?>
      <div class="muted">السنة المُختارة:
        <?php
          $label = $selected_academic;
          foreach ($academic_list as $a) if ((int)$a['Id_AcadmicC'] === $selected_academic) { $label = $a['Academic_name']; break; }
          echo htmlspecialchars($label);
        ?>
        &nbsp; | &nbsp; المتبقي: <?= $remaining ?>
        &nbsp; | &nbsp; <a href="?clear_academic=1">تغيير السنة</a>
      </div>

      <?php if (!empty($errors)): ?>
        <div class="error"><ul><?php foreach($errors as $err) echo "<li>" . htmlspecialchars($err) . "</li>"; ?></ul></div>
      <?php endif; ?>
      <?php if (!empty($success_message)): ?>
        <div class="success"><?= htmlspecialchars($success_message) ?></div>
      <?php endif; ?>

      <?php if ($current): ?>
        <?php
          if (empty($current['name_lecturer']) && !empty($current['id_lecturer'])) {
              $lk = mysqli_prepare($conn, "SELECT name_lecturer FROM lecturer WHERE Id_lecturer = ? LIMIT 1");
              if ($lk) {
                  mysqli_stmt_bind_param($lk, "i", $current['id_lecturer']);
                  mysqli_stmt_execute($lk);
                  $lr = mysqli_stmt_get_result($lk);
                  if ($lr && mysqli_num_rows($lr) > 0) {
                      $r = mysqli_fetch_assoc($lr);
                      $current['name_lecturer'] = $r['name_lecturer'];
                  }
                  mysqli_stmt_close($lk);
              }
          }
        ?>
        <h3>تقييم: <?= htmlspecialchars($current['name_course']) ?></h3>
        <p class="meta">المحاضر: <?= htmlspecialchars($current['name_lecturer'] ?? 'غير محدد') ?></p>

        <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
          <input type="hidden" name="id_course" value="<?= (int)$current['id_course'] ?>">
          <input type="hidden" name="id_lecturer" value="<?= (int)($current['id_lecturer'] ?? 0) ?>">
          <input type="hidden" name="id_planDetail" value="<?= (int)$current['id_planDetail'] ?>">

          <div class="questions">
            <div class="q-col" id="lecturer-qs">
              <h4>أسئلة عن المحاضر</h4>
              <?php
                $ql_id = $ql_cols['id']; $ql_txt = $ql_cols['text'];
                if ($ql_id) {
                    if ($ql_txt && $ql_txt !== $ql_id) {
                        $sql = "SELECT `" . $ql_id . "` AS qid, `" . $ql_txt . "` AS qtxt FROM `question_lecturer` ORDER BY `" . $ql_id . "`";
                    } else {
                        $sql = "SELECT * FROM `question_lecturer` ORDER BY `" . $ql_id . "`";
                    }
                    $qlq = mysqli_query($conn, $sql);
                    if ($qlq && mysqli_num_rows($qlq) > 0) {
                        while ($row = mysqli_fetch_assoc($qlq)) {
                            $qid = $row['qid'] ?? ($row[$ql_id] ?? null);
                            $labelText = null;
                            if (isset($row['qtxt']) && strlen(trim((string)$row['qtxt'])) > 0) {
                                $labelText = $row['qtxt'];
                            } else {
                                foreach ($row as $colName => $colVal) {
                                    if ($colName === 'qid' || $colName === $ql_id) continue;
                                    if ($colVal !== null && strlen(trim((string)$colVal)) > 0) { $labelText = $colVal; break; }
                                }
                            }
                            if (!$labelText) $labelText = "سؤال " . htmlspecialchars((string)$qid);
                            $group = "lecturer_q_" . preg_replace('/[^a-z0-9_\\-]/i', '', (string)$qid);
                            echo "<div class='q-item'><strong>" . htmlspecialchars($labelText) . "</strong><div class='radios'>";
                            for ($v = 1; $v <= 5; $v++) {
                                echo "<label><input data-qgroup='" . htmlspecialchars($group) . "' type='radio' name='" . htmlspecialchars($group) . "' value='{$v}'> {$v}</label>";
                            }
                            echo "</div></div>";
                        }
                    } else {
                        echo "<div class='q-item'>لا توجد أسئلة للمحاضر</div>";
                    }
                } else {
                    echo "<div class='q-item'>لا توجد أسئلة للمحاضر</div>";
                }
              ?>
            </div>

            <div class="q-col" id="course-qs" style="margin-top:18px;">
              <h4>أسئلة عن المقرر</h4>
              <?php
                $qc_id = $qc_cols['id']; $qc_txt = $qc_cols['text'];
                if ($qc_id) {
                    if ($qc_txt && $qc_txt !== $qc_id) {
                        $sql = "SELECT `" . $qc_id . "` AS qid, `" . $qc_txt . "` AS qtxt FROM `question_course` ORDER BY `" . $qc_id . "`";
                    } else {
                        $sql = "SELECT * FROM `question_course` ORDER BY `" . $qc_id . "`";
                    }
                    $qcq = mysqli_query($conn, $sql);
                    if ($qcq && mysqli_num_rows($qcq) > 0) {
                        while ($row = mysqli_fetch_assoc($qcq)) {
                            $qid = $row['qid'] ?? ($row[$qc_id] ?? null);
                            $labelText = null;
                            if (isset($row['qtxt']) && strlen(trim((string)$row['qtxt'])) > 0) {
                                $labelText = $row['qtxt'];
                            } else {
                                foreach ($row as $colName => $colVal) {
                                    if ($colName === 'qid' || $colName === $qc_id) continue;
                                    if ($colVal !== null && strlen(trim((string)$colVal)) > 0) { $labelText = $colVal; break; }
                                }
                            }
                            if (!$labelText) $labelText = "سؤال " . htmlspecialchars((string)$qid);
                            $group = "course_q_" . preg_replace('/[^a-z0-9_\\-]/i', '', (string)$qid);
                            echo "<div class='q-item'><strong>" . htmlspecialchars($labelText) . "</strong><div class='radios'>";
                            for ($v = 1; $v <= 5; $v++) {
                                echo "<label><input data-qgroup='" . htmlspecialchars($group) . "' type='radio' name='" . htmlspecialchars($group) . "' value='{$v}'> {$v}</label>";
                            }
                            echo "</div></div>";
                        }
                    } else {
                        echo "<div class='q-item'>لا توجد أسئلة للمقرر</div>";
                    }
                } else {
                    echo "<div class='q-item'>لا توجد أسئلة للمقرر</div>";
                }
              ?>
            </div>
          </div>

          <input type="hidden" name="Avg_lecturer" id="Avg_lecturer" value="0">
          <input type="hidden" name="Avg_course" id="Avg_course" value="0">

          <div style="margin-top:12px">
            <button class="btn" type="submit" name="submit-evaluation">تسجيل التقييم الحالي</button>
            <a class="btn" href="logout2.php" style="background:#c0392b">تسجيل الخروج</a>
          </div>
        </form>

      <?php else: ?>
        <div>انتهت جميع الكورسات المخصصة لك لهذا العام الدراسي. شكراً لإكمال التقييم.</div>
      <?php endif; ?>

    <?php endif; ?>
  </div>

  <script>
    function calculateAndValidate() {
      const groups = new Set();
      document.querySelectorAll('input[data-qgroup]').forEach(i => groups.add(i.dataset.qgroup));

      let lecSum = 0, lecCnt = 0;
      let couSum = 0, couCnt = 0;
      let missing = [];

      groups.forEach(g => {
        const checked = document.querySelector('input[name="'+g+'"]:checked');
        if (!checked) missing.push(g);
        else {
          const val = parseFloat(checked.value);
          if (g.startsWith('lecturer_q_')) { lecSum += val; lecCnt++; }
          if (g.startsWith('course_q_')) { couSum += val; couCnt++; }
        }
      });

      const lecAvg = lecCnt ? (lecSum/lecCnt) : 0;
      const couAvg = couCnt ? (couSum/couCnt) : 0;
      document.getElementById('Avg_lecturer').value = lecAvg.toFixed(2);
      document.getElementById('Avg_course').value = couAvg.toFixed(2);

      return {valid: missing.length === 0, missing};
    }

    document.addEventListener('change', function(e){
      if (e.target && e.target.matches('input[type="radio"]')) calculateAndValidate();
    });

    document.querySelectorAll('form').forEach(f=>{
      f.addEventListener('submit', function(ev){
        const res = calculateAndValidate();
        if (!res.valid) {
          alert('الرجاء الإجابة على جميع الأسئلة في كلا القسمين');
          ev.preventDefault();
          return false;
        }
      });
    });

    calculateAndValidate();
  </script>
</body>
</html>

<?php mysqli_close($conn); ?>