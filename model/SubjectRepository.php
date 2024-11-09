<?php
class SubjectRepository
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
        $sql = 'SELECT * FROM subject';
        if ($cond) {
            $sql .= " WHERE $cond";
        }
        $result = $conn->query($sql);
        $subject = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $name = $row['name'];
                $number_of_credit = $row['number_of_credit'];
                $subject = new Subject($id, $name, $number_of_credit);

                // thêm subject vào cuối danh sách
                $subjects[] = $subject;
            }
        }
        return $subjects;
    }
    // lưu
    // lưu thành công thì trả về true để chỗ gọi hàm biét
    // ngược lại trả về false. Trả về false phải kèm theo thông báo lỗi (lý do là gì?)
    function save($data)
    {
        global $conn;
        $name = $data['name'];
        $number_of_credit = $data['number_of_credit'];
        $sql = "INSERT INTO subject (name, number_of_credit) VALUES ('$name', '$number_of_credit')";

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
        $subjects = $this->fetch($cond);
        if (count($subjects) > 0) {
            $subject = $subjects[0];
            return $subject;
        }
        // nghĩa là không có sinh viên nào có mã id trên
        return null;
    }

    // Trả về danh sách sinh viên có name chứa từ khóa
    function getByPattern($search)
    {
        $cond = "name LIKE '%$search%'"; // condition (điều kiện dành cho where)
        $subjects = $this->fetch($cond);
        return $subjects;
    }
    // Trả về danh sách sinh viên toàn bộ sinh viên, không điều kiện
    function getAll()
    {
        $subjects = $this->fetch();
        return $subjects;
    }


    function update($subject)
    {
        global $conn;
        $name = $subject->name;
        $number_of_credit = $subject->number_of_credit;
        $id = $subject->id;
        $sql = "UPDATE subject SET name='$name', number_of_credit='$number_of_credit' WHERE id=$id";

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
        $sql = "DELETE FROM subject WHERE id=$id";

        if ($conn->query($sql)) {
            //lưu thành công
            return true;
        }
        // lưu thất bại
        $this->error = $sql . '<br>' . $conn->error;
        return false;
    }
}
