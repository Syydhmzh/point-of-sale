<?php
if (isset($_GET['delete'])) {
    $id =  $_GET['delete'];
    $querydelete = mysqli_query($config, "DELETE FROM menus WHERE id = '$id'");
    if ($querydelete) {
        header("location:?page=menu&hapus=berhasil");
    } else {
        header("location:?page=menu&hapus=gagal");
    }
}
// $id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
// $queryedit = mysqli_query($config, "SELECT * FROM menus WHERE id='$id_user'");
// $rowedit = mysqli_fetch_assoc($queryedit);

if (isset($_POST['name'])) {
    //ada tidak sebuah parameter bernama edit, kalo ada jalankan perintah edit/updat, kalo tidak ada ada
    //tambah data baru / insert
    $name = $_POST['name'];
    $parent_id = $_POST['parent_id'];
    $icon = $_POST['icon'];
    $url = $_POST['url'];
    $urutan = $_POST['urutan'];
   

    if (!isset($_GET['edit'])) {
        $insert = mysqli_query($config, "INSERT INTO menus (name, parent_id, icon, url, urutan) VALUES ('$name', '$parent_id', '$icon', '$url', '$urutan')");
        header("location:?page=menu&tambah=berhasil");
    } else {
        $update = mysqli_query($config, "UPDATE menu SET name='$name', parent_id='$parent_id', icon='$icon', url='$url', urutan='$urutan'  WHERE id='$id'");
        header("location:?page=menu&ubah=berhasil");
    }
}

$queryparentid = mysqli_query($config, "SELECT * FROM menus WHERE parent_id = 0 OR parent_id=''");
$rowparentid = mysqli_fetch_all($queryparentid, MYSQLI_ASSOC);




?>


<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> Role</h5>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="">Name *</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter your menu" value="<?= isset($_GET['name']) ? $rowedit['name'] : "" ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="">Parent Id</label>
                        <select name="parent_id" id="" class="form-control">
                            <option value="">Select One</option>
                            <?php foreach($rowparentid as $parentid): ?>
                                <option value="<?php echo $parentid['id'] ?>">
                                    <?php echo $parentid['name']?>
                                </option> 
                                <?php endforeach ?>
                        </select>
                        <!-- <input type="text" class="form-control" name="name" placeholder="Enter your menu" value="<?= isset($_GET['parent_id']) ? $rowedit['parent_id'] : "" ?>"> -->
                    </div>
                     <div class="mb-3">
                        <label for="">Icon *</label>
                        <input type="text" class="form-control" name="icon" placeholder="Enter icon menu" value="<?= isset($_GET['icon']) ? $rowedit['icon'] : "" ?>" required>
                    </div>
                     <div class="mb-3">
                        <label for="">Url</label>
                        <input type="text" class="form-control" name="url" placeholder="Enter url menu" value="<?= isset($_GET['url']) ? $rowedit['url'] : "" ?>">
                    </div>
                     <div class="mb-3">
                        <label for="">Order</label>
                        <input type="number" class="form-control" name="urutan" placeholder="Enter order menu" value="<?= isset($_GET['urutan']) ? $rowedit['urutan'] : "" ?>">
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-success" name="save" value="save">
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>