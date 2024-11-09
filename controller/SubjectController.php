<?php
// Class STudentController có các hàm bên trong
class SubjectController
{
    function index()
    {
        $search = $_GET['search'] ?? '';
        $subjectRepository = new SubjectRepository();
        if ($search) {
            $subjects = $subjectRepository->getByPattern($search);
        } else {
            $subjects = $subjectRepository->getAll();
        }

        require 'view/subject/index.php';
    }

    function create()
    {
        require 'view/subject/create.php';
    }

    function store()
    {
        $data = $_POST;
        $name = $data['name'];
        $subjectRepository = new SubjectRepository();
        if ($subjectRepository->save($data)) {
            // lưu thành công
            $_SESSION['success'] = "Đã thêm môn học $name thành công";
            // trờ về trang chủ
            header('location: /?c=subject');
            exit;
        }
        // lưu thất bại
        $_SESSION['error'] = $subjectRepository->error;
        // trờ về trang chủ
        header('location: /?c=subject');
        exit;
    }

    function edit()
    {
        // xuống database lấy môn học tương ứng để đỗ ra view
        $id = $_GET['id'];
        $subjectRepository = new SubjectRepository();
        $subject = $subjectRepository->find($id);

        require 'view/subject/edit.php';
    }

    function update()
    {
        // Láy data từ trình duyệt web gởi lên
        $id = $_POST['id'];
        $name = $_POST['name'];
        $number_of_credit = $_POST['number_of_credit'];

        // Lấy đối tượng môn học có id tương ứng từ database
        $subjectRepository = new SubjectRepository();
        $subject = $subjectRepository->find($id);

        // Cập nhật name, number_of_credit cho đối tượng đó
        $subject->name = $name;
        $subject->number_of_credit = $number_of_credit;

        // Cập nhật đối tượng subject này xuống database
        if ($subjectRepository->update($subject)) {
            // lưu thành công
            $_SESSION['success'] = "Đã thêm môn học $name thành công";
            // trờ về trang chủ
            header('location: /?c=subject');
            exit;
        }
        // lưu thất bại
        $_SESSION['error'] = $subjectRepository->error;
        // trờ về trang chủ
        header('location: /?c=subject');
        exit;
    }

    function destroy()
    {
        $id = $_GET['id'];
        $subjectRepository = new SubjectRepository();
        $subject = $subjectRepository->find($id);
        $name = $subject->name;

        // Kiểm tra môn học đã được sinh viên đăng ký chưa?. Nếu có không cho xóa
        $registerRepository = new RegisterRepository();
        $registers = $registerRepository->getBySubjectId($id);
        $num = count($registers);
        if ($num > 0) {
            $_SESSION['error'] = "Môn học $name đã được $num sinh viên đăng ký. Không thể xóa";
            // trở về trang chủ
            header('location: /');
            exit;
        }

        // Xóa môn học ở database
        if ($subjectRepository->destroy($id)) {
            // lưu thành công
            $_SESSION['success'] = "Đã thêm môn học $name thành công";
            // trờ về trang chủ
            header('location: /?c=subject');
            exit;
        }
        // lưu thất bại
        $_SESSION['error'] = $subjectRepository->error;
        // trờ về trang chủ
        header('location: /?c=subject');
        exit;
    }
}
