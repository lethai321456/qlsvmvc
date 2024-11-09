<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Quản lý sinh viên</title>
    <link rel="stylesheet" href="public/vendor/bootstrap-4.5.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/vendor/fontawesome-free-5.15.1-web/css/all.min.css">
    <link rel="stylesheet" href="public/css/style.css">
    <!-- link:favicon -->
    <link rel="shortcut icon" href="../public/favicon.ico" type="image/x-icon">
</head>

<body>
    <?php
    global $c;
    ?>
    <div class="container" style="margin-top:20px;">
        <a href="/" class="<?= $c == 'student' ? 'active' : '' ?> btn btn-info">Students</a>
        <a href="/?c=subject" class="<?= $c == 'subject' ? 'active' : '' ?> btn btn-info">Subject</a>
        <a href="/?c=register" class="<?= $c == 'register' ? 'active' : '' ?> btn btn-info">Register</a>
        <?php
        $message = '';
        $classType = '';
        if (isset($_SESSION['success'])) {
            $message = $_SESSION['success'];
            // xóa phần tử có key là success trong $_SESSION
            unset($_SESSION['success']);
            $classType = 'success';
        } else  if (isset($_SESSION['error'])) {
            $message = $_SESSION['error'];
            // xóa phần tử có key là error trong $_SESSION
            unset($_SESSION['error']);
            $classType = 'danger';
        }
        if ($message) :
        ?>
            <div class="alert alert-<?= $classType ?> mt-3"><?= $message ?></div>
        <?php endif ?>