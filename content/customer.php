<?php

$query = mysqli_query($config,"SELECT * FROM customer WHERE deleted_at is NULL ORDER BY id ASC");
                                                    
                                                    
$row = mysqli_fetch_all($query, MYSQLI_ASSOC);

if(isset($_GET['delete'])){
    $idDel = $_GET['delete'];
    $queryDel = mysqli_query($config, "UPDATE customer SET deleted_at = NOW() WHERE id = '$idDel'");
    header("location:?page=customer&remove=success");
}

?>

<div class="row"></div>
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data Customer</h5>
                
                <div class="table-responsive">
                    <div align="right" class="mb-3">
                        <a  href="?page=add_customer" class="btn btn-primary">Add Customer</a>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Number</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($row as $key => $r):?>
                            <tr>
                                <td><?= $key+=1 ?></td>
                                <td><?= $r['customer_name'] ?></td>
                                <td><?= $r['phone'] ?></td>
                                <td><?= $r['address'] ?></td>
                                <td>
                                    <a class="btn btn-primary" href="?page=add_customer&edit=<?= $r['id'] ?>">Edit</a>
                                    <a class="btn btn-danger" href="?page=customer&delete=<?= $r['id'] ?>">Hapus</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>