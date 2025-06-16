<?php
if (isset($_GET['delete'])) {
    $id_user = isset($_GET['delete']) ? $_GET['delete'] : '';
    $querydelete = mysqli_query($config, "UPDATE roles SET deleted_at = 1 WHERE id = '$id_user'");
    if ($querydelete) {
        header("location:?page=role&hapus=berhasil");
    } else {
        header("location:?page=role&hapus=gagal");
    }
}
$id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryedit = mysqli_query($config, "SELECT * FROM roles WHERE id='$id_user'");
$rowedit = mysqli_fetch_assoc($queryedit);

if (isset($_POST['name'])) {
    //ada tidak sebuah parameter bernama edit, kalo ada jalankan perintah edit/updat, kalo tidak ada ada
    //tambah data baru / insert
    $name = $_POST['name'];
    $id_user = isset($_GET['edit']) ? $_GET['edit'] : '';

    if (!isset($_GET['edit'])) {
        $insert = mysqli_query($config, "INSERT INTO roles (name) VALUES ('$name')");
        header("location:?page=role&tambah=berhasil");
    } else {
        $update = mysqli_query($config, "UPDATE roles SET name='$name'  WHERE id='$id_user'");
        header("location:?page=role&ubah=berhasil");
    }
}

if (isset($_GET['add-role-menu'])) {
    $id_role = $_GET['add-role-menu'];

    $roweditrolemenu = [];
    $editrolemenu = mysqli_query($config, "SELECT * FROM menu_roles WHERE id_roles='$id_role'");
    // $roweditrolemenu = mysqli_fetch_all($editrolemenu, MYSQLI_ASSOC);

    while ($editmenu = mysqli_fetch_assoc($editrolemenu)) {
        $roweditrolemenu[] = $editmenu['id_menus'];
    }



    $menus = mysqli_query($config, "SELECT * FROM menus ORDER BY parent_id, urutan");
    $rowmenu = [];
    while ($m = mysqli_fetch_assoc($menus)) {
        $rowmenu[] = $m;
    }
}

if (isset($_POST['save'])) {
    $id_role = $_GET['add-role-menu'];
    $id_menus = $_POST['id_menus'] ?? [];

    mysqli_query($config, "DELETE FROM menu_roles WHERE id_roles='$id_role'");
    foreach ($id_menus as $m) {
        $id_menu = $m;
        mysqli_query($config, "INSERT INTO menu_roles(id_roles, id_menus) VALUE('$id_role', '$id_menu')");
        header("location:?page=tambah-role&add-role-menu=" . $id_role . "&tambah=berhasil");
    }
}



?>


<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo isset($_GET['id']) ? 'Edit' : 'Add' ?> Role</h5>
                <?php if (isset($_GET['add-role-menu'])): ?>
                    <form action="" method="post">

                        <div class="mb-3">
                            <ul>
                                <?php foreach ($rowmenu as $mainmenu): ?>
                                    <?php if ($mainmenu['parent_id'] == 0 or $mainmenu['parent_id'] == ""): ?>
                                        <li>
                                            <label for="">
                                                <input <?php echo in_array($mainmenu['id'], $roweditrolemenu) ? 'checked' : '' ?> type="checkbox" name="id_menus[]" value="<?php echo $mainmenu['id'] ?>">
                                                <?php echo $mainmenu['name'] ?>
                                            </label>
                                            <ul>
                                                <?php foreach ($rowmenu as $submenu): ?>
                                                    <?php if ($submenu['parent_id'] == $mainmenu['id']): ?>
                                                        <li>
                                                            <label for="">
                                                                <input <?php echo in_array($submenu['id'], $roweditrolemenu) ? 'checked' : ''  ?> type="checkbox" name="id_menus[]" value="<?php echo $submenu['id'] ?>">
                                                                <?php echo $submenu['name'] ?>
                                                            </label>
                                                        </li>
                                                    <?php endif ?>
                                                <?php endforeach ?>
                                            </ul>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary" name="save">Save Change</button>
                        </div>
                    </form>

                <?php else:   ?>
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="">Role *</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter your name" value="<?= isset($_GET['edit']) ? $rowedit['name'] : "" ?>" required>
                        </div>
                        <div class="mb-3">
                            <input type="submit" class="btn btn-success" name="simpan" value="save">
                        </div>
                    </form>
                
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>