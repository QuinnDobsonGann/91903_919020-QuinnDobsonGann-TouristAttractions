<?php 

// Function to 'clean' input data to prevent SQL injection and XSS
function clean_input($dbconnect, $data) {
    $data = trim($data);    
    $data = htmlspecialchars($data); // correct special character rendering
    $data = mysqli_real_escape_string($dbconnect, $data); // prevent SQL injections
    return $data;
}

// Function to get data from Description table with optional WHERE condition
function get_data($dbconnect, $more_condition = null) {
    $sql = "SELECT  
                q.*,
                a.*,
                CONCAT(a.First, ' ') AS Full_Name,
                s1.Region AS Region1
            FROM description q
            JOIN Attraction a ON a.Attraction_ID = q.Attraction_ID
            JOIN all_region s1 ON q.Region1_ID = s1.Region_ID";

    if ($more_condition !== null) {
        $sql .= " " . $more_condition;
    }

    $query = mysqli_query($dbconnect, $sql);
    $count = mysqli_num_rows($query);

    return array($query, $count);
}

// Function to get a single row by ID
function get_item_name($dbconnect, $table, $column, $ID) {
    $sql = "SELECT * FROM `$table` WHERE `$column` = $ID";
    $query = mysqli_query($dbconnect, $sql);
    return mysqli_fetch_assoc($query);
}

// Function to get search ID from all_region table
function get_search_ID($dbconnect, $search_term) {
    $sql = "SELECT * FROM all_region WHERE Region LIKE '$search_term'";
    $query = mysqli_query($dbconnect, $sql);
    $count = mysqli_num_rows($query);

    if ($count === 1) {
        $row = mysqli_fetch_assoc($query);
        return $row['Region_ID'];
    } else {
        return "no results";
    }
}

// Function to generate autocomplete JSON list
function autocomplete_list($dbconnect, $item_sql, $entity) {
    $query = mysqli_query($dbconnect, $item_sql);
    $items = array();

    while ($row = mysqli_fetch_assoc($query)) {
        $items[] = $row[$entity];
    }

    return json_encode($items);
}

// Function to delete "ghost" attractions with no associated descriptions
function delete_ghost($dbconnect, $attractionID) {
    // Check how many Descriptions exist for this Attraction
    $check_sql = "SELECT * FROM `Description` WHERE `Attraction_ID` = $attractionID";
    $check_query = mysqli_query($dbconnect, $check_sql);
    $count = mysqli_num_rows($check_query);

    // If only 0 or 1 Description exists, delete the Attraction
    if ($count <= 1) {
        $delete_sql = "DELETE FROM `Attraction` WHERE `Attraction_ID` = $attractionID";
        mysqli_query($dbconnect, $delete_sql);
    }
}

?>
