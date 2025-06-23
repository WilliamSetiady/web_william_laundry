<?php
//query select customer 
$queryCustomer = mysqli_query($config, "SELECT * FROM customer WHERE deleted_at is NULL");
$rowCustomer = mysqli_fetch_all($queryCustomer, MYSQLI_ASSOC);
//query select service
$queryService = mysqli_query($config, "SELECT * FROM type_of_service WHERE deleted_at is NULL");
$rowService = mysqli_fetch_all($queryService, MYSQLI_ASSOC);
//for order code
$queryNoTrans = mysqli_query($config, "SELECT MAX(id) as id_trans FROM trans_order");
$rowNoTrans = mysqli_fetch_assoc($queryNoTrans);

$format_no = "LDR";
$date = date("dmy");
$id_trans = $rowNoTrans['id_trans'];
$id_trans++;
$increment_number = sprintf("%03s", $id_trans);
$no_transaction = $format_no . "-" . $date . "-" . $increment_number;

?>
<div class="card">
    <div class="card-body">
        <h5 class="card-title"></h5>
        <div class="container d-flex flex-column align-item-center">
            <div class="row">
                <div class="col-sm-3">
                    <div class="mb-5">
                        <label class="form-label" for="">Customer</label>
                        <select name="id" id="" class="form-control">
                            <option value="">Select One</option>
                        <?php foreach($rowCustomer as $customer): ?>
                            <option value="<?= $customer['id'] ?>"><?= $customer['customer_name'] ?></option>
                        <?php endforeach ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="">Order Date</label>
                        <input value="<?= date('Y-m-d') ?>" type="date" name="order_date" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="mb-5">
                        <label class="form-label" for="">Order Code</label>
                        <input type="text" name="order_code" value="<?= $no_transaction ?>" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="">Task Finished Date</label>
                        <input type="date" name="order_end_date" class="form-control">
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="mt-5">
                        <label class="form-label" for="">Service</label>
                        <select class="form-control" name="id" id="id_service">
                            <option value="">Select One</option>
                            <?php foreach($rowService as $service): ?>
                            <option data-price="<?= $service['price'] ?>" value="<?= $service['id'] ?>"><?= $service['service_name'] ?></option>
                            <?php endforeach ?>
                        </select>
                    <div class="mt-5">
                        <label for="" class="form-label">Notes</label>
                        <input type="text" id="notes" name="notes" class="form-control">
                    </div>
                    </div>
                </div>
            </div>
            </div>
           <div align="right" class="mb-3">
                <button type="button" class="btn btn-primary addRow" id="addRow">Add Row</button>
            </div>
            <table class="table" id="tablePos">
                <thead>
                    <tr>
                        <th>Number</th>
                        <th>Services</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th>Notes</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
<br>
        <p><strong>Grand Total: Rp. <span id="grandTotal"></span></strong></p>
        <input type="hidden" name="grand_total" id="grandTotalInput" value="0">
        <div class="mb-3">
            <button type="submit" name="check">Save</button>
        </div>
        </div>
    </div>
</div>



<script>
    
    const button = document.querySelector('.addRow');
    const tbody = document.querySelector('#tablePos tbody');
    const select = document.querySelector('#id_service');
    const selectN = document.querySelector('#notes');
    
    const grandTotal = document.getElementById('grandTotal');
    const grandTotalInput = document.getElementById('grandTotalInput');
    //mengganti content suatu variable
    // button.textContent = "duar";
    //jika text == add Row maka akan menjadi duar
    let no = 1
    button.addEventListener("click", function() {

        const selectedProduct = select.options[select.selectedIndex];
        const productValue = selectedProduct.value;
        const noteValue = selectN.value;

        if(!productValue){
            alert("Please select a service first!!");
            return;
        }
        const productName = selectedProduct.textContent;
        const productPrice = selectedProduct.dataset.price;
        // console.log(select);
        
        // alert('duar');
        const tr = document.createElement("tr"); //membuat <tr></tr>
        tr.innerHTML = `
        <td>${no}</td>
        <td><input type='hidden' name='id_service[]' value='${productValue}'  class='id_service'>${productName}</td>
        <td>
        <input type='number' value='1' name='td_qty[]' class='qtys'>
        <input type='hidden' class='priceInput' value='${productPrice}' name='price[]'>
        </td>
        <td><input type='hidden'  class='totals' name='td_total[]' value='${productPrice}'><span class='totalText'>${productPrice}</span></td>
        <td><input type='hidden'  class='notes' name='notes[]' value='${noteValue}'>${noteValue}</td>
        <td><button class='btn btn-success btn-sm removeRow'>Delete</button></td>
        `; //menambahkan <td></td> kedalam tr

        tbody.appendChild(tr);
        no++;
        
        
        select.value ="";
        updateGrandTotal();
    });

    tbody.addEventListener('click', function(e) {
        if (e.target.classList.contains('removeRow')) {
            e.target.closest("tr").remove();
        }
        updateNumber()

        updateGrandTotal();
    });

    tbody.addEventListener('input', function(e){
        if(e.target.classList.contains('qtys')){
            const row = e.target.closest("tr");
            const qty = parseInt(e.target.value) || 0;
            const price = parseInt(row.querySelector('.priceInput').value);
            
            row.querySelector('.totalText').textContent=price*qty;
            row.querySelector('.totals').value=price*qty;
            // console.log(qty);

            updateGrandTotal();
        }
    })

    function updateNumber() {
        const rows = tbody.querySelectorAll("tr");
        rows.forEach(function(row, index) {
            row.cells[0].textContent = index + 1;
        });

        no = rows.length + 1;
    }

    function updateGrandTotal(){
        const totalCells = tbody.querySelectorAll('.totals');
        let grand = 0;
        totalCells.forEach(function(input){
            grand +=parseInt(input.value) || 0;
        });
        grandTotal.textContent = grand.toLocaleString('id-ID');
        grandTotalInput.value = grand;
    }
</script>