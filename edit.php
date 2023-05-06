<?php
$servername = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'crud';

$connection = new mysqli($servername, $username, $password, $dbname);

$id = "";
$name = "";
$email = "";
$phone = "";
$address = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    if (!isset($_GET["id"])) {
        header("location:/crud/index.php");
        exit;
    }
    $id = $_GET["id"];

    $sql = "SELECT * FROM user_info WHERE id= ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: /crud/index.php");
        exit;
    }

    $name = htmlspecialchars($row['name']);
    $email = htmlspecialchars($row['email']);
    $phone = htmlspecialchars($row['phone']);
    $address = htmlspecialchars($row['address']);

} else {
    //post method: update data
    $id = $_POST['id'];
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $address = htmlspecialchars($_POST['address']);

    do {
        if (empty($id) || empty($name) || empty($email) || empty($phone) || empty($address)){
            $errorMessage = "All fields are required";
            break;
        }

        $sql = "UPDATE user_info " .
                "SET name = ?, email = ?, phone = ?, address = ? " .
                "WHERE id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssssi", $name, $email, $phone, $address, $id);
        $stmt->execute();

        if(!$stmt->affected_rows){
            $errorMessage = "Invalid Query".$connection->error;
            break;
        }

        $successMessage = "User Updated Successfully";

        header("location:/crud/index.php");
        exit;
    } while (false);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <title>Document</title>
    
</head>
<body>
    <div class="container my-5">
        <h2>Edit Client</h2>

        <?php
        if (!empty($errorMessage)){
            echo "
            <div class='aler alert-warning alert dismissable fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dissmiss='alert' aria-label='Close'></button>
            </div>";
        }
        
        ?>
        <form method="post">
            <input type="hidden" name="id" id="id" value="<?php echo $id;?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text"class="form-control" name="name" value="<?php echo $name;?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="email"class="form-control" name="email" value="<?php echo $email;?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Phone</label>
                <div class="col-sm-6">
                    <input type="text"class="form-control" name="phone" value="<?php echo $phone;?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-6">
                    <input type="text"class="form-control" name="address" value="<?php echo $address;?>">
                </div>
            </div>

            <?php
            if(!empty($successMessage)){
                echo
                "<div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-6'>
                        <div class='alert alert-success alert-dismissable fade show' role='alert'>
                            <strong>$successMessage</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>Cancel</button>
                        </div>
                    </div>
                </div>";
            }
            
            ?>
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a href="/crud/index.php" class="btn btn-outline-primary" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>