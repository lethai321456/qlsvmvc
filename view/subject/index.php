<?php require 'layout/header.php' ?>
<h1>Danh sách môn học</h1>
<a href="?c=subject&a=create" class="btn btn-info">Add</a>
<form action="/?c=subject" method="GET">
    <label class="form-inline justify-content-end">Tìm kiếm: <input type="search" name="search" class="form-control"
            value="<?= $search ?>">
        <button class="btn btn-danger">Tìm</button>
    </label>
    <input type="hidden" name="c" value="subject">
</form>
<table class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Mã MH</th>
            <th>Tên</th>
            <th>Số tín chỉ</th>
            <th colspan="2">Tùy Chọn</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $stt = 0;
        foreach ($subjects as $subject):
            $stt++;
        ?>
            <tr>
                <td><?= $stt ?></td>
                <td><?= $subject->id ?></td>
                <td><?= $subject->name ?></td>
                <td><?= $subject->number_of_credit ?></td>
                <td><a href="?c=subject&a=edit&id=<?= $subject->id ?>" class="btn btn-warning btn-sm">Sửa</a></td>
                <td>
                    <button data-href="?c=subject&a=destroy&id=<?= $subject->id ?>" type=" button"
                        class="btn btn-danger btn-sm delete" data-toggle="modal" data-target="#exampleModal">
                        Xóa
                    </button>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
<div>
    <span>Số lượng: <?= count($subjects) ?></span>
</div>
<?php require 'layout/footer.php' ?>