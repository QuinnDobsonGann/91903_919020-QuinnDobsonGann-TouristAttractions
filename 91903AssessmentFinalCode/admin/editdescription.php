<?php
// check user is logged on
if (isset($_SESSION['admin'])) {

// retrieve regions and attractions to populate combo box
include("sub_attraction.php");
// Retrieve current values for description...
$ID = $_REQUEST['ID'];

// get values from DB
$edit_query = get_data($dbconnect, "WHERE q.ID = $ID");

$edit_results_query = $edit_query[0];
$edit_results_rs = mysqli_fetch_assoc($edit_results_query);

$attraction_ID = $edit_results_rs['Attraction_ID'];
$attraction_full_name = $edit_results_rs['Full_Name'];
$description = $edit_results_rs['Description'];
$region_1 = $edit_results_rs['Region1'];


 ?>

<div class = "admin-form">
    <h1>Edit a tourist attraction</h1>

    <form action="index.php?page=../admin/change_description&ID=<?php echo
    $ID; ?>&attractionID=<?php echo $attraction_ID; ?>" method="post">
        <p>
            <textarea name="description" placeholder="Description (Required)"
            required><?php echo $description; ?></textarea>
        </p>

        <div class="important">
            If you edit an attraction, it will change the attraction name
            for the description being edited. It does not edit the
            attraction name on all descriptions attributed to that attraction.
        </div>
        <br />

        <div class="autocomplete">
            <input name="attraction_full" id="attraction_full" value ="<?php
            echo str_replace('  ', ' ', $attraction_full_name); ?>" required /></p>
        </div>

        <div class="light_blue">
            Regions can be edited. But is Required for the Tourist Attraction.
        </div>
        <br />

        

        <div class="autocomplete">
            <input name="region1" id="region1"
            value = "<?php echo $region_1; ?>" required />
        </div>

        <br /><br />

        <p><input class="form-submit" type="submit" name="submit"
        value="Edit description" /></p>

    </form>


    <script>
        <?php include("autocomplete.php"); ?>

        /* Arrays containing lists. */
        var all_tags = <?php print("$all_region") ?>;
        autocomplete(document.getElementById("region1"), all_tags);

        var all_attractions = <?php print("$all_attractions") ?>;
        autocomplete(document.getElementById("attraction_full"),
        all_attractions);

    </script>

</div>

<?php 
    } // end user logged on if

    else {
        $login_error = 'Please login to access this page';
        header("Location: index.php?page=../admin/login&
        error=$login_error");
    }
?>