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
    $PositionID = filter_input(INPUT_POST, "PositionID");
    unset($_POST['PositionID']);
}

if (isset($_POST['op'])) {
    $op = filter_input(INPUT_POST, "op");
    unset($_POST['op']);
}

//checks to see if updates or deletions need to be made
if($op=='UPDATE') {
    $sql = "SELECT tblJBPositions.*
            FROM tblJBPositions
            WHERE PositionID = $PositionID";

    if ($result = $conn->runSelectQuery($sql)) {
        $fieldinfo = mysqli_fetch_fields($result);
        $row = $result->fetch_assoc();

        foreach ($fieldinfo as $val) {
            $fieldName = $val->name;

            // check to see if there is a post value
            if (isset($_POST[$fieldName])) {
                $fieldValue = filter_input(INPUT_POST, $fieldName);
                $sql = "UPDATE tblJBPositions set $fieldName = '$fieldValue' WHERE  PositionID=$PositionID";
                $conn->runQuery($sql);
            }
        }
    }
    $result = $conn->runQuery($sql);

    print_r($sql);

    if ($result === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: $sql";
    }
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