<?php
if(isset($_GET['edit'])){
    $idEdit = $_GET['edit'];

    $queryEdit = mysqli_query($config, "SELECT * FROM customer WHERE id = '$idEdit'");
    $rowEdit = mysqli_fetch_assoc($queryEdit);
    $nameForm = $rowEdit['customer_name'];
    $phoneForm = $rowEdit['phone'];
    $addressForm = $rowEdit['address'];
    $required = "";
    $req = "";

    
}else {
    $nameForm = "";
    $phoneForm = "";
    $addressForm = "";
    $required ="required";
    $req = "*";
}

$queryLevel = mysqli_query($config, "SELECT * FROM level ORDER BY id ASC");
$rowLevel = mysqli_fetch_all($queryLevel, MYSQLI_ASSOC);

if(isset($_POST['save'])){
    $name = $_POST['customer_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    

    if(isset($_GET['edit'])){
        
       
        $queryUpd = mysqli_query($config, "UPDATE customer SET 
                                                            customer_name='$name',
                                                            phone ='$phone',
                                                            address ='$address',
                                                            WHERE id = $idEdit
                                                            ");
         if($queryUpd){
        header("location:?page=customer&change=success");
        }else{
        header("location:?page=customer&change=failed");
        }
    }else {
        $queryInsert = mysqli_query($config, "INSERT INTO customer (customer_name, phone, address) VALUES ('$name', '$phone', '$address'    )");
        if($queryInsert){
            header("location:?page=customer&add=success");
        }else{
            header("location:?page=customer&add=failed");
        }
    }
}



?>



<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Add Customer</h5>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="" class="form-label">Name *</label>
                        <input type="text" name="customer_name" value="<?= $nameForm ?>" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Phone *</label>
                        <input type="number" name="phone" value="<?= $phoneForm ?>"  class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Address *</label>
                        <input type="text" name="address" value="<?= $addressForm ?>" class="form-control">
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="save" class="btn btn-success"><?= isset($_GET['edit']) ? 'Edit': 'Save' ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
