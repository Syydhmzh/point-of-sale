<?php
if (isset($_GET['delete'])) {
    $id_user = isset($_GET['delete']) ? $_GET['delete'] : '';
    $querydelete = mysqli_query($config, "UPDATE users SET deleted_at = 1 WHERE id = '$id_user'");
    if ($querydelete) {
        header("location:?page=user&hapus=berhasil");
    } else {
        header("location:?page=user&hapus=gagal");
    }
}
$id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryedit = mysqli_query($config, "SELECT * FROM users WHERE id='$id_user'");
$rowedit = mysqli_fetch_assoc($queryedit);

if (isset($_POST['name'])) {
    //ada tidak sebuah parameter bernama edit, kalo ada jalankan perintah edit/updat, kalo tidak ada ada
    //tambah data baru / insert
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = isset($_POST['password']) ? sha1($_POST['password']) : $rowedit['password'];




    if (!isset($_GET['edit'])) {
        $insert = mysqli_query($config, "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");
        header("location:?page=user&tambah=berhasil");
    } else {
        $update = mysqli_query($config, "UPDATE users SET name='$name', email='$email', password='$password' WHERE id='$id_user'");
        header("location:?page=user&ubah=berhasil");
    }
}
$id_user = isset($_GET['add-user-role']) ? $_GET['add-user-role'] : '';


