<?php
// check user is logged on
if (isset($_SESSION['admin'])) {

// retrieve regions and attractions to populate combo box
include("sub_attraction.php");

 ?>

<div class = "admin-form">
    <h1>Add a Tourist Attraction</h1>

    <form action="index.php?page=../admin/insert_description" method="post">
        <p>
            <textarea name="description" placeholder="Description (Required)"
            required></textarea>
        </p>

        <div class="autocomplete">
            <input name="attraction_full" id="attraction_full" placeholder="Attraction Name (required)"
            required />
        </div>

        <br /><br />

        <div class="autocomplete">
            <input name="region1" id="region1" placeholder="Region (required)"
            required />
        </div>

        <br /><br />


        <p><input class="form-submit" type="submit" name="submit"
        value="Submit Description" /></p>

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