<?php
$querytransaction = mysqli_query($config, "SELECT users.name, transactions.* FROM transactions 
LEFT JOIN users ON users.id = transactions.id_user
ORDER BY id DESC");
$rowtransaction = mysqli_fetch_all($querytransaction, MYSQLI_ASSOC);

if (isset($_GET['delete'])) {
    $iddel = $_GET['delete'];
    $querydelete = mysqli_query($config, "DELETE FROM transactions WHERE id = '$iddel'");
    if ($querydelete) {
        header("Location:?page=pos");
        exit;
    }
}

?>



<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data Transaction</h5>
                <div class="mb-3" align="right">
                    <a href="?page=tambah-pos" class="btn btn-primary">Add Transaction</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Transaction</th>
                                <th>Cashier Name</th>
                                <th>Sub Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rowtransaction as $key => $row): ?>
                                <tr>
                                    <td><?php echo $key += 1; ?></td>
                                    <td><?php echo $row['no_transaction'] ?></td>
                                    <td><?php echo $row['name'] ?></td>
                                    <td><?php echo "Rp." . $row['sub_total'] ?></td>

                                    <td>
                                        <a href="?page=print-pos&print=<?php echo $row['id'] ?>" class="btn btn-primary">Print</a>
                                        <a onclick="return confirm('Are You Sure Wanna Delete this Data??')" href="?page=pos&delete=<?php echo $row['id'] ?>" class="btn btn-danger">Delete</a>
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