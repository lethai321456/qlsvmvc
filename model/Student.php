<?php
class Student
{
    // Khai báo thuộc tính
    public $id;
    public $name;
    public $birthday;
    public $gender;

    // Hàm khởi tạo đối tượng
    function __construct($id, $name, $birthday, $gender)
    {
        $this->id = $id;
        $this->name = $name;
        $this->birthday = $birthday;
        $this->gender = $gender;
    }
}
