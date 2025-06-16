<?php
if (isset($_GET['delete'])) {
    $id_user = isset($_GET['delete']) ? $_GET['delete'] : '';
    $querydelete = mysqli_query($config, "UPDATE users SET deleted_at = 1 WHERE id = '$id_user'");
    if ($querydelete) {
        header("location:?page=user&hapus=berhasil");
    } else {
        header("location:?page=user&hapus=gagal");
    }
}
$id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryedit = mysqli_query($config, "SELECT * FROM users WHERE id='$id_user'");
$rowedit = mysqli_fetch_assoc($queryedit);

if (isset($_POST['name'])) {
    //ada tidak sebuah parameter bernama edit, kalo ada jalankan perintah edit/updat, kalo tidak ada ada
    //tambah data baru / insert
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = isset($_POST['password']) ? sha1($_POST['password']) : $rowedit['password'];




    if (!isset($_GET['edit'])) {
        $insert = mysqli_query($config, "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");
        header("location:?page=user&tambah=berhasil");
    } else {
        $update = mysqli_query($config, "UPDATE users SET name='$name', email='$email', password='$password' WHERE id='$id_user'");
        header("location:?page=user&ubah=berhasil");
    }
}
$id_user = isset($_GET['add-user-role']) ? $_GET['add-user-role'] : '';
$queryroles = mysqli_query($config, "SELECT * FROM roles  ORDER BY id DESC");
$rowroles = mysqli_fetch_all($queryroles, MYSQLI_ASSOC);

$queryuserroles = mysqli_query($config, "SELECT user_roles.*, roles.name FROM user_roles 
LEFT JOIN roles ON user_roles.id_role = roles.id
where id_user = '$id_user'
ORDER BY user_roles.id_user DESC");
$rowuserroles = mysqli_fetch_all($queryuserroles, MYSQLI_ASSOC);

 

if (isset($_POST['id_role'])) {
    $id_role = $_POST['id_role'];
    $insert = mysqli_query($config, "INSERT INTO user_roles (id_role, id_user) VALUES ('$id_role', '$id_user')");
        header("location:?page=user&add-user-role=" . $id_role . "&add-role=berhasil");
}



?>


<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <?php if(isset($_GET['add-user-role'])):
                    $title = "Add User Role : " ;
                elseif (isset($_GET['edit'])):
                    $title = 'Edit User Role :';
                else:
                    $title = 'Add User :';
                endif; ?>
                <h5 class="card-title"><?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> User</h5>
                <?php if (isset($_GET['add-user-role'])): ?>
                    <div align="right" >
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Add  Role</button>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Role Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rowuserroles as $key => $rowuserrole): ?>
                            <tr>
                                <td><?php echo $key + 1?></td>
                                <td><?php echo $rowuserrole['name'] ?></td>
                                <td>
                                    <a href="" class="btn btn-primary btn-sm">Edit</a>
                                    <a onclick="return confirm('Are You Sure Wanna Delete this Data??')" href="?page=tambah-user&delete=<?php echo $rowuserrole['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <!-- <div class="mb-3">
                        <label for="">Role Name *</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter your name" value="<?= isset($rowedit['name']) ? $rowedit['name'] : "" ?>" required>
                    </div> -->
                <?php else: ?>
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="">Fullname *</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter your name" value="<?= isset($rowedit['name']) ? $rowedit['name'] : "" ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="">Email *</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter your email" value="<?= isset($rowedit['email']) ? $rowedit['email'] : "" ?> " required>
                        </div>
                        <div class="mb-3">
                            <label for="">Password *</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter your password" <?php echo empty($id_user) ? 'required' : '' ?>>
                            <small>
                                )* if you want to change your password, you can fill this field
                            </small>
                        </div>
                        <div class="mb-3">
                            <input type="submit" class="btn btn-success" name="save" value="save">
                        </div>
                    </form>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Role</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="">Role Name</label>
                        <select name="id_role" id="" class="form-control">
                            <option value="">Select One</option>
                            <?php foreach ($rowroles as $rowrole): ?>
                                <option value="<?php echo $rowrole['id'] ?>"><?php echo $rowrole['name'] ?></option>

                            <?php endforeach ?>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>