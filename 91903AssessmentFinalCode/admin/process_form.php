<?php
// Safely retrieve data from form using null coalescing to avoid undefined index warnings
$description      = $_REQUEST['description'] ?? '';
$attraction_full  = $_REQUEST['attraction_full'] ?? '';
$region1          = $_REQUEST['region1'] ?? '';

$first = "";

// Initialise IDs
$region_ID_1 = $attraction_ID = "";

// check to see if region / attraction is in DB, if it isn't add it
$regions = array($region1);
$region_IDs = array();

// Prepare statement to insert region(s)
$stmt_region = $dbconnect->prepare("INSERT INTO `All_Region` (`Region`) VALUES (?);");

// Loop through regions
foreach ($regions as $region) {
    // Skip empty region names
    if (empty($region)) continue;

    $regionID = get_search_ID($dbconnect, $region);

    if ($regionID === "no results") {
        $stmt_region->bind_param("s", $region);
        $stmt_region->execute();
        $regionID = $dbconnect->insert_id;
    }

    $region_IDs[] = $regionID;
}

// retrieve first region ID
$region_ID_1 = $region_IDs[0] ?? null;

// Check if attraction exists by full name
$find_attraction_id = "SELECT * FROM Attraction WHERE First = ?";
$stmt_attraction = $dbconnect->prepare($find_attraction_id);
$stmt_attraction->bind_param("s", $attraction_full);
$stmt_attraction->execute();
$result = $stmt_attraction->get_result();

if ($result && $result->num_rows > 0) {
    $find_attraction_rs = $result->fetch_assoc();
    $attraction_ID = $find_attraction_rs['Attraction_ID'];
} else {
    // Insert attraction into DB using full name
    $stmt_attraction_insert = $dbconnect->prepare("INSERT INTO `Attraction` (`First`) VALUES (?);");
    $stmt_attraction_insert->bind_param("s", $attraction_full);
    $stmt_attraction_insert->execute();

    $attraction_ID = $dbconnect->insert_id;
}
?>
