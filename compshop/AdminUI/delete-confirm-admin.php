<?php
include '../conn.php';

$id = $_POST['index'];

$sql = "DELETE FROM service_table WHERE service_index=$id";


if ($conn->query($sql) === TRUE) {
  echo "Record deleted successfully";
} else {
  echo "Error deleting record: " . $conn->error;
}

?>
<script>
    alert("Record Deleted.");								
</script>
<meta  http-equiv="refresh" content=".000001;url=service-admin.php" />




?>