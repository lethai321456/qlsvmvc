<?php require 'layout/header.php' ?>
<h1>Danh sách sinh viên</h1>
<a href="?a=create" class="btn btn-info">Add</a>
<form action="/" method="GET">
    <label class="form-inline justify-content-end">Tìm kiếm: <input type="search" name="search" class="form-control"
            value="<?= $search ?>">
        <button class="btn btn-danger">Tìm</button>
    </label>
</form>
<table class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Mã SV</th>
            <th>Tên</th>
            <th>Ngày Sinh</th>
            <th>Giới Tính</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $stt = 0;
        foreach ($students as $student):
            $stt++;
        ?>
            <tr>
                <td><?= $stt ?></td>
                <td><?= $student->id ?></td>
                <td><?= $student->name ?></td>
                <td><?= $student->birthday ?></td>
                <td><?= $student->gender ?></td>
                <td><a href="?a=edit&id=<?= $student->id ?>" class="btn btn-warning btn-sm">Sửa</a></td>
                <td>
                    <button data-href="?a=destroy&id=<?= $student->id ?>" type=" button"
                        class="btn btn-danger btn-sm delete" data-toggle="modal" data-target="#exampleModal">
                        Xóa
                    </button>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
<div>
    <span>Số lượng: <?= count($students) ?></span>
</div>
<?php require 'layout/footer.php' ?>