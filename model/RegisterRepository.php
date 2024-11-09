<?php
class RegisterRepository
{
    public $error; // thuộc tính này dùng để lưu lại lỗi (nếu có)
    // Lấy các dòng dữ liệu trong database và chuyển nó thành danh sách sinh viên
    // Luật chung của hàm là:
    // - Bên trong hàm không được truy xuất biến bên ngoài hàm
    // - Bên ngoài hàm cũng không được truy xuất bến bên trong hàm 
    // Lưu ý: tùy theo ngôn ngữ lập trình khsac nhau sẽ có thay đổi ít nhiều.
    function fetch($cond = null)
    {
        // Để bên trong nhìn thấy biến bên ngoài hàm ta dùng từ khóa global
        global $conn;
        $sql = 'SELECT register.*, student.name
        AS student_name, subject.name 
        AS subject_name FROM register
        JOIN student ON student.id=register.student_id
        JOIN subject ON subject.id=register.subject_id';
        if ($cond) {
            $sql .= " WHERE $cond";
        }
        $result = $conn->query($sql);
        $register = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $student_id = $row['student_id'];
                $subject_id = $row['subject_id'];
                $score = $row['score'];

                $student_name = $row['student_name'];
                $subject_name = $row['subject_name'];

                $register = new Register($id, $student_id, $subject_id, $score, $student_name, $subject_name);

                // thêm register vào cuối danh sách
                $registers[] = $register;
            }
        }
        return $registers;
    }
    // lưu
    // lưu thành công thì trả về true để chỗ gọi hàm biét
    // ngược lại trả về false. Trả về false phải kèm theo thông báo lỗi (lý do là gì?)
    function save($data)
    {
        global $conn;
        $student_id = $data['student_id'];
        $subject_id = $data['subject_id'];
        $sql = "INSERT INTO register (student_id, subject_id) VALUES ('$student_id', '$subject_id')";

        if ($conn->query($sql)) {
            //lưu thành công
            return true;
        }
        // lưu thất bại
        $this->error = $sql . '<br>' . $conn->error;
        return false;
    }

    // Trả về đối tượng sinh viên có mã id tương ứng
    function find($id)
    {
        $cond = "register.id=$id"; // condition (điều kiện dành cho where)
        $registers = $this->fetch($cond);
        if (count($registers) > 0) {
            $register = $registers[0];
            return $register;
        }
        // nghĩa là không có sinh viên nào có mã id trên
        return null;
    }

    // Trả về danh sách sinh viên có student_id chứa từ khóa
    function getByPattern($search)
    {
        $cond = "student.name LIKE '%$search%' || subject.name LIKE '%$search%'"; // condition (điều kiện dành cho where)
        $registers = $this->fetch($cond);
        return $registers;
    }
    // Trả về danh sách sinh viên toàn bộ sinh viên, không điều kiện
    function getAll()
    {
        $registers = $this->fetch();
        return $registers;
    }


    function update($register)
    {
        global $conn;
        $id = $register->id;
        $score = $register->score;
        $sql = "UPDATE register SET score=$score WHERE id=$id";

        if ($conn->query($sql)) {
            //lưu thành công
            return true;
        }
        // lưu thất bại
        $this->error = $sql . '<br>' . $conn->error;
        return false;
    }

    function destroy($id)
    {
        global $conn;
        $sql = "DELETE FROM register WHERE id=$id";

        if ($conn->query($sql)) {
            //lưu thành công
            return true;
        }
        // lưu thất bại
        $this->error = $sql . '<br>' . $conn->error;
        return false;
    }
    // Tìm trong bảng register, xem thằng sinh viên cụ thể đó đăng ký mấy môn học.
    function getByStudentId($student_id)
    {
        $cond = "student_id=$student_id"; // condition (điều kiện dành cho where)
        // SELECT * FROM register ... WHERE student_id=2
        $registers = $this->fetch($cond);
        return $registers;
    }
    // Tìm trong bảng register, xem môn học đã được bao nhiêu sinh viên đăng ký.
    function getBySubjectId($subject_id)
    {
        $cond = "subject_id=$subject_id"; // condition (điều kiện dành cho where)
        // SELECT * FROM register ... WHERE student_id=2
        $registers = $this->fetch($cond);
        return $registers;
    }
}
