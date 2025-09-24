<?php


// check user is logged on
if (isset($_SESSION['admin'])) {

// retrieve description ID and sanitise it case someone edits the URL)
$description_ID = filter_var($_REQUEST['ID'], FILTER_SANITIZE_NUMBER_INT);

// adjust heading and find description
$heading_type = "delete_description";
$heading = "";
$sql_conditions = "WHERE ID = $description_ID";

include("content/results.php");

// check that variable is defined and set to 0 if not
    if (isset($find_rs) && isset($find_rs['Attraction_ID'])) {
        $attraction_ID = $find_rs['Attraction_ID'];
    }
    else {
        $attraction_ID = 0;
    }

?>

<p>
    <span class="tag white-tag">
    <a href="index.php?page=../admin/deletedescription&ID=<?php echo $description_ID; ?>&
    attraction=<?php echo $attraction_ID ?>">Yes, Delete it!</a>
    </span>

    &nbsp;

    <span class="tag white-tag">
    <a href="index.php?page=../content/all_region&search=all">No, take me back</a>
    </span>
</p>

<?php

} // end user logged on it

else {
    $login_error = 'Please login to access this page';
    header("Location: index.php?page=../admin/login&error=$login_error");

}



?>