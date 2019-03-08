<?php
// File: updateInspection.php
// Updates inspection entries
// Prints JSON array


//connect to db controller
require_once 'dbcontroller.php';

//create connection
$conn = new DBController();

$op = 'UPDATE';
$JBInspectionID = $_POST['JBInspectionID'];

if (isset($_POST['JBInspectionID'])) {
    $JBInspectionID = filter_input(INPUT_POST, "JBInspectionID");
    unset($_POST['JBInspectionID']);
}

if (isset($_POST['op'])) {
    $op = filter_input(INPUT_POST, "op");
    unset($_POST['op']);
}

if($op=='UPDATE') {
    $sql = "SELECT tblJBInspections.*
            FROM tblJBInspections
            WHERE JBInspectionID = $JBInspectionID";

    if ($result = $conn->runSelectQuery($sql)) {
        $fieldinfo = mysqli_fetch_fields($result);
        $row = $result->fetch_assoc();

        foreach ($fieldinfo as $val) {
            $fieldName = $val->name;

            // check to see if there is a post value
            if (isset($_POST[$fieldName])) {
                $fieldValue = filter_input(INPUT_POST, $fieldName);
                $sql = "UPDATE tblJBInspections set $fieldName = '$fieldValue' WHERE  JBInspectionID=$JBInspectionID";
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
else if($op == 'DELETE')
{
    $sql = " DELETE FROM tblJBInspections
               WHERE  JBInspectionID=$JBInspectionID
             ";
    $result = $conn->runDeleteQuery($sql);

    print_r($sql);

    if ($result === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: $sql";
    }
}
//$connection->close();
?>