$queryuserroles = mysqli_query($config, "SELECT user_roles.*, roles.name FROM user_roles 
LEFT JOIN roles ON user_roles.id_role = roles.id
where id_user = '$id_user'
ORDER BY user_roles.id_user DESC");
$rowuserroles = mysqli_fetch_all($queryuserroles, MYSQLI_ASSOC);



if (isset($_POST['id_role'])) {
    $id_role = $_POST['id_role'];
    $insert = mysqli_query($config, "INSERT INTO user_roles (id_role, id_user) VALUES ('$id_role', '$id_user')");
    header("location:?page=user&add-user-role=" . $id_role . "&add-role=berhasil");
}

$queryproducts = mysqli_query($config, "SELECT * FROM products  ORDER BY id DESC");
$rowrproducts = mysqli_fetch_all($queryproducts, MYSQLI_ASSOC);

$querynotrans = mysqli_query($config, "SELECT MAX(id) as id_trans FROM transactions");
$rownotrans = mysqli_fetch_assoc($querynotrans);
$id_trans = $rownotrans['id_trans'];
$id_trans++;

$format_no = "TR";
$date = date('dmy');
$icrement_number = sprintf("%03s", $id_trans);
$no_transaction = $format_no . "_" .  $date . "_" . $icrement_number;


if (isset($_POST['check'])) {
    $no_transaction = $_POST['no_transaction'];
    $id_user = $_POST['id_user'];
    $grandtotal = $_POST['grandtotal'];

    $instransaction = mysqli_query($config, "INSERT INTO transactions (id_user, no_transaction, sub_total) VALUES ('$id_user', '$no_transaction', '$grandtotal')");

    if ($instransaction) {
        $id_transaction = mysqli_insert_id($config);
        $id_products = $_POST['id_product'];
        $qtys = $_POST['qty'];
        $total = $_POST['total'];


        foreach ($id_products as $key => $id_product) {
            $qty = $qtys[$key];
            $total = $total[$key];

            $instransacdetail =  mysqli_query($config, "INSERT INTO transactions_detail ( id_product, id_transaction, qty, total) VALUES ( '$id_product', '$id_transaction', '$qty', '$total')");
        }
        header("location:?page=pos");
    }
}

?>


<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <?php if (isset($_GET['add-user-role'])):
                    $title = "Add User Role : ";
                elseif (isset($_GET['edit'])):
                    $title = 'Edit User Role :';
                else:
                    $title = 'Add User :';
                endif; ?>
                <h5 class="card-title"><?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> User</h5>
                <?php if (isset($_GET['add-user-role'])): ?>
                    <div align="right">
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Role</button>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Role Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rowuserroles as $key => $rowuserrole): ?>
                                <tr>
                                    <td><?php echo $key + 1 ?></td>
                                    <td><?php echo $rowuserrole['name'] ?></td>
                                    <td>
                                        <a href="" class="btn btn-primary btn-sm">Edit</a>
                                        <a onclick="return confirm('Are You Sure Wanna Delete this Data??')" href="?page=tambah-user&delete=<?php echo $rowuserrole['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <!-- <div class="mb-3">
                        <label for="">Role Name *</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter your name" value="<?= isset($rowedit['name']) ? $rowedit['name'] : "" ?>" required>
                    </div> -->
                <?php else: ?>
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label for="">No Transaction </label>
                                    <input type="text" class="form-control" name="no_transaction" placeholder="Enter your name" value="<?php echo $no_transaction ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="">Product </label>
                                    <select class="form-control" id="id_product" name="">
                                        <option value="">Select One</option>
                                        <?php foreach ($rowrproducts as $rowproduct): ?>
                                            <option data-price="<?php echo $rowproduct['price'] ?>" value="<?php echo $rowproduct['id'] ?>"><?php echo $rowproduct['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label for="">Cashier *</label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter your name" value="<?php echo $_SESSION['NAME'] ?>" readonly>
                                    <input type="hidden" name="id_user" value="<?php echo $_SESSION['ID_USER'] ?>">
                                </div>
                            </div>
                        </div>
                        <div align="right" class="mb-3">
                            <button type="button" class="btn btn-primary addRow" id="addRow">Add Row</button>
                        </div>

                        <div class="table-responsive">
                            <table class="table" id="myTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama product</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <br>
                            <p><strong>Grand Total: Rp. <span id="grand_total"></span></strong></p>
                            <input type="hidden" name="grandtotal" id="grandtotalinput" value="0">
                            <div class="mb-3">
                                <button type="submit" name="check">Save</button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="submit" class="btn btn-success" name="save" value="save">
                        </div>
                    </form>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Role</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="">Role Name</label>
                        <select name="id_role" id="" class="form-control">
                            <option value="">Select One</option>
                            <?php foreach ($rowroles as $rowrole): ?>
                                <option value="<?php echo $rowrole['id'] ?>"><?php echo $rowrole['name'] ?></option>

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


<script>
    const button = document.querySelector('.addRow');
    const tbody = document.querySelector('#myTable tbody');
    const select = document.querySelector('#id_product');


    const grandtotal = document.getElementById('grand_total');
    const grandtotalinput = document.getElementById('grandtotalinput');



    let no = 1;
    button.addEventListener("click", function() {
        const selectedproduct = select.options[select.selectedIndex];
        const productvalue = selectedproduct.value;
        if (!productvalue) {
            alert("Please select a product");
            return;
        }
        const productname = selectedproduct.textContent;
        const productprice = selectedproduct.dataset.price;
        const tr = document.createElement("tr");
        tr.innerHTML = `
        <td>${no}</td>
        <td>
        <input type='hidden' name='id_product[]' class='id_products' value='${select.value}'>${productname}
        </td>

        <td>
        <input type='number' name='qty[]' value='1' class='qtys' value='1'>
        <input type='hidden' name='price[]' value='${productprice}'>
        </td>

        <td>
        <input type='hidden' class='totals' name='total[]' value='${productprice}'><span class='totaltext'>${productprice}</span>
        </td>

        <td>
        <button class='btn btn-success btn-sm deleteRow' type='button'>Delete</button>
        </td>`;


        tbody.appendChild(tr);
        no++;
        select.value = ""; // Reset the select input after adding a row
        updategrandtotal();


        select.value = ""; // Reset the select input after adding a row
    })

    tbody.addEventListener("click", function(e) {
        if (e.target.classList.contains('deleteRow')) {
            e.target.closest('tr').remove();

        }
        updateNumber();
        updategrandtotal();


    });

    tbody.addEventListener("input", function(e) {
        if (e.target.classList.contains('qtys')) {
            const row = e.target.closest('tr');
            const qty = parseInt(e.target.value) || 0;
            const price = parseInt(row.querySelector('[name="price[]"]').value);


            row.querySelector('.totals').value = qty * price;
            row.querySelector('.totaltext').textContent = qty * price;

            updategrandtotal();
        }
    });



    function updateNumber() {
        const rows = tbody.querySelectorAll('tr');
        rows.forEach(function(row, index) {

            row.cells[0].textContent = index + 1;

        });
        no = rows.length + 1;

    }

    function updategrandtotal() {
        const totals = tbody.querySelectorAll('.totals');
        let grand = 0;
        totals.forEach(function(input) {
            grand += parseInt(input.value) || 0;
        });
        grandtotal.textContent = grand.toLocaleString('id-ID');
        grandtotalinput.value = grand;
        console.log(grandtotalinput.value);
    }
</script>