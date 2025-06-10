<?php
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $querymodulsdetails = mysqli_query($config, "SELECT file FROM moduls_detail WHERE id_modul='$id'");
    $rowmoduldetails = mysqli_fetch_assoc($querymodulsdetails);
    unlink("uploads/" . $rowmoduldetails['file']);

    $querydelete = mysqli_query($config, "DELETE FROM moduls_detail WHERE id_modul='$id'");
    $querydelete = mysqli_query($config, "DELETE FROM moduls WHERE id ='$id'");

    if ($querydelete) {
        header("location:?page=moduls&hapus=berhasil");
    } else {
        header("location:?page=moduls&hapus=gagal");
    }
}



$id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryedit = mysqli_query($config, "SELECT * FROM majors WHERE id='$id_user'");
$rowedit = mysqli_fetch_assoc($queryedit);

if (isset($_POST['save'])) {
    //ada tidak sebuah parameter bernama edit, kalo ada jalankan perintah edit/updat, kalo tidak ada ada
    //tambah data baru / insert
    $id_instructor = $_POST['id_instructor'];
    $name = $_POST['name'];
    $id_major = $_POST['id_major'];

    $insert = mysqli_query($config, "INSERT INTO moduls (id_instructor, name, id_major)
     VALUES ('$id_instructor', '$name', '$id_major')");

    if ($insert) {
        $id_modul = mysqli_insert_id($config);
        foreach ($_FILES['file']['name'] as $index => $file) {
            if ($_FILES['file']['error'][$index] == 0) {
                $name = basename($_FILES['file']['name'][$index]);
                $filename = uniqid() . "-" . $name;
                $path = "uploads/";
                $targetpath = $path . $filename;

                if (move_uploaded_file($_FILES['file']['tmp_name'][$index], $targetpath)) {
                    $insertmoduldetail = mysqli_query($config, "INSERT INTO moduls_detail (id_modul, file) VALUES ('$id_modul', '$file')");
                }
            }
        }
        header("location:?page=moduls&tambah=berhasil");
    }
}
$id_instructor = isset($_SESSION['ID_USER']) ? $_SESSION['ID_USER'] : '';
$queryinstructormajor = mysqli_query($config, "SELECT majors.name, instructor_majors.* 
FROM instructor_majors 
LEFT JOIN  majors ON majors.id = instructor_majors.id_major
WHERE instructor_majors.id_instructor = '$id_instructor'");
$rowinstructormajor = mysqli_fetch_all($queryinstructormajor, MYSQLI_ASSOC);


$id_modul = isset($_GET['detail']) ? $_GET['detail'] : '';
$querymodul = mysqli_query($config, "SELECT majors.name as major_name, instructors.name as instructor_name, moduls.*  
FROM moduls 
LEFT JOIN majors ON majors.id = moduls.id_major
LEFT JOIN instructors ON instructors.id = moduls.id_instructor WHERE moduls.id = '$id_modul'");
$rowmodul = mysqli_fetch_assoc($querymodul);
// print_r($rowmodul);
// die;

$querydetailmodul = mysqli_query($config, "SELECT * FROM moduls_detail WHERE id_modul = '$id_modul'");
$rowdetailmodul = mysqli_fetch_all($querydetailmodul, MYSQLI_ASSOC);


if (isset($_GET['download'])) {
    $file = $_GET['download'];
    $filepath = "uploads/" . $file;
    if (file_exists($filepath)) {
        header("Content-Description: File Transfer");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename" . basename($filepath) . "");
        header("Expires:0");
        header("Cache-Control:-must-revalidate");
        header("Pragma:public");
        header("Content-Length:" . filesize($filepath) . "");
        ob_clean(); // Clean the output buffer
        flush(); // Flush system output buffer
        readfile($filePath);
        exit;
    }
}
?>


<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo isset($_GET['detail']) ? 'Detail' : 'Add' ?> Modul</h5>

                <?php if (isset($_GET['detail'])): ?>
                    <!-- detail modul -->
                    <table class="table table-stripped">
                        <tr>
                            <th>Modul Name</th>
                            <th>:</th>
                            <td><?php echo $rowmodul['name'] ?></td>
                            <th>Major</th>
                            <th>:</th>
                            <td><?php echo $rowmodul['major_name'] ?></td>
                        </tr>
                        <tr>
                            <th>Instructor</th>
                            <th>:</th>
                            <td><?php echo $rowmodul['instructor_name'] ?></td>
                        </tr>
                    </table>
                    <br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>File</th>
                            </tr>
                        <tbody>
                            <tr>
                                <?php foreach ($rowdetailmodul as $key => $data): ?>
                                    <td><?= $key + 1 ?></td>
                                    <td>

                                        <a target="_blank" href="?page=tambah-modul&download=<?= urlencode($data['file']) ?>" download="?page=tambah-modul&download=<?= urlencode($data['file']) ?>"> <?= $data['file'] ?><i class="bi bi-download"></i>

                                        </a>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        </tbody>
                        </thead>


                    </table>
                <?php else: ?>
                    <!-- form tambah modul -->
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Instructors Name *</label>
                                    <input readonly value="<?php echo $_SESSION['NAME'] ?>" type="text" class="form-control">
                                    <input type="hidden" class="form-control" name="id_instructor" placeholder="Enter your name" value="<?php echo $_SESSION['ID_USER'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label"> Modul Name</label>
                                    <input class="form-control" type="text" name="name" placeholder="Enter your modul name">
                                </div>
                            </div>



                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Major Name</label>
                                    <select name="id_major" id="" class="form-control">
                                        <option value="">Select One </option>
                                        <?php foreach ($rowinstructormajor as $row) : ?>
                                            <option value="<?php echo $row['id_major'] ?>"><?php echo $row['name'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div align="right" class="mb-3">
                                <button type="button" class="btn btn-primary addRow" id="addRow">Add Row</button>
                            </div>
                            <table class="table" id="tableModul">
                                <thead>
                                    <tr>
                                        <th>File</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>

                            <div class="mb-3">
                                <input type="submit" class="btn btn-success" name="save" value="save">
                            </div>
                        </div>
                    </form>
                <?php endif ?>




            </div>
        </div>
    </div>
</div>

<script>
    const button = document.querySelector('.addRow');
    const tbody = document.querySelector('#tableModul tbody');

    button.addEventListener("click", function() {
        const tr = document.createElement("tr");
        tr.innerHTML = `<td><input type='file' name='file[]'></td>
        <td><button class='btn btn-danger'>Delete</button></td>`;
        tbody.appendChild(tr);
    })
</script>