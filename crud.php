<?php
include 'config.php';

if(isset($_POST['type']) && $_POST['type'] == 'update'){
    $productId = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $unit_in_stock = $_POST['unit_in_stock'];

    $errors=[];
    if(empty($name)){
        $errors['name'] = 'Please fill in product name!';
    }
    
    if(empty($price)){
        $errors['price'] = 'Please fill in product price! ';
    }
    if(empty($unit_in_stock)){
        $errors['unit_in_stock'] = 'Please fill in product stock!';
    }

    if(count($errors)){
        $_SESSION['errors'] = $errors; 
        echo json_encode(['statusCode' => 400, 'errors' => $errors]);
        die;
    }

      $sql="UPDATE `products`
            SET `name` = ?, `description` = ?, `price` = ?, `unit_in_stock` = ? 
            WHERE `id` = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdii", $name, $description, $price, $unit_in_stock, $productId);
    $result = $stmt->execute();

    $editProduct = "<tr>
                <td class='d-none' id='idTable'>
                    $productId
                </td>
                <td id='nameTable'>
                    $name
                </td>
                <td id='descriptionTable' >
                    <p> $description </p>
                </td>
                <td id='priceTable'>
                    $price
                </td>
                <td id='unitInStockTable'>
                    $unit_in_stock
                </td>
                <td id='update'>
                    <a href='#editProduct' data-toggle='modal'>
                        <button type='button'>
                            Edit
                        </button>
                    </a>
                </td>
                <td id='delete'>
                    <a href='#deleteProduct' data-toggle='modal'>
                        <button type='button'>
                            Delete
                        </button>
                    </a>
                </td>
            </tr>";
    
    if ($result) {
        echo json_encode(['editProduct' => $editProduct , 'statusCode' => 200, 'message' => 'Record updated successfully.']);
        die;
    }else{
        echo [ 'statusCode' => 500, 'message' => "Error:". $sql . "<br>". $conn->error];
        die;
    }
}

if(isset($_POST['type']) && $_POST['type'] == 'add'){
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $unit_in_stock = $_POST['unit_in_stock'];

    $errors = [];
    if(empty($name)){
        $errors['name'] = "Please fill in product name !";
    }
    
    if(empty($price)){
        $errors['price'] = "Please fill in product price !";
    }
    if(empty($unit_in_stock)){
        $errors['unit_in_stock'] = "Please fill in product unit_in_stock !";
    }
    
    if(count($errors)){
        echo json_encode(['statusCode' => 400, 'errors' => $errors]);
        die;
    }

    $sql = "INSERT INTO `products`(`name`, `description`, `unit_in_stock`, `price`) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssid", $name, $description, $unit_in_stock, $price);
    $result = $stmt->execute();

    $lastInsertedId = mysqli_insert_id($conn);

    $newProduct = "<tr>
                <td class='d-none' id='idTable'>
                    $lastInsertedId
                </td>
                <td id='nameTable'>
                    $name
                </td>
                <td id='descriptionTable' >
                    <p> $description </p>
                </td>
                <td id='priceTable'>
                    $price
                </td>
                <td id='unitInStockTable'>
                    $unit_in_stock
                </td>
                <td id='update'>
                    <a href='#editProduct' data-toggle='modal'>
                        <button type='button'>
                            Edit
                        </button>
                    </a>
                </td>
                <td id='delete'>
                    <a href='#deleteProduct' data-toggle='modal'>
                        <button type='button'>
                            Delete
                        </button>
                    </a>
                </td>
            </tr>";
 
    if ($result) {
        echo json_encode(['newProduct' => $newProduct, 'statusCode' => 200, 'message' => 'New record created successfully']);
        die;
    }else{
        echo [ 'statusCode' => 500, 'message' => "Error:". $sql . "<br>". $conn->error];
        die;
    }
}

if(isset($_GET['type']) && $_GET['type'] == 'delete'){

    $productId = $_GET['id'];
    
    $sql = "DELETE FROM `products` WHERE `id` = '$productId' ";
    $result = $conn->query($sql);

    if ($result) {
        echo json_encode(['statusCode' => 200, 'message' => 'Record deleted successfully.']);
        die;
    }else{
        echo [ 'statusCode' => 500, 'message' => "Error:". $sql . "<br>". $conn->error];
        die;
    }
}

?>
