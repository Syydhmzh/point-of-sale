<?php
$query = mysqli_query($config, "SELECT * FROM menus  ORDER BY id DESC");
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>



<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data Menu</h5>
                <div class="mb-3" align="right">
                    <a href="?page=tambah-menu" class="btn btn-primary">Add Menu</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Parent Id</th>
                                <th>Icon</th>
                                <th>Url</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $key => $row): ?>
                                <tr>
                                    <td><?php echo $key += 1; ?></td>
                                    <td><?php echo $row['name'] ?></td>
                                    <td><?php echo $row['parent_id'] ?></td>
                                    <td><?php echo $row['icon'] ?></td>
                                    <td><?php echo $row['url'] ?></td>
                                    <td>
                                        <a href="?page=tambah-menu&edit=<?php echo $row['id'] ?>" class="btn btn-primary">edit</a>
                                        <a onclick="return confirm('Are You Sure Wanna Delete this Data??')" href="?page=tambah-menu&delete=<?php echo $row['id'] ?>" class="btn btn-danger">Delete</a>
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