<?php
// Start session if none exists
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check user is logged in
if (!isset($_SESSION['admin'])) {
    $login_error = 'Please login to access this page';
    header("Location: index.php?page=../admin/login&error=$login_error");
    exit();
}


// Only process if submit button was pushed
if (isset($_REQUEST['submit'])) {

    include("process_form.php"); // This should define $attraction_ID, $description, $region_ID_1

    // Sanitize and validate IDs from form
    $description_ID   = filter_var($_REQUEST['ID'] ?? 0, FILTER_SANITIZE_NUMBER_INT);
    $old_attraction   = filter_var($_REQUEST['attractionID'] ?? 0, FILTER_SANITIZE_NUMBER_INT);

    // Delete old attraction if it changed and has no other descriptions
    if ($old_attraction != $attraction_ID) {
        delete_ghost($dbconnect, $old_attraction);
    }

    // Prepare UPDATE statement
    $stmt = $dbconnect->prepare("UPDATE `Description` 
                                 SET `Attraction_ID` = ?, `Description` = ?, `Region1_ID` = ? 
                                 WHERE `ID` = ?");

    if ($stmt === false) {
        die("Prepare failed: " . htmlspecialchars($dbconnect->error));
    }

    // Bind parameters: i = integer, s = string
    $stmt->bind_param("issi", $attraction_ID, $description, $region_ID_1, $description_ID);

    // Execute statement
    if (!$stmt->execute()) {
        die("Execute failed: " . htmlspecialchars($stmt->error));
    }

    $stmt->close();

    // Success message and result display
    $heading_type = "edit_success";
    $sql_conditions = "WHERE ID = $description_ID";
    include("content/results.php");
}
?>
