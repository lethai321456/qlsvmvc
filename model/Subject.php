<?php
class Subject
{
    // Khai báo thuộc tính
    public $id;
    public $name;
    public $number_of_credit;

    // Hàm khởi tạo đối tượng
    function __construct($id, $name, $number_of_credit)
    {
        $this->id = $id;
        $this->name = $name;
        $this->number_of_credit = $number_of_credit;
    }
}
