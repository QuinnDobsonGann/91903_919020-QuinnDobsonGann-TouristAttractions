<?php

// check user is logged on
if (isset($_SESSION['admin'])) {

    $ID = $_REQUEST['ID'];
    $attraction_ID = $_REQUEST['attraction'];

    delete_ghost($dbconnect, $attraction_ID);

    $delete_sql = "DELETE FROM `Description` WHERE `Description`.`ID` = $ID";
    $delete_query = mysqli_query($dbconnect, $delete_sql);

    ?>
    <h2>Delete Success</h2>

    <p>The requested tourist attraction has been deleted.</p>
    <?php


} // end user logged on it

else {
    $login_error = 'Please login to access this page';
    header("Location: index.php?page=../admin/login&error=$login_error");
}

?>