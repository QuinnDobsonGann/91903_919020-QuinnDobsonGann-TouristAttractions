<?php

// check user is logged on
if (isset($_SESSION['admin'])) {

    if(isset($_REQUEST['submit']))
{

    include("process_form.php");

// insert attraction
$stmt = $dbconnect -> prepare("INSERT INTO `Description` (`Attraction_ID`,
`Description`, `Region1_ID`) VALUES
(?, ?, ?); ");
$stmt -> bind_param("isi", $attraction_ID, $description, $region_ID_1);
$stmt -> execute();

$description_ID = $dbconnect -> insert_id;

// Close stmt once everything has been inserted
$stmt -> close();

$heading = "";
$heading = "Description Success";
$sql_conditions = "WHERE ID = $description_ID";

include("content/results.php");

} // end submit button pushed



} // end user logged on it

else {
    $login_error = 'Please login to access this page';
    header("Location: index.php?page=../admin/login&error=$login_error");
}


?>