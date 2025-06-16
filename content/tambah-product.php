<?php
if (isset($_GET['delete'])) {
    $id_user = isset($_GET['delete']) ? $_GET['delete'] : '';
    $querydelete = mysqli_query($config, "DELETE fROM products WHERE id = '$id'");
    if ($querydelete) {
        header("location:?page=product&hapus=berhasil");
    } else {
        header("location:?page=product&hapus=gagal");
    }
}
$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryedit = mysqli_query($config, "SELECT * FROM products WHERE id='$id'");
$rowedit = mysqli_fetch_assoc($queryedit);

if (isset($_POST['name'])) {
    //ada tidak sebuah parameter bernama edit, kalo ada jalankan perintah edit/updat, kalo tidak ada ada
    //tambah data baru / insert
    $name = $_POST['name'];
    $id_category = $_POST['id_category'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    $description = $_POST['description'];


    if (!isset($_GET['edit'])) {
        $insert = mysqli_query($config, "INSERT INTO products (id_category, name, price, qty, description) VALUES ('$id_category', '$name','$price', '$qty', '$description')");
        header("location:?page=product&tambah=berhasil");
    } else {
        $update = mysqli_query($config, "UPDATE products SET id_category='$id_category', name='$name',  price='$price', qty='$qty', description='$description'");
        header("location:?page=product&ubah=berhasil");
    }
}

$querycategoryproduct = mysqli_query($config, "SELECT * FROM categories ORDER BY id DESC");
$rowcategoryproduct = mysqli_fetch_all($querycategoryproduct, MYSQLI_ASSOC);




?>


<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> Product</h5>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="">Category </label>
                        <select name="id_category" id="" class="form-control">
                            <option value="">Select One</option>
                            <?php foreach ($rowcategoryproduct as $rowcategory): ?>
                                <option value="<?php echo $rowcategory['id'] ?>" <?php echo isset($rowedit) ? ($rowcategory['id'] == $rowedit['id_category']) ? "selected" : '' : '' ?>>
                                    <?php echo $rowcategory['name'] ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="">Product name *</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter your name" value="<?= isset($rowedit['name']) ? $rowedit['name'] : "" ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="">Price *</label>
                        <input  type="number" class="form-control" name="price" placeholder="Enter price product" value="<?= isset($rowedit['price']) ? $rowedit['price'] : "" ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="">qty *</label>
                        <input type="number" class="form-control" name="qty" placeholder="Enter qty product" value="<?= isset($rowedit['qty']) ? $rowedit['qty'] : "" ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="">Description *</label>
                        <textarea class="form-control" name="description" id="Address" placeholder="Enter description product" required><?= isset($rowedit['description']) ? $rowedit['description'] : "" ?></textarea>
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-success" name="save" value="save">
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>