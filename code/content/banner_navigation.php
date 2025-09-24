<?php
// Get total description count for use elsewhere if needed
require_once(__DIR__ . '/../config.php');
$query = "SELECT COUNT(*) as total FROM Description";
$result = mysqli_query($dbconnect, $query);
$row = mysqli_fetch_assoc($result);
$desc_count = $row['total'];
?>
<div class="box banner">
    <h1>Quick Tourist Attractions</h1>
</div>    <!-- / banner -->

<!-- Navigation goes here.  Edit BOTH the file name and the link name -->
<div class="box nav">
    <div class="linkwrapper">
        <div class="commonsearches">
            <a href="index.php?page=all_region&search=all">Tourist Attractions</a> | 
            <a href="index.php?page=all_region&search=recent">Recent</a> | 
            <a href="index.php?page=all_region&search=random">Random</a> 
        </div>  <!-- / common searches -->
    <div class="topsearch">
        <!-- Quick Search -->           
        <form method="post" action="index.php?page=quick_search"
        enctype="multipart/form-data">

                        <input class="search quicksearch" type="text"
                         name="quick_search" size="40" value="" required placeholder="Quick Search..." />

                        <select class="quick-choose" name="search_type">
                            <option value="all" selected>All</option>
                            <option value="description">Description</option>
                            <option value="attraction">Attraction</option>
                            <option value="region">Region</option>
                        </select>

                        <button class="submit" name="find_quick">
                        <i class="fa fa-search"></i>
                        </button>


                    </form>     <!-- / quick search -->
                    
                </div>  <!-- / top search -->

                <div class="topadmin">               


                <?php
                    if(isset($_SESSION['admin'])) {

                        ?>

                        <a href="index.php?page=../admin/add_description">
                        <i class="fa fa-plus fa-2x"></i></a>
                        &nbsp; &nbsp;
                        <a href="index.php?page=../admin/logout">
                        <i class="fa fa-sign-out fa-2x"></i></a>

                        <?php

                    } // end admin if

                else {

                    ?>
                        <a href="index.php?page=../admin/login">Log in</a>
                    <?php

                } // end login else
                ?>
                
                
                    
                </div>  <!-- / top admin -->
                
            </div>  <!--- / link wrapper -->
            
        </div>    <!-- / nav -->