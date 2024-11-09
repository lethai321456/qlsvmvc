<?php
// Class STudentController có các hàm bên trong
class StudentController
{
    function index()
    {
        $search = $_GET['search'] ?? '';
        $studentRepository = new StudentRepository();
        if ($search) {
            $students = $studentRepository->getByPattern($search);
        } else {
            $students = $studentRepository->getAll();
        }

        require 'view/student/index.php';
    }

    function create()
    {
        require 'view/student/create.php';
    }

    function store()
    {
        $data = $_POST;
        $name = $data['name'];
        $studentRepository = new StudentRepository();
        if ($studentRepository->save($data)) {
            // lưu thành công
            $_SESSION['success'] = "Đã thêm sinh viên $name thành công";
            // trờ về trang chủ
            header('location: /');
            exit;
        }
        // lưu thất bại
        $_SESSION['error'] = $studentRepository->error;
        // trờ về trang chủ
        header('location: /');
        exit;
    }

    function edit()
    {
        // xuống database lấy sinh viên tương ứng để đỗ ra view
        $id = $_GET['id'];
        $studentRepository = new StudentRepository();
        $student = $studentRepository->find($id);

        require 'view/student/edit.php';
    }

    function update()
    {
        // Láy data từ trình duyệt web gởi lên
        $id = $_POST['id'];
        $name = $_POST['name'];
        $birthday = $_POST['birthday'];
        $gender = $_POST['gender'];

        // Lấy đối tượng sinh viên có id tương ứng từ database
        $studentRepository = new StudentRepository();
        $student = $studentRepository->find($id);

        // Cập nhật name, birthday, gender cho đối tượng đó
        $student->name = $name;
        $student->birthday = $birthday;
        $student->gender = $gender;

        // Cập nhật đối tượng student này xuống database
        if ($studentRepository->update($student)) {
            // lưu thành công
            $_SESSION['success'] = "Đã thêm sinh viên $name thành công";
            // trờ về trang chủ
            header('location: /');
            exit;
        }
        // lưu thất bại
        $_SESSION['error'] = $studentRepository->error;
        // trờ về trang chủ
        header('location: /');
        exit;
    }

    function destroy()
    {
        $id = $_GET['id'];
        $studentRepository = new StudentRepository();
        $student = $studentRepository->find($id);
        $name = $student->name;

        // Kiểm tra sinh viên có đăng ký môn học không?. Nếu có không cho xóa
        $registerRepository = new RegisterRepository();
        $registers = $registerRepository->getByStudentId($id);
        $num = count($registers);
        if ($num > 0) {
            $_SESSION['error'] = "Sinh viên $name đã đăng ký $num môn học. Không thể xóa";
            // trở về trang chủ
            header('location: /');
            exit;
        }

        // Xóa sinh viên ở database
        if ($studentRepository->destroy($id)) {
            // lưu thành công
            $_SESSION['success'] = "Đã thêm sinh viên $name thành công";
            // trờ về trang chủ
            header('location: /');
            exit;
        }
        // lưu thất bại
        $_SESSION['error'] = $studentRepository->error;
        // trờ về trang chủ
        header('location: /');
        exit;
    }
}
