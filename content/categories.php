<?php
$query = mysqli_query($config, "SELECT * FROM categories  ORDER BY id DESC");
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>



<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data Categories</h5>
                <div class="mb-3" align="right">
                    <a href="?page=tambah-categories" class="btn btn-primary">Add Categories</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Majors</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $key => $row): ?>
                                <tr>
                                    <td><?php echo $key += 1; ?></td>
                                    <td><?php echo $row['name'] ?></td>
                                    <td>
                                        <a href="?page=tambah-categories&edit=<?php echo $row['id'] ?>" class="btn btn-primary">edit</a>
                                        <a onclick="return confirm('Are You Sure Wanna Delete this Data??')" href="?page=tambah-categories&delete=<?php echo $row['id'] ?>" class="btn btn-danger">Delete</a>
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