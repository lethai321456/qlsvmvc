<?php
// Class STudentController có các hàm bên trong
class RegisterController
{
    function index()
    {
        $search = $_GET['search'] ?? '';
        $registerRepository = new RegisterRepository();
        if ($search) {
            $registers = $registerRepository->getByPattern($search);
        } else {
            $registers = $registerRepository->getAll();
        }

        require 'view/register/index.php';
    }

    function create()
    {
        // Lấy dữ liệu từ model đổ ra view
        $studentRepository = new StudentRepository();
        $students = $studentRepository->getAll();

        $subjectRepository = new SubjectRepository();
        $subjects = $subjectRepository->getAll();

        require 'view/register/create.php';
    }

    function store()
    {
        $data = $_POST;

        $student_id = $data['student_id'];
        $studentRepository = new StudentRepository();
        $student = $studentRepository->find($student_id);
        $student_name = $student->name;

        $subject_id = $data['subject_id'];
        $subjectRepository = new SubjectRepository();
        $subject = $subjectRepository->find($subject_id);
        $subject_name = $subject->name;

        $registerRepository = new RegisterRepository();
        if ($registerRepository->save($data)) {
            // lưu thành công
            $_SESSION['success'] = "Sinh viên $student_name đăng kí môn $subject_name thành công";
            // trờ về trang chủ
            header('location: /?c=register');
            exit;
        }
        // lưu thất bại
        $_SESSION['error'] = $registerRepository->error;
        // trờ về trang chủ
        header('location: /?c=register');
        exit;
    }

    function edit()
    {
        // xuống database lấy đăng kí môn học tương ứng để đỗ ra view
        $id = $_GET['id'];
        $registerRepository = new RegisterRepository();
        $register = $registerRepository->find($id);

        require 'view/register/edit.php';
    }

    function update()
    {

        // Láy data từ trình duyệt web gởi lên
        $id = $_POST['id'];
        $score = $_POST['score'];

        // Lấy đối tượng đăng kí môn học có id tương ứng từ database
        $registerRepository = new RegisterRepository();
        $register = $registerRepository->find($id);

        // Cập nhật student_id, subject_id cho đối tượng đó
        $register->score = $score;

        $student_name = $register->student_name;
        $subject_name = $register->subject_name;

        // Cập nhật đối tượng register này xuống database
        if ($registerRepository->update($register)) {
            // lưu thành công
            $_SESSION['success'] = "Sinh viên $student_name thi môn $subject_name được $score điểm";
            // trờ về trang chủ
            header('location: /?c=register');
            exit;
        }
        // lưu thất bại
        $_SESSION['error'] = $registerRepository->error;
        // trờ về trang chủ
        header('location: /?c=register');
        exit;
    }

    function destroy()
    {
        $id = $_GET['id'];
        $registerRepository = new RegisterRepository();
        $register = $registerRepository->find($id);
        $student_name = $register->student_name;
        $subject_name = $register->subject_name;
        // Xóa đăng kí môn học ở database
        if ($registerRepository->destroy($id)) {
            // lưu thành công
            $_SESSION['success'] = "Sinh viên $student_name hủy môn $subject_name thành công";
            // trờ về trang chủ
            header('location: /?c=register');
            exit;
        }
        // lưu thất bại
        $_SESSION['error'] = $registerRepository->error;
        // trờ về trang chủ
        header('location: /?c=register');
        exit;
    }
}
