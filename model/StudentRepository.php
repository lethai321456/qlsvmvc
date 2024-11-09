<?php
class StudentRepository
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
        $sql = 'SELECT * FROM student';
        if ($cond) {
            $sql .= " WHERE $cond";
        }
        $result = $conn->query($sql);
        $student = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $name = $row['name'];
                $birthday = $row['birthday'];
                $gender = $row['gender'];
                $student = new Student($id, $name, $birthday, $gender);

                // thêm student vào cuối danh sách
                $students[] = $student;
            }
        }
        return $students;
    }
    // lưu
    // lưu thành công thì trả về true để chỗ gọi hàm biét
    // ngược lại trả về false. Trả về false phải kèm theo thông báo lỗi (lý do là gì?)
    function save($data)
    {
        global $conn;
        $name = $data['name'];
        $birthday = $data['birthday'];
        $gender = $data['gender'];
        $sql = "INSERT INTO student (name, birthday, gender) VALUES ('$name', '$birthday', '$gender')";

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
        $cond = "id=$id"; // condition (điều kiện dành cho where)
        $students = $this->fetch($cond);
        if (count($students) > 0) {
            $student = $students[0];
            return $student;
        }
        // nghĩa là không có sinh viên nào có mã id trên
        return null;
    }

    // Trả về danh sách sinh viên có name chứa từ khóa
    function getByPattern($search)
    {
        $cond = "name LIKE '%$search%'"; // condition (điều kiện dành cho where)
        $students = $this->fetch($cond);
        return $students;
    }
    // Trả về danh sách sinh viên toàn bộ sinh viên, không điều kiện
    function getAll()
    {
        $students = $this->fetch();
        return $students;
    }


    function update($student)
    {
        global $conn;
        $name = $student->name;
        $birthday = $student->birthday;
        $gender = $student->gender;
        $id = $student->id;
        $sql = "UPDATE student SET name='$name', birthday='$birthday', gender='$gender' WHERE id=$id";

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
        $sql = "DELETE FROM student WHERE id=$id";

        if ($conn->query($sql)) {
            //lưu thành công
            return true;
        }
        // lưu thất bại
        $this->error = $sql . '<br>' . $conn->error;
        return false;
    }
}
