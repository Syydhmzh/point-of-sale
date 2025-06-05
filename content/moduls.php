<?php
$query = mysqli_query($config, "SELECT majors.name as major_name, instructors.name as instructor_name, moduls.*  
FROM moduls 
LEFT JOIN majors ON majors.id = moduls.id_major
LEFT JOIN instructors ON instructors.id = moduls.id_instructor
ORDER BY moduls.id DESC");
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>



<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"> Moduls</h5>
                <div class="mb-3" align="right">
                    <a href="?page=tambah-modul" class= "btn btn-primary">Add Modul</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Instructor</th>
                                <th>Major</th>
                                <th>Tilte</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $key => $row): ?>
                                <tr>
                                    <td><?php echo $key += 1; ?></td>
                                    <td><?php echo $row['instructor_name'] ?></td>
                                    <td><?php echo $row['major_name'] ?></td>
                                    <td><?php echo $row['name'] ?></td>
                                    <td>
                                        <a href="?page=tambah-modul&edit=<?php echo $row['id'] ?>" class="btn btn-primary">edit</a>
                                        <a onclick="return confirm('Are You Sure Wanna Delete this Data??')" href="?page=tambah-modul&delete=<?php echo $row['id'] ?>" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>

                            <?php endforeach ?>
                        </tbody>


                    </table>
                </div>
            </div>
        </div>
    </div>
</div>