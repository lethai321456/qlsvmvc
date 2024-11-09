<?php
session_start();

// require cấu hình và database
require 'config.php';
require 'connectDb.php';

// Đóng vai trò router
$c = $_GET['c'] ?? 'student';
$a = $_GET['a'] ?? 'index';

$class_controller = ucfirst($c) . 'Controller'; //SubjectController

// Chỉ định file controller tương ứng nằm ở đâu
require "controller/$class_controller.php";

// Tạo đối tượng từ class tương ứng để gọi hàm.
$controller = new $class_controller();

// require model vào
require 'model/StudentRepository.php';
require 'model/Student.php';

require 'model/SubjectRepository.php';
require 'model/Subject.php';

require 'model/RegisterRepository.php';
require 'model/Register.php';

// Gọi hàm chạy
$controller->$a();//$controller->create()