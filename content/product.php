<?php
$query = mysqli_query($config, "SELECT products.*, categories.name as category_name 
FROM products
LEFT JOIN categories ON categories.id = products.id_category
ORDER BY id DESC");
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>



<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data Product</h5>
                <div class="mb-3" align="right">
                    <a href="?page=tambah-product" class="btn btn-primary">Add Product</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Description</th>
                                <th></th>

                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $key => $row): ?>
                                <tr>
                                    <td><?php echo $key += 1; ?></td>
                                    <td><?php echo $row['category_name'] ?></td>
                                    <td><?php echo $row['name'] ?></td>
                                    <td><?php echo $row['price'] ?></td>
                                    <td><?php echo $row['qty'] ?></td>
                                    <td><?php echo $row['description'] ?></td>

                                    <td>
                                        <a href="?page=tambah-product&id=<?php echo $row['id'] ?>" class="btn btn-warning">Add Produk</a>
                                        <a href="?page=tambah-product&edit=<?php echo $row['id'] ?>" class="btn btn-primary">edit</a>
                                        <a onclick="return confirm('Are You Sure Wanna Delete this Data??')" href="?page=tambah-instructor&delete=<?php echo $row['id'] ?>" class="btn btn-danger">Delete</a>
                                        
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