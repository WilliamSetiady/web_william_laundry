<?php
if(isset($_GET['edit'])){
    $idEdit = $_GET['edit'];

    $queryEdit = mysqli_query($config, "SELECT * FROM type_of_service WHERE id = '$idEdit'");
    $rowEdit = mysqli_fetch_assoc($queryEdit);
    $sNForm = $rowEdit['service_name'];
    $priceForm = $rowEdit['price'];
    $descForm = $rowEdit['description'];
    $required = "";
    $req = "";

    
}else {
    $sNForm = "";
    $priceForm = "";
    $descForm = "";
    $required ="required";
    $req = "*";
}


if(isset($_POST['save'])){
    $sN = $_POST['service_name'];
    $price = $_POST['price'];
    $desc = $_POST['description'];
    

    if(isset($_GET['edit'])){
        
        $queryUpd = mysqli_query($config, "UPDATE type_of_service SET 
                                                            service_name='$sN',
                                                            price ='$price',
                                                            description ='$desc'
                                                            WHERE id = $idEdit
                                                            ");
         if($queryUpd){
        header("location:?page=tos&change=success");
    }else{
        header("location:?page=tos&change=failed");
    }
    }else { 
        $queryInsert = mysqli_query($config, "INSERT INTO type_of_service (service_name, price, description) VALUES ('$sN', '$price', '$desc')");
        if($queryInsert){
            header("location:?page=tos&add=success");
        }else{
            header("location:?page=tos&add=failed");
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
                        <label for="" class="form-label">Service <?= $req ?></label>
                        <input <?= $required ?> type="text" name="service_name" value="<?= $sNForm ?>" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Price <?= $req ?></label>
                        <input <?= $required ?> type="number" name="price" value="<?= $priceForm ?>"  class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Description </label>
                        <input type="text" name="description" value="<?= $descForm ?>" class="form-control">
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="save" class="btn btn-success"><?= isset($_GET['edit']) ? 'Edit': 'Save' ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
