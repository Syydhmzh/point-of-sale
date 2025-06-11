<?php
if (isset($_GET['delete'])) {
    $id_user = isset($_GET['delete']) ? $_GET['delete'] : '';
    $querydelete = mysqli_query($config, "UPDATE instructors SET deleted_at = 1 WHERE id = '$id_user'");
    if ($querydelete) {
        header("location:?page=instructor&hapus=berhasil");
    } else {
        header("location:?page=instructor&hapus=gagal");
    }
}
$id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryedit = mysqli_query($config, "SELECT * FROM instructors WHERE id='$id_user'");
$rowedit = mysqli_fetch_assoc($queryedit);

if (isset($_POST['name'])) {
    //ada tidak sebuah parameter bernama edit, kalo ada jalankan perintah edit/updat, kalo tidak ada ada
    //tambah data baru / insert
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    // $gender = $_POST['gender'];
    $education = $_POST['education'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = isset($_POST['password']) ? sha1($_POST['password']) : $rowedit['password'];
    $address = $_POST['address'];
    $id_role = 3;
    $id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
    

    if (!isset($_GET['edit'])) {
        $insert = mysqli_query($config, "INSERT INTO instructors (id_role, name, gender, education, phone, email, password, address ) VALUES ('$id_role', '$name','$gender', '$education', '$phone', '$email', '$password', '$address')");
        header("location:?page=instructor&tambah=berhasil");
    } else {
        $update = mysqli_query($config, "UPDATE instructors SET id_role='$id_role', name='$name',  gender='$gender', education='$education', phone='$phone', email='$email', password='$password' WHERE id='$id_user'");
        header("location:?page=instructor&ubah=berhasil");
    }
}




?>


<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> Instructors</h5>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="">Fullname *</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter your name" value="<?= isset($_GET['edit']) ? $rowedit['name'] : "" ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="">gender *</label>
                        <div class="col-sm-10">
                            <input type="radio" name="gender" value="1" <?= isset($_GET['edit']) && $rowedit['gender'] == '1' ? 'checked' : ''  ?>>Laki-laki
                            <input type="radio" name="gender" value="0" <?= isset($_GET['edit']) && $rowedit['gender'] == '0' ? 'checked' : ''  ?>>Perempuan
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="">education *</label>
                        <input type="text" class="form-control" name="education" placeholder="last your Education" value="<?= isset($_GET['edit']) ? $rowedit['education'] : "" ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="">phone *</label>
                        <input type="number" class="form-control" name="phone" placeholder="Enter your number" value="<?= isset($_GET['edit']) ? $rowedit['phone'] : "" ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="">Email *</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter your email" value="<?= isset($_GET['edit']) ? $rowedit['email'] : "" ?> " required>
                    </div>
                    <div class="mb-3">
                        <label for="">Password *</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter your password" <?php echo empty($_GET['edit']) ? 'required' : '' ?>>
                        <small>
                            )* if you want to change your password, you can fill this field
                        </small>
                    </div>
                    <div class="mb-3">
                        <label for="">Address *</label>
                        <textarea class="form-control" name="address" id="Address" placeholder="Enter your Address" required><?= isset($_GET['edit']) ? $rowedit['address'] : "" ?></textarea>
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-success" name="save" value="save">
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>