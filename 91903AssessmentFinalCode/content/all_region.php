<?php

// retrieve search type...
$search_type = clean_input($dbconnect, $_REQUEST['search']);


if ($search_type == "all") {
    // Get total description count for heading
    $query = "SELECT COUNT(*) as total FROM Description";
    $result = mysqli_query($dbconnect, $query);
    $row = mysqli_fetch_assoc($result);
    $desc_count = $row['total'];
    $heading = "All Tourist Attractions";
    $heading_message = "<p><strong>Total Tourist Attractions: $desc_count</strong></p>";
    $sql_conditions = "";
}

elseif ($search_type == "recent") {
    $heading = "Recent Tourist Attractions";
    $sql_conditions = "ORDER BY q.ID DESC LIMIT 10";
}

elseif ($search_type == "random") {
    $heading = "Random Tourist Attractions";
    $sql_conditions = "ORDER BY RAND() LIMIT 10";
}

elseif (strtolower($search_type)=="attraction") {
    // retrieve attraction ID
    $attraction_ID = $_REQUEST['Attraction_ID'];

    $heading = "";
    $heading_type = "attraction";

    $sql_conditions = "WHERE q.Attraction_ID = $attraction_ID";
}

elseif ($search_type=="region") {

    // retrieve region
    $region_name = $_REQUEST['region_name'];


    $heading = "";
    $heading_type = "region";

    $sql_conditions = "
    WHERE
    s1.Region LIKE '$region_name'
    
    ";
}

else {
    $heading = "No results test";
    $sql_conditions = "WHERE q.ID = 1000";
}

include ("results.php")

?>