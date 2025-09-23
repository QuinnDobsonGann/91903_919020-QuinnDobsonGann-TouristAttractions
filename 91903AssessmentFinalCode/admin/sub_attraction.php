<?php

// get all regions from database
$all_tags_sql = "SELECT * FROM `All_Region` ORDER BY `All_Region`.`Region` ASC";
$all_region = autocomplete_list($dbconnect, $all_tags_sql, 'Region');

// initialise region variables
$tag_1 = "";

// initialise tag ID's
$tag_1_ID = 0;

// get attracion full name from database
$attraction_full_sql = "SELECT *, CONCAT(First, ' ') AS Full_Name FROM attraction" ;
$all_attractions = autocomplete_list($dbconnect, $attraction_full_sql, 
'Full_Name');

?> 