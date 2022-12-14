<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Product</h1>

        <br><br>

        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-30">
            <tr>
                <td>Title: </td>
                <td>
                    <input type="text" name ="title" placeholder="title of product">
                </td>
            </tr>

            <tr>
                <td>Description</td>
                <td>
                    <textarea name="description" cols="30" rows="5" placeholder ="description of the food"></textarea>
                </td>
            </tr>

            <tr>
                <td>Price</td>
                <td>
                    <input type="number" name="price">
                </td>
            </tr>

            <tr>
                <td>Select Image: </td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>

            <tr>
                <td>Category: </td>
                <td>
                    <select name="category">

                        <?php
                            //Create PHP code to display categories from database
                            //1. Create Sql to get all active categories from database
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                            //executing query
                            $res = mysqli_query($conn, $sql);

                            //count rows to check whether we have categories or not
                            $count = mysqli_num_rows($res);

                            //if count greater than 0 we have categories else we don't have categories
                            if($count>0)
                            {
                                // wehave categories
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    // get the details of categories
                                    $id = $row['id'];
                                    $title = $row['title'];

                                    ?>

                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                    <?php
                                }
                            }
                            else
                            {
                                //we don't have category
                                ?>
                                <option value="0">No categories found</option>
                                <?php
                            }


                            //2.Display on dropdown 
                        ?>
                        
                    </select>
                </td>
            </tr>

            <tr>
                <td>Featured: </td>
                <td>
                    <input type="radio" name="featured" value="Yes">Yes
                    <input type="radio" name="featured" value="No">No
                </td>
            </tr>

            <tr>
                <td>Active: </td>
                <td>
                    <input type="radio" name="active" value="Yes">Yes
                    <input type="radio" name="active" value="No">No
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Add Product" class="btn-secondary">
                </td>
            </tr>
        </table>
        </form>


        <?php

            //check whether the button is clicked or not
            if(isset($_POST['submit']))
            {
                // add the product in database
                //echo "clicked";

                //1. get the data from form 
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];

                //check whether radio button for featured active are checked or not
                if(isset($_POST['featured']))
                {
                    $featured = $_POST['featured'];
                }
                else
                {
                    $featured = "No"; //seting default value 
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No"; //setting default value
                }


                //2. upload the image if selected
                //check whether the select image is click or not upload the image only if the image is selected
                if(isset($_FILES['image']['name']))
                {
                    //get the details of the selected image
                    $image_name = $_FILES['image']['name'];

                    //check whether the image is selected or not and upload image only if selected
                    if($image_name!="")
                    {
                        //image is selected
                        //1. rename the image
                        //get the extension of the select image (jpg,png,gif)

                        $ext = end(explode('.',$image_name));

                        //create new name  for image
                        $image_name = "Product-Name-".rand(0000,9999).".".$ext; //new image name may be "Product-Name-"


                        //2. Upload the image
                        //get the src path and destination path 

                        //src path is the current location of the image
                        $src =$_FILES['image']['tmp_name'];

                        //Destination path for the image to be uploaded
                        $dst = "../images/Product/".$image_name;

                        //lastly upload the image
                        $upload = move_uploaded_file($src, $dst);

                        //check whether image uploaded or not
                        if($upload==false)
                        {
                            //failed to upload the image
                            //redirect to product page with error message
                            $_SESSION['upload'] = "<div class='error'>Failed to upload image</div>";
                            header('location:'.SITEURL.'admin/add-product.php');
                            //stop the process
                            die();
                        }
                        

                    }
                }
                else
                {
                    $image_name = ""; //setting default value as blank
                }


                //3. Insert into database
                
                //create sql query to save or add product
                //for numerical value we don't need to pass value inside qoutes '' but for string value it is compulsory to add qoutes..
                $sql2 = "INSERT INTO tbl_product SET
                    title = '$title',
                    description = '$description',
                    price = '$price',
                    image_name = '$image_name',
                    category_id = $category,
                    featured = '$featured',
                    active = '$active'     
                ";
                // execute the query
                $res2 = mysqli_query($conn, $sql2);

                //check whether the data inserted or not
                //4. redirect to message to manage product page
                if($res2==true)
                {
                    //data inserted successfully
                    $_SESSION['add'] = "<div class='success'>Product added successfully</div>";
                    header('location:'.SITEURL.'admin/manage-product.php');
                }
                else
                {
                    //failed to insert data
                    $_SESSION['add'] = "<div class='error'>failed to add product</div>";
                    header('location:'.SITEURL.'admin/manage-product.php');
                }
            
            }
        
        ?>


    </div>
</div>

<?php include('partials/footer.php');?>