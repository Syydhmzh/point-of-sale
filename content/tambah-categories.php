<?php
if (isset($_GET['delete'])) {
    $id_user = isset($_GET['delete']) ? $_GET['delete'] : '';
    $querydelete = mysqli_query($config, "UPDATE categories SET deleted_at = 1 WHERE id = '$id_user'");
    if ($querydelete) {
        header("location:?page=categories&hapus=berhasil");
    } else {
        header("location:?page=categories&hapus=gagal");
    }
}
$id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryedit = mysqli_query($config, "SELECT * FROM categories WHERE id='$id_user'");
$rowedit = mysqli_fetch_assoc($queryedit);

if (isset($_POST['name'])) {
    //ada tidak sebuah parameter bernama edit, kalo ada jalankan perintah edit/updat, kalo tidak ada ada
    //tambah data baru / insert
    $name = $_POST['name'];
    $id_user = isset($_GET['edit']) ? $_GET['edit'] : '';

    if (!isset($_GET['edit'])) {
        $insert = mysqli_query($config, "INSERT INTO categories (name) VALUES ('$name')");
        header("location:?page=categories&tambah=berhasil");
    } else {
        $update = mysqli_query($config, "UPDATE categories SET name='$name'  WHERE id='$id_user'");
        header("location:?page=categories&ubah=berhasil");
    }
}




?>


<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> categories</h5>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="">Categories *</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter categories  name" value="<?= isset($_GET['edit']) ? $rowedit['name'] : "" ?>" required>
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-success" name="save" value="save">
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>