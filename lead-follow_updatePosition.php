<?php
// File: updatePosition.php
// Updates position entries
// Prints JSON array

//connect to db controller
require_once 'dbcontroller.php';

//create connection
$conn = new DBController();

//default for testing
$op = 'UPDATE';
$PositionID = $_POST['PositionID'];

if (isset($_POST['PositionID'])) {
    $DutyPositionID = filter_input(INPUT_POST, "PositionID");
    unset($_POST['PositionID']);
}

if (isset($_POST['op'])) {
    $op = filter_input(INPUT_POST, "op");
    unset($_POST['op']);
}

//checks to see if updates or deletions need to be made

if($op == 'UPDATE') {
    $PosStartDate = $_POST['PosStartDate'];
    $PosEndDate = $_POST['PosEndDate'];
    $PosNote = $_POST['PosNote'];
    $PosDidFail = $_POST['PosDidFail'];

    $sql = "UPDATE tblJBPositions
SET
  PosStartDate = '$PosStartDate',
  PosEndDate = '$PosEndDate',
  PosNote = '$PosNote',
  PosDidFail = '$PosDidFail'
WHERE
  PositionID = '$PositionID'";

    $result = $conn->runQuery($sql);
    if ($result === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: $sql";
    }
//$connection->close();
}
else if($op == 'DELETE') {
    $sql = " DELETE FROM tblJBPositions
               WHERE  PositionID=$PositionID
             ";
    $result = $conn->runDeleteQuery($sql);

    print_r($sql);

    if ($result === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: $sql";
    }
}
?>