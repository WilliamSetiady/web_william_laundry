<?php

$query = mysqli_query($config,"SELECT level.level_name, user.* FROM user
                                                                        LEFT JOIN level ON level.id = user.id_level
                                                                        ORDER BY user.id ASC");
$row = mysqli_fetch_all($query, MYSQLI_ASSOC);

if(isset($_GET['delete'])){
    $idDel = $_GET['delete'];
    $queryDel = mysqli_query($config, "DELETE FROM user WHERE id = '$idDel'");
    header("location:?page=user&remove=success");
}

?>

<div class="row"></div>
    <div class="col-sm-12">
        <div class="card card1" style="background-color:#256666;">
            <div class="card-body">
                <h5 class="card-title">Data User</h5>
                
                <div class="table-responsive">
                    <div align="right" class="mb-3">
                        <a  href="?page=add_user" class="btn btn-primary">Add User</a>
                    </div>
                    <table class="table table1  table-bordered">
                        <thead>
                            <tr>
                                <th>Number</th>
                                <th>Level</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($row as $key => $r):?>
                            <tr>
                                <td><?= $key+=1 ?></td>
                                <td><?= $r['level_name'] ?></td>
                                <td><?= $r['name'] ?></td>
                                <td><?= $r['email'] ?></td>
                                <td>
                                    <a class="btn btn-primary" href="?page=add_user&edit=<?= $r['id'] ?>">Edit</a>
                                    <a class="btn btn-danger" href="?page=user&delete=<?= $r['id'] ?>">Hapus</a>
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