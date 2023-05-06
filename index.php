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
        <h2>List of Clients</h2>
        <a href="/crud/create.php" class="btn btn-primary" role="button">New Client</a>
        <br>
        <table class ="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Date Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //create connection
                $servername ='localhost';
                $username='root';
                $password = 'root';
                $dbname = 'crud';
                
                $connection = new mysqli($servername, $username, $password, $dbname);
                //check connection
                if ($connection->connect_error){
                    die("Connection Failed". $connection->connect_error);
                }
                //read db row
                $sql = "SELECT * FROM user_info";
                $result = $connection->query($sql);
                if (!$result){
                    die("Invalid Query". $connection->connect_error);
                }
                //read db all data
                while($row = $result->fetch_assoc()){
                    echo "
                    <tr>
                        <td>$row[id]</td>
                        <td>$row[name]</td>
                        <td>$row[email]</td>
                        <td>$row[phone]</td>
                        <td>$row[address]</td>
                        <td>$row[created_at]</td>
                        <td>
                            <a href='/crud/edit.php?id=$row[id]' class='btn btn-primary btn-sm' >Edit</a>
                            <a href='/crud/delete.php?id=$row[id]' class='btn btn-danger btn-sm' >Delete</a>
                        </td>
                    </tr>";
                }
                ?>
                
            </tbody>
        </table>
    </div>
</body>
</html>