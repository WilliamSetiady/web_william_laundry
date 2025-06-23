<?php
if(isset($_GET['edit'])){
    $idEdit = $_GET['edit'];

    $queryEdit = mysqli_query($config, "SELECT * FROM user WHERE id = '$idEdit'");
    $rowEdit = mysqli_fetch_assoc($queryEdit);
    $nameForm = $rowEdit['name'];
    $emailForm = $rowEdit['email'];
    $required = "";
    $req = "";

    
}else {
    $nameForm = "";
    $emailForm = "";
    $required ="required";
    $req = "*";
}

$queryLevel = mysqli_query($config, "SELECT * FROM level ORDER BY id ASC");
$rowLevel = mysqli_fetch_all($queryLevel, MYSQLI_ASSOC);

if(isset($_POST['save'])){
    $level = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    

    if(isset($_GET['edit'])){
        
        $password = empty($_POST['password']) ? $rowEdit['password'] : sha1($_POST['password']); 
        $queryUpd = mysqli_query($config, "UPDATE user SET 
                                                            id_level='$level',
                                                            name ='$name',
                                                            email ='$email',
                                                            password ='$password'
                                                            WHERE id = $idEdit
                                                            ");
         if($queryUpd){
        header("location:?page=user&change=success");
        }else{
        header("location:?page=user&change=failed");
        }
    }else {
        $password = sha1($_POST['password']);
        $queryInsert = mysqli_query($config, "INSERT INTO user (id_level, name, email, password) VALUES ('$level', '$name', '$email', '$password')");
        if($queryInsert){
            header("location:?page=user&add=success");
        }else{
            header("location:?page=user&add=failed");
        }
    }
}



?>



<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Add User</h5>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="" class="form-label">Level *</label>
                       <select class="form-control" name="id" id="">
                        <option value="">Select One</option>
                        <?php foreach($rowLevel as $level): ?>
                            <option <?= isset($_GET['edit']) ? ($level['id'] == $rowEdit['id_level'] ? "selected" : '') : '' ?> value="<?= $level['id'] ?>"><?= $level['level_name'] ?></option>
                        <?php endforeach ?>
                       </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Name *</label>
                        <input type="text" name="name" value="<?= $nameForm ?>"  class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Email *</label>
                        <input type="email" name="email" value="<?= $emailForm ?>" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Password <?= $req ?></label>
                        <input type="password" name="password" value="" class="form-control" <?= $required ?>>
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="save" class="btn btn-success"><?= isset($_GET['edit']) ? 'Edit': 'Save' ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
