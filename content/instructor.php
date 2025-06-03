<?php
$query = mysqli_query($config, "SELECT * FROM instructors WHERE deleted_at = 0 ORDER BY id DESC");
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>



<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data Instructor</h5>
                <div class="mb-3" align="right">
                    <a href="?page=tambah-instructor" class="btn btn-primary">Add Instructor</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Full Name</th>
                                <th>Gender</th>
                                <th>Education</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $key => $row): ?>
                                <tr>
                                    <td><?php echo $key += 1; ?></td>
                                    <td><?php echo $row['name'] ?></td>
                                    <td><?php echo $row['gender'] == 1 ? 'Laki-laki' : 'Perempuan' ?></td>
                                    <td><?php echo $row['education'] ?></td>

                                    <td>
                                        <a href="?page=tambah-instructor&edit=<?php echo $row['id'] ?>" class="btn btn-primary">edit</a>
                                        <a onclick="return confirm('Are You Sure Wanna Delete this Data??')" href="?page=tambah-instructor&delete=<?php echo $row['id'] ?>" class="btn btn-danger">Delete</a>
                                        <a href="?page=instructor$detail" class="btn btn-success">Detail</a>
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