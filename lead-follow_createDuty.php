<?php
// File: createDuty.php
// Pulls info for JBDuties from the database
// Prints JSON array
// Needs CadetID 

//connect to db controller
require_once 'dbcontroller.php';

//create connection
$conn = new DBController();

$fkClassDetailID = $_POST['fkClassDetailID']; 
$JobPosition= $_POST['JobPosition'];

//Date Validation added 2/27
$validStartDate = strtotime($_POST['DutyStartDate']);
$validStartDate = date('Y-m-d', $validStartDate);//off by one (gets fixed when retrieving in the js)
$DutyStartDate = $validStartDate;

$validEndDate = strtotime($_POST['DutyEndDate']);
$validEndDate = date('Y-m-d', $validEndDate);//off by one (gets fixed when retrieving in the js)
$DutyEndDate = $validEndDate;

$DutyNote= $_POST['DutyNote'];
$DutyDidFail= $_POST['DutyDidFail'];


$sql = "INSERT INTO tblJBDuties(fkClassDetailID,JobPosition,DutyStartDate,DutyEndDate,DutyNote,DutyDidFail) values('$fkClassDetailID','$JobPosition','$DutyStartDate', '$DutyEndDate', '$DutyNote', '$DutyDidFail')";

//echo($sql);

$result = $conn->createRecord($sql);

//$connection->close();
?>