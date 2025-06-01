<?php
include '../conn.php';

$id = $_POST['index'];

$sql = "DELETE FROM `active_table` WHERE `active_index`='$id'";


if ($conn->query($sql) === TRUE) {
  echo "Record deleted successfully";
} else {
  echo "Error deleting record: " . $conn->error;
}

?>
<script>
    alert("Record Deleted.");								
</script>
<meta  http-equiv="refresh" content=".000001;url=admin-activedisplay.php" />




?>