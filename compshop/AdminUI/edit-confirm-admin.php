<?php
include '../conn.php';

$index = $_POST['index'];
$oldID = $_POST['oldID'];
$desc = $_POST['service_desc'];
$newID = $_POST['serviceID'];

$isDup = 0;

    if($newID==$oldID)
{
    $isDup=0;
}
else
{

  $sql = "SELECT * FROM service_table WHERE Service_Id = '$newID'";
$result = $conn->query($sql);
        if($result->num_rows > 0) 
        {
            while($row = $result->fetch_assoc())
            {
                
                $isDup+=1;
                
            }
        }


}

if($isDup == 0){
    $conn->query("UPDATE service_table SET service_id = '$newID', service_type = '$desc' WHERE Service_Index = '$index'");
     echo"                  Edit Complete.";
}
else{
    echo "                  Error Updating Record. Duplicate.";
    }
?>
<html>
<head><title>Checkout</title></head>
<body>
<a href="service-admin.php">Back to Service</a>

</body>


</html>
