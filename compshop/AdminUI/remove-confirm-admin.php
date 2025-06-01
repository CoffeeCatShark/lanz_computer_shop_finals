<?php
require_once '../Prototype_access_control/auth_check.php';
include '../conn.php';
$query = "select * from `active_table`";
$activeResult = mysqli_query($conn, $query);


$id = $_POST['index'];
$id2 = $_POST['id'];

$sql2 = "DELETE FROM `active_table` WHERE `request_id`='$id2'";
$sql = "DELETE FROM `request_table` WHERE `request_index`='$id'";

if ($conn->query($sql2) === TRUE) {
} else {
  echo "Error deleting record: " . $conn->error;
}
if ($conn->query($sql) === TRUE) {
  echo "Record deleted successfully";
} else {
  echo "Error deleting record: " . $conn->error;
}



?>
<script>
    alert("Record Deleted.");								
</script>
<meta  http-equiv="refresh" content=".000001;url=request-admin.php" />




?>