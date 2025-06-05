<?php
if (isset($_GET['delete'])) {
    $id_instructor = $_GET['id_instructor'];
    $id_instructor_major = $_GET['delete'];
    // print_r($id_instructor);
    // print_r($id);
    // die;

    $querydelete = mysqli_query($config, "DELETE FROM instructor_majors  WHERE id = '$id_instructor_major'");
    if ($querydelete) {
        header("location:?page=tambah-instructor-major&id=" . $id_instructor . "&hapus=berhasil");
    } else {
        header("location:?page=tambah-instructor-major&id=" . $id_instructor . "&tambah=berhasil");
    }
}

$edit = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryedit = mysqli_query($config, "SELECT * FROM instructor_majors WHERE id='$edit'");
$rowedit = mysqli_fetch_assoc($queryedit);

$id_instructor = isset($_GET['id']) ? $_GET['id'] : '';

if (isset($_POST['id_major'])) {
    //ada tidak sebuah parameter bernama edit, kalo ada jalankan perintah edit/updat, kalo tidak ada ada
    //tambah data baru / insert
    $id_major = $_POST['id_major'];
    if (isset($_GET['edit'])) {
        $update = mysqli_query($config, "UPDATE instructor_majors SET id_major='$id_major' WHERE id='$edit'");
        header("location:?page=tambah-instructor-major&id=" . $id_instructor . "&ubah=berhasil");
    } else {
        $insert = mysqli_query($config, "INSERT INTO instructor_majors (id_major, id_instructor) VALUES ('$id_major','$id_instructor')");
        header("location:?page=tambah-instructor-major&id=" . $id_instructor . "&tambah=berhasil");
    }
}




$querymajors = mysqli_query($config, "SELECT * FROM majors ORDER BY id DESC");
$rowmajors = mysqli_fetch_all($querymajors, MYSQLI_ASSOC);



$queryinstructor = mysqli_query($config, "SELECT * FROM instructors WHERE id='$id_instructor'");
$rowinstructor = mysqli_fetch_assoc($queryinstructor);


$queryinstructormajor =  mysqli_query($config, "SELECT instructor_majors.*, majors.name
                                                 FROM instructor_majors
                                                 LEFT JOIN majors ON majors.id = instructor_majors.id_major 
                                                 WHERE instructor_majors.id_instructor='$id_instructor ' 
                                                 ORDER BY instructor_majors.id DESC");
$rowinstructormajors = mysqli_fetch_all($queryinstructormajor, MYSQLI_ASSOC);








?>


<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo isset($_GET['edit']) ? 'edit' : 'add' ?> Instructor Major : <?php echo $rowinstructor['name'] ?></h5>
                <!-- form edit -->
                <?php if (isset($_GET['edit'])): ?>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="">Major Name</label>
                            <select name="id_major" id="" class="form-control">
                                <option value="">Select One</option>
                                <?php foreach ($rowmajors as $rowmajor): ?>
                                    <option <?php echo ($rowmajor['id'] == $rowedit['id_major']) ? 'selected' : '' ?> value="<?php echo $rowmajor['id'] ?>"><?php echo $rowmajor['name'] ?></option>

                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>

                    </form>



                    <!-- end form edit -->
                <?php else: ?>
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
                                        <a href="?page=tambah-instructor-major&id=<?= $rowinstructormajor['id_instructor'] ?>&edit=<?= $rowinstructormajor['id'] ?>" class="btn btn-primary">Edit</a>
                                        <a href="?page=tambah-instructor-major&id_instructor=<?= $rowinstructormajor['id_instructor'] ?>&delete=<?= $rowinstructormajor['id'] ?>" onclick="return confirm('Are You Sure Wanna Delete this Data??')" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                <?php endif ?>
                <!-- listing table -->
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
                    <div class="mb-3">
                        <label for="">Major Name</label>
                        <select name="id_major" id="" class="form-control">
                            <option value="">Select One</option>
                            <?php foreach ($rowmajors as $rowmajor): ?>
                                <option value="<?php echo $rowmajor['id'] ?>"><?php echo $rowmajor['name'] ?></option>

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