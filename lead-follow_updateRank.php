<?php
// File: updateRank.php
// Updates rank entries
// Prints JSON array

//connect to db controller
require_once 'dbcontroller.php';

//create connection
$conn = new DBController();


$op = 'UPDATE';
$JBRankID = $_POST['JBRankID'];


if (isset($_POST['JBRankID'])) {
    $JBRankID = filter_input(INPUT_POST, "JBRankID");
    unset($_POST['JBRankID']);
}

if (isset($_POST['op'])) {
    $op = filter_input(INPUT_POST, "op");
    unset($_POST['op']);
}


if($op=='UPDATE') {
    $sql = "SELECT tblJBRanks.*
            FROM tblJBRanks
            WHERE JBRankID = $JBRankID";

    if ($result = $conn->runSelectQuery($sql)) {
        $fieldinfo = mysqli_fetch_fields($result);
        $row = $result->fetch_assoc();

        foreach ($fieldinfo as $val) {
            $fieldName = $val->name;

            // check to see if there is a post value
            if (isset($_POST[$fieldName])) {
                $fieldValue = filter_input(INPUT_POST, $fieldName);
                $sql = "UPDATE tblJBRanks set $fieldName = '$fieldValue' WHERE  JBRankID=$JBRankID";
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
    $sql = " DELETE FROM tblJBRanks
               WHERE  JBRankID=$JBRankID
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