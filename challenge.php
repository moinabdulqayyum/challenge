
<!DOCTYPE html>
<html lang="en">
<head>
<title> Shopify Challenge </title>
</head>
<body>
	
<center>
	<h1> Shopify Challenge </h1> 
<form method = "POST" action="challenge.php">
	<label for="id"><b>ID</b></label>
    <input type="number" placeholder="Enter ID" name="id" step=1 min=0> <br> <br>
    

    <label for="pName"><b>Product Name</b></label>
    <input type="text" placeholder="Enter name" name="pName"> <br> <br>
    

    <label for="qty"><b>Quantity</b></label>
    <input type="number" placeholder="Enter quantity" name="qty" step=1 min=0> <br> <br>
    

    <label for="price"><b>Price</b></label>
    <input type="number" placeholder="Enter price" name="price" step=0.01 min=0> <br><br>
    
    <input type="submit" name="create" class="button" value="Create" />
    <p>Enter name, price and quantity. ID is ignored.</p>
    <input type="submit" name="update" class="button" value="Update" />
    <p>Enter ID and whatever else you wish to update.</p>
    <input type="submit" name="delete" class="button" value="Delete" />
    <p>Enter the ID. Everything else is ignored.</p>
    <input type="submit" name="display" class="button" value="Display" />
    <p>Just press the button. Everything will be display</p>
    
</form>
</center>
</body>
</html>

<?php

function create(){
    $con = mysqli_connect("localhost", "root", "","challenge");
    $name=$_POST['pName'];
    $qty=$_POST['qty'];
    $price=$_POST['price'];


    if(empty($name)||empty($qty)||empty($price)){
        echo "<center><strong>Please enter all required information</strong></center>";
    }
    else{
        if(mysqli_connect_errno($con)){
            echo "Failed to connect to MySQL:".mysqli_connect_errno($con);
        }
        else{
            $query="INSERT INTO product (pName,qty,price) VALUES ('$name','$qty','$price')";
            if(!mysqli_query($con,$query)){
                echo "Something went wrong",mysqli_error($con);
            }
            else{
                echo "<center><strong>Insertion Successfully</strong></center>";
            }
        }
    }
    mysqli_close($con);
}

function update(){
    $con = mysqli_connect("localhost", "root", "","challenge");
    $id=$_POST['id'];
    $name=$_POST['pName'];
    $qty=$_POST['qty'];
    $price=$_POST['price'];
    if(empty($id)){
        echo "<center><strong>Please enter ID of product to update</strong></center>";
    }
    else{
        if(mysqli_connect_errno($con)){
            echo "Failed to connect to MySQL:".mysqli_connect_errno($con);
        }
        else{
            $query1="UPDATE product SET pName='$name' WHERE id='$id'";
            $query2="UPDATE product SET qty='$qty' WHERE id='$id'";
            $query3="UPDATE product SET price='$price' WHERE id='$id'";
            if(!empty($name)){
                if(!mysqli_query($con,$query1)){
                    echo "Something went wrong",mysqli_error($con);
                }
            }
            if(!empty($qty)){
                if(!mysqli_query($con,$query2)){
                    echo "Something went wrong",mysqli_error($con);
                }
            }
            if(!empty($price)){
                if(!mysqli_query($con,$query3)){
                    echo "Something went wrong",mysqli_error($con);
                }
            }
            echo "<center><strong>Update Successfully</strong></center>";
        }
    }
    mysqli_close($con);
}

function delete(){
    $con = mysqli_connect("localhost", "root", "","challenge");
    $id=$_POST['id'];


    if(empty($id)){
        echo "<center><strong>Please enter the ID</strong></center>";
    }
    else{
        if(mysqli_connect_errno($con)){
            echo "Failed to connect to MySQL:".mysqli_connect_errno($con);
        }
        else{
            $query="DELETE FROM product WHERE id='$id'";
            if(!mysqli_query($con,$query)){
                echo "Something went wrong",mysqli_error($con);
            }
            else{
                echo "<center><strong>Deletion Successfully</strong></center>";
            }
        }
    }
    mysqli_close($con);
}

function display(){
    $con = mysqli_connect("localhost", "root", "","challenge");

    if(mysqli_connect_errno($con)){
            echo "Failed to connect to MySQL:".mysqli_connect_errno($con);
    }
    else{
        $query="SELECT * FROM product";
            if(!mysqli_query($con,$query)){
                echo "Something went wrong",mysqli_error($con);
            }
            else{
                $output=mysqli_query($con,$query);
                echo "<center><table border='1'>
                <tr>
                <th>ID</th><th>Product Name</th><th>Quantity</th><th>Price</th>
                </tr>";
                while($row = mysqli_fetch_array($output)){
                    echo "<tr>
                    <td>" . $row['id'] . "</td><td>" . $row['pName'] . "</td><td>" . $row['qty'] . "</td><td>" . $row['price'] . "</td>
                    </tr>";
                }
                echo "</table></center>";
            }
    }
    mysqli_close($con);
}

function exportCSV(){

}
//connect and error check
$con = mysqli_connect("localhost", "root", "");

if(mysqli_connect_errno($con)){
    echo "Failed to connect to MySQL:".mysqli_connect_errno($con);
}
else{
    //create a database if it does not already exist
    $createDB="CREATE DATABASE IF NOT EXISTS challenge";
    if(!mysqli_query($con,$createDB)){
        echo "Something went wrong",mysqli_error($con);
    }
    else{
        //select the database and create the table if it does not exist
        mysqli_select_db($con,"challenge");
        $createTbl="CREATE TABLE IF NOT EXISTS product(id INTEGER NOT NULL AUTO_INCREMENT, pName VARCHAR(50), qty INTEGER, price FLOAT,
        PRIMARY KEY(id))";
        if(!mysqli_query($con, $createTbl)){
            echo "Error creating table: ". mysqli_error($con);
        }
    }
}
mysqli_close($con);
if(isset($_POST['create'])){
    create();
}
if(isset($_POST['update'])){
    update();
}
if(isset($_POST['delete'])){
    delete();
}
if(isset($_POST['display'])){
    display();
}
if(isset($_POST['export'])){
    exportCSV();
}




?>