<?php
    include 'header.php';
    $query = "SELECT * FROM products";
    $result = $conn->query($query);

    // Variablat per ndertimin e grafikut
	$x_axis = $y_axis = "";

?>

<body>
    <h1 id='prod'><u>PRODUCTS PAGE</u></h1>
    <div class="container">
        <div class="row" style="margin-top: 20px;">
            <div class="col-12">
                <div class="add-button">
                    <a href="#addProduct" data-toggle="modal">
                        <button id='rightBtn'>Add Product</button>
                    </a><br>
                </div>
                <div class="alert d-none">
                </div>
                <div class="table-wrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price (LEK)</th>
                                <th>Unit In Stock</th>
                                <th>Modify Product</th>
                                <th>Delete Product</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if ($result->num_rows > 0):
                                    while ($row = $result->fetch_assoc()):   

                                    	// Krijimi i te dhenave ne grafik me presje
                                        $x_axis .= "'" . $row['name'] . "',"; //emri i produktit
		                                $y_axis .= $row['price'] . ","; // cmimi i produktit
                                    ?>
                                    <tr>
                                    <td class="d-none" id="idTable">
                                        <?php echo $row['id'] //id do jete hidden ?>
                                    </td>
                                    <td id="nameTable">
                                        <?php echo $row['name'] ?>
                                    </td>
                                    <td id="descriptionTable" >
                                        <p> <?php echo $row['description'] ?> </p>
                                    </td>
                                    <td id="priceTable">
                                        <?php echo $row['price'] ?>
                                    </td>
                                    <td id="unitInStockTable">
                                        <?php echo $row['unit_in_stock'] ?>
                                    </td>
                                    <td id="update">
                                        <a href="#editProduct" data-toggle="modal">
                                            <button type="button">
                                                Edit
                                            </button>
                                        </a>
                                    </td>
                                    <td id="delete">
                                        <a href="#deleteProduct" data-toggle="modal">
                                            <button type="button">
                                                Delete
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            <?php
                             endwhile;
                        
                            // Heqim presjen
                            $lbl = trim($x_axis, ",");
                            $val = trim($y_axis, ",");

                            endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Dritarja modale Add Product -->
        <div id="addProduct" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="add_form">
                        <div class="modal-header">						
                            <h4 class="modal-title">Add Product</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">					
                            <div class="form-group">
                                <label for="name" >Name</label>
                                <input class="form-control" value="" type="text"  name="name" id="nameAdd" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="description" >Description</label>
                                <input class="form-control" value="" type="text"  name="description" id="descriptionAdd">
                            </div>
                            <div class="form-group">
                                <label for="Price" >Price</label> 
                                <input class="form-control" value="" type="text" name="price" id="priceAdd">
                            </div>
                            <div class="form-group">
                                <label for="Unit in stock" >Unit in stock</label>
                                <input class="form-control" value="" type="number" name="unit_in_stock" id="unit_in_stockAdd">
                            </div>
                            <div class="addErrors">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" value="add" name="type">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                            <button type="button" class="btn btn-success" id="btn-add">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

         <!-- Dritarja modale Modify Product -->
         <div id="editProduct" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="edit_form">
                        <input type="hidden" id="idEdit" name="id" class="form-control" required>	
                        <div class="modal-header">						
                            <h4 class="modal-title">Modify Product</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">					
                            <div class="form-group">
                                <label for="name" >Name</label>
                                <input class="form-control" type="text"  name="name" id="nameEdit" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="description" >Description</label>
                                <input class="form-control" type="text"  name="description" id="descriptionEdit">
                            </div>
                            <div class="form-group">
                                <label for="Price" >Price</label> 
                                <input class="form-control" type="text" name="price" id="priceEdit">
                            </div>
                            <div class="form-group">
                                <label for="Unit in stock" >Unit in stock</label>
                                <input class="form-control" type="number" name="unit_in_stock" id="unitInStockEdit">
                            </div>
                            <div class="editErrors">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" value="update" name="type">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                            <button type="button" class="btn btn-success" id="btn-edit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Dritarja modale Delete Product -->
        <div id="deleteProduct" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="delete_form">
                        <div class="modal-header">						
                            <h4 class="modal-title">Delete Product</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="idDelete" name="id" class="form-control">					
                            <p>A jeni te sigurte qe doni ta fshini kete produkt?</p>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                            <button type="button" class="btn btn-danger" id="btn-delete">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
            <div class="chart-container" style="position: relative; width:80vw">
                <canvas id="my_Chart"></canvas>
            </div>
            </div>
        </div>
    </div>
</body>
</html>


<script>
$(document).ready(function(){

    var lbl = [<?= $lbl ?>]; // merr te dhenat nga variabli x_axis-emrat
    var val = [<?= $val ?>]; //  merr te dhenat nga variabli y_axis-cmimet


    // Te dhenat per grafikun
    myData = {
        labels: lbl,//emrat e prod
        datasets: [{
            label: "Chart.JS",
            fill: false,
            backgroundColor: ['#ff0000', '#ff4000', '#ff8000', '#ffbf00', '#ffbf00', '#ffff00', '#bfff00', '#80ff00'],
            borderColor: 'black',
            data: val,
        }]
    };

    // Vizatimi i grafikut
    var ctx = document.getElementById('my_Chart').getContext('2d');//funksion i Canvas qe e merr si 2d kontekstin
    var myChart = new Chart(ctx, {
        type: 'bar',    //chart me shtylla
        data: myData  
    });


    $(document).on('click', '#btn-add', function (e) {
        var type = this.value;
        $.ajax({
            url: 'get_data.php',
            dataType: 'json',
            success: function(e){

                // do fshihet grafiku i meparshem
                myChart.destroy();

                //do ndertohet grafiku i ri me te dhenat e reja
                myChart = new Chart(ctx, {
                    type: 'bar',    
                    data: e    		
                });
            }
        });
    });
});
</script>