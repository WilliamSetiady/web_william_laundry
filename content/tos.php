<?php

$query = mysqli_query($config,"SELECT * FROM type_of_service ORDER BY id ASC");
$row = mysqli_fetch_all($query, MYSQLI_ASSOC);

if(isset($_GET['delete'])){
    $idDel = $_GET['delete'];
    $queryDel = mysqli_query($config, "UPDATE type_of_service SET deleted_at = NOW() WHERE id = '$idDel'");
    header("location:?page=user&remove=success");
}

?>

<div class="row"></div>
    <div class="col-sm-12">
        <div class="card card1" style="background-color:#256666;">
            <div class="card-body">
                <h5 class="card-title">Data Service</h5>
                
                <div class="table-responsive">
                    <div align="right" class="mb-3">
                        <a  href="?page=add_tos" class="btn btn-primary">Add Service</a>
                    </div>
                    <table class="table table1  table-bordered">
                        <thead>
                            <tr>
                                <th>Number</th>
                                <th>Services</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($row as $key => $r):?>
                            <tr>
                                <td><?= $key+=1 ?></td>
                                <td><?= $r['service_name'] ?></td>
                                <td><?= $r['price'] ?></td>
                                <td><?= $r['description'] ?></td>
                                <td>
                                    <a class="btn btn-primary" href="?page=add_tos&edit=<?= $r['id'] ?>">Edit</a>
                                    <a class="btn btn-danger" href="?page=tos&delete=<?= $r['id'] ?>">Hapus</a>
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