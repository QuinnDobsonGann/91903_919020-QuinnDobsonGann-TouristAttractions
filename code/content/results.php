<?php

// Initialize variables to avoid undefined variable warnings
if (!isset($heading)) {
    $heading = "";
}
if (!isset($heading_type)) {
    $heading_type = "";
}

$all_region = get_data($dbconnect, $sql_conditions);

$find_query = $all_region[0];
$find_count = $all_region[1];

if($find_count == 1) {
    $result_s = "Results";
}
else {
    $result_s = "Results";
}

// check that we have results

if($find_count > 0) {

// Customise headings!

if($heading != "") {
    echo "<h2>$heading ($find_count $result_s)</h2>";
}
elseif ($heading_type=="attraction") {
    // retrievable attraction name
    $attraction_rs = get_item_name($dbconnect, 'attraction', 'Attraction_ID',
    $attraction_ID);

    $attraction_name = $attraction_rs['First'];
    echo "<h2>$attraction_name descriptions ($find_count $result_s)</h2>";
}
elseif ($heading_type=="region") {
    $region_name = ucwords($region_name);
    echo "<h2>$region_name descriptions ($find_count $result_s)</h2>";
}
elseif ($heading_type == "description_success") {
    echo "<h2>Insert Description Success</h2><p>You have inserted the following description:</p>";
}
elseif ($heading_type == "edit_success") {
    echo "<h2>Edit Tourist Attraction Success</h2><p>You have edited the tourist attraction. The entry is now:<p>";
}
elseif ($heading_type == "delete_description") {
    echo "<h2>Delete Tourist Attraction - Are You Sure?</h2><p>Do you really want to delete the tourist attraction in the box below?</p>";
}

while($find_rs = mysqli_fetch_assoc($find_query)) {
    $description = $find_rs['Description'];
    $ID = $find_rs['ID'];

    // Create full name of attraction
    $attraction_full = $find_rs['Full_Name'];
    // get attraction ID for clickable attraction link
    $Attraction_ID = $find_rs['Attraction_ID'];

    // set up regions
    $Region_1 = $find_rs['Region1'];
    
    // put regions in list so that we can iterate through it
    $all_region = array($Region_1);

    ?>

    <div class="results">
        <?php echo $description; ?>

        <p><i>
            <a href="index.php?page=all_region&search=attraction&Attraction_ID=<?php echo $Attraction_ID ?>">
            <?php echo $attraction_full; ?>
            </a>
        </i></p>

        <p>
        <?php

        // iterate through all_region list and output region if it is not blank.

        foreach  ($all_region as $region) {
            // check the region is not "n/a"
            if ($region != "n/a") {

                ?>
                <span class="tag region-tag">
                    <a href="index.php?page=all_region&search=region&region_name=<?php echo urlencode($region); ?>">
                        <?php echo $region;?>
                    </a>
                </span>
                &nbsp;&nbsp;

                <?php
            } // end region exists if

            } // end listing regions

            // if user is logged in, show edit / delete options
            if (isset($_SESSION['admin'])) {

                ?>
                <div class="tools">
                    <a href="index.php?page=../admin/editdescription&ID=<?php
                    echo $ID; ?>"><i class="fa fa-edit fa-2x"></i></a> &nbsp; &nbsp;
                    <a href="index.php?page=../admin/deleteconfirm&ID=<?php
                    echo $ID; ?>"><i class="fa fa-trash fa-2x"></i></a>
                </div>
                <?php  
            }

            ?>
           </p>
    
    </div>

    <br />

    <?php

}  // end of while loop

}  // end of 'have results'

// if there are no results, show an error message
else {
    
    ?>

    <h2>Sorry! </h2>

    <div class="no-results">
        Unfortunately - there were no results for your search. Please
        try again.
    </div>
    <br />

    <?php

} // end of 'no results' else


?>