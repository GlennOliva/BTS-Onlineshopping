<?php include('partials-front/menu.php');?>

    <!-- Material search section starts here -->
    <section class="Materials-search text-center">
        <div class="container">
            <form action="<?php echo SITEURL; ?>item-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Item" required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>
        </div> 
    </section>
    <!--Material search section ends here -->

    <?php
        if(isset($_SESSION['order']))
        {
            echo $_SESSION['order'];
            unset($_SESSION['order']);
        }
    
    ?>

    <!-- Categories section starts here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Categories</h2>

            <?php 
                //create sql query to display categories from database
                $sql = "SELECT * FROM tbl_category WHERE active ='Yes' AND featured ='Yes' LIMIT 3";
                //execute the query 
                $res = mysqli_query($conn, $sql);
                //count rows to check whether the category is available or not
                $count = mysqli_num_rows($res);

                if($count>0)
                {
                    //categories available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //get the values like title, image_name , id
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>

                <a href="<?php echo SITEURL;?>category-Product.php?category_id=<?php echo $id;?>">
                    <div class="box-3 float-container">
                        <?php 
                            //check whether image is available or not
                            if($image_name=="")
                            {
                                //display message
                                echo "<div class='error'>Image not available</div>";
                            }
                            else
                            {
                                //image available
                                ?>
                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Bag" class="img-responsive img-curve">
                                <?php
                            }
                        ?>
                    

                    <h3 class="float-text text-white"><?php echo $title;?></h3> 
                    </div>
                </a>

                        <?php
                    }
                }
                else
                {
                    //categories not available 
                    echo "<div class='error'>Category not added.</div>";
                }
            
            ?>

            

            
        <div class="clearfix"></div>
    </section>
    <!--Categories section ends here -->

     <!-- Product menu Section Starts Here -->
     <section class="item-menu">
        <div class="container">
            <h2 class="text-center">Explore Items</h2>

            <?php
                //getting producs from database that are active the featured
                //SQL Query
                $sql2 = "SELECT * FROM tbl_product WHERE active ='Yes' AND featured ='Yes' LIMIT 10";


                //execute the query
                $res2 = mysqli_query($conn, $sql2);

                //count rows
                $count2 = mysqli_num_rows($res2);

                //check whether product available or not
                if($count2>0)
                {
                    //product availabe
                    while($row=mysqli_fetch_assoc($res2))
                    {
                        //get all the value
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];
                        ?>

                <div class="item-menu-box"> 
                <div class="item-menu-img1">
                <?php
                    //check whether image available or not
                    if($image_name=="")
                    {
                        //image not available
                        echo "<div class ='error'>Image not available</div>";
                    }
                    else
                    {
                        //image available
                        ?>
                        <img src="<?php echo SITEURL; ?>images/Product/<?php echo $image_name;?>" alt="bag-brown" class="img-responsive img-curve">
                        <?php

                    }
                ?>

                    
                    </div>

                    <div class="item-menu-desc">
                    <h4><?php echo $title; ?></h4>
                    <p class="item-price">₱<?php echo $price;?></p>
                    <p class="item-detail">
                       <?php echo $description;?>
                    </p>
                    <br>
                    <a href="<?php echo SITEURL; ?>order.php?product_id=<?php echo $id;?>" class="btn btn-primary">Order now</a>
                    </div>
                    <div class="clearfix"></div>
                    </div>


                    <?php


                    }
                }
                else
                {
                    //Product not available
                    echo "<div class = 'error'>Product not available</div>";
                }
            ?>

            
    

            <div class="clearfix"></div>
        </div> 
    </section>
    <!--Product menu end here-->


    <?php include('partials-front/footer.php');?>