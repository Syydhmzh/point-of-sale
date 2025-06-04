<?php
if (isset($_GET['id_instructor'])) {
    $id = $_GET['id'];
    $id_instructor = $_GET['id_instructor'];

    $querydelete = mysqli_query($config, "DELETE FROM instructor_majors  WHERE id = '$id_instructor'");
    if ($querydelete) {
        header("location:?page=tambah-instructor-major&id=" . $id . "&hapus=berhasil");
    } else {
        header("location:?page=tambah-instructor-major&id=" . $id . "&tambah=berhasil");
    }
}
// $id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
// $queryedit = mysqli_query($config, "SELECT * FROM instructors WHERE id='$id_user'");
// $rowedit = mysqli_fetch_assoc($queryedit);
$id = isset($_GET['id']) ? $_GET['id'] : '';

if (isset($_POST['id_major'])) {
    //ada tidak sebuah parameter bernama edit, kalo ada jalankan perintah edit/updat, kalo tidak ada ada
    //tambah data baru / insert
    $id_major = $_POST['id_major'];
    // $id_instructor = $_POST['id_instructor'];

    $insert = mysqli_query($config, "INSERT INTO instructor_majors (id_major, id_instructor) VALUES ('$id_major','$id')");
    header("location:?page=tambah-instructor-major&id=" . $id . "&tambah=berhasil");
}


$querymajors = mysqli_query($config, "SELECT * FROM majors ORDER BY id DESC");
$rowmajors = mysqli_fetch_all($querymajors, MYSQLI_ASSOC);



$queryinstructor = mysqli_query($config, "SELECT * FROM instructors WHERE id='$id'");
$rowinstructor = mysqli_fetch_assoc($queryinstructor);

$queryinstructormajor =  mysqli_query($config, "SELECT majors.name, instructor_majors.id AS id_im, instructor_majors.id_instructor AS id_instructor_im
                                                 FROM instructor_majors 
                                                 LEFT JOIN majors ON majors.id = instructor_majors.id_major 
                                                 WHERE instructor_majors.id_instructor='$id' 
                                                 ORDER BY instructor_majors.id DESC");
$rowinstructormajors = mysqli_fetch_all($queryinstructormajor, MYSQLI_ASSOC)








?>


<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Add Instructor major: <?php echo $rowinstructor['name'] ?></h5>
                <div align="right">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Instructor Major</button>
                </div>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Major Name</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rowinstructormajors as $index => $rowinstructormajor): ?>
                            <tr>
                                <td><?php echo $index += 1 ?></td>
                                <td><?php echo $rowinstructormajor['name'] ?></td>
                                <td>
                                    <a href="?page=tambah-instructor-major&id=<?= $rowinstructormajor['id_instructor_im'] ?>&id_instructor=<?= $rowinstructormajor['id_im'] ?>" onclick="return confirm('Are You Sure Wanna Delete this Data??')" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>



<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Instructor major</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <div class="mb-3"></div>
                    <label for="">Major Name</label>
                    <select name="id_major" id="" class="form-control">
                        <option value="">Select One</option>
                        <?php foreach ($rowmajors as $rowmajor): ?>
                            <option value="<?php echo $rowmajor['id'] ?>"><?php echo $rowmajor['name'] ?></option>

                        <?php endforeach ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>