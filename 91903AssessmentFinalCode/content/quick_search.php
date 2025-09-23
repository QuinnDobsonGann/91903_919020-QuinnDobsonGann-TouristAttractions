<?php

// retrieve search type...
$search_type = clean_input($dbconnect, $_POST['search_type']);
$search_term = clean_input($dbconnect, $_POST['quick_search']);

// set up searches...
$description_search = "q.Description LIKE '%$search_term%'";

$region_search = "
s1.Region LIKE '%$search_term%'";

$name_search = "
CONCAT(a.First, ' ') LIKE '%$search_term%'
OR CONCAT(a.First, ' ') LIKE '%$search_term%'
";

if ($search_type == "description") {
    $sql_conditions = "WHERE $description_search";
}

elseif ($search_type == "attraction") {
    $sql_conditions = "WHERE $name_search";
}

elseif ($search_type == "region") {
    $sql_conditions = "WHERE $region_search";
}

else {
    $sql_conditions = "
    WHERE $name_search OR $description_search OR $region_search
    ";}

$heading = "'$search_term' Descriptions";

include ("results.php");

?>