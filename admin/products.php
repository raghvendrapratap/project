<?php include('header.php'); ?>
<?php include('sidebar.php'); ?>
<?php
$name1 = "submit";
$value = "submit";
$x = 0;
$name = "";
$price = "";
$img = "";
$cat = "";
$des = "";
$tag_arr = array();
include('config.php');

if (isset($_GET['id'])) {
    if ($_GET['action'] == 'delete') {
        $id = $_GET['id'];
        $sql = "DELETE from products WHERE id = $id";
        $result = $conn->query($sql);
    }

    if ($_GET['action'] == 'edit') {
        $x = 1;
        $name = $_GET['name'];
        $price = $_GET['price'];
        $img = $_GET['img'];
        $cat = $_GET['cat'];
        $tag = $_GET['tags'];
        $tag_arr = explode(" ", $tag);
        $des = $_GET['desc'];
        $name1 = "update";
        $value = "Update";
    }
    // unset($_GET['id']);
}

if (isset($_POST['update'])) {
    $checkbox = "";
    $checkbox = isset($_POST['check']) ? $_POST['check'] : '';
    $chk = "";
    if ($checkbox != "") {
        foreach ($checkbox as $chk1) {
            $chk .= $chk1 . " ";
        }
    }
    //echo $chk;
    $id = $_POST['id'];
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $image = isset($_POST['image']) ? $_POST['image'] : '';
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $tags = $chk;
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    if ($image == '') {
        $image = $_POST['img'];
    }

    $sql = "UPDATE products SET name = '$name', price= $price, image='$image', category='$category',tags='$tags',description='$description'
    WHERE id = $id;";
    $result = $conn->query($sql);
}


if (isset($_POST['submit'])) {
    $checkbox = "";
    $checkbox = isset($_POST['check']) ? $_POST['check'] : '';
    $chk = "";
    if ($checkbox != "") {
        foreach ($checkbox as $chk1) {
            $chk .= $chk1 . " ";
        }
    }
    //echo $chk;
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $image = isset($_POST['image']) ? $_POST['image'] : '';
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $tags = $chk;
    $description = isset($_POST['description']) ? $_POST['description'] : '';

    $sql = "INSERT INTO products (name, price, image,category, tags,description) VALUES('$name',$price,'$image','$category','$tags','$description')";
    $result = $conn->query($sql);
}

?>

<div id="main-content">
    <!-- Main Content Section with everything -->

    <noscript>
        <!-- Show a notification if the user has disabled javascript -->
        <div class="notification error png_bg">
            <div>
                Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
            </div>
        </div>
    </noscript>

    <!-- Page Head -->
    <h2>Welcome John</h2>
    <p id="page-intro">What would you like to do?</p>

    <div class="clear"></div> <!-- End .clear -->

    <div class="content-box">
        <!-- Start Content Box -->

        <div class="content-box-header">

            <h3>Products</h3>

            <ul class="content-box-tabs">
                <li><a href="#tab1" <?php if ($x == 0) : ?>class="default-tab" <?php endif; ?>>Manage</a></li> <!-- href must be unique and match the id of target div -->
                <li><a href="#tab2" <?php if ($x == 1) : ?>class="default-tab" <?php endif; ?>><?php if ($value == "submit") {
                                                                                                    echo "Add";
                                                                                                } else {
                                                                                                    echo "Update";
                                                                                                } ?></a></li>
            </ul>

            <div class="clear"></div>

        </div> <!-- End .content-box-header -->

        <div class="content-box-content">

            <div class="tab-content <?php if ($x == 0) : ?>default-tab <?php endif; ?>" id="tab1">
                <!-- This is the target div. id must match the href of this div's tab -->

                <div class="notification attention png_bg">
                    <a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
                    <div>
                        This is a Content Box. You can put whatever you want in it. By the way, you can close this notification with the top-right cross.
                    </div>
                </div>

                <table>

                    <thead>
                        <tr>
                            <th><input class="check-all" type="checkbox" /></th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Tags</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php
                        $row_page = 5;
                        if (isset($_GET['page'])) {
                            $page = $_GET['page'];
                        } else {
                            $page = 1;
                        }

                        $start = ($page - 1) * $row_page;
                        $sql = "SELECT * FROM products LIMIT $start, $row_page";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><input type="checkbox" /></td>
                                    <td><?php echo $row["id"]; ?></td>
                                    <td><?php echo $row["name"]; ?></td>
                                    <td><?php echo $row["price"]; ?></td>
                                    <td><img src="resources/pimages/<?php echo $row["image"]; ?>" alt="<?php echo $row["image"]; ?>" width='84' height='100' /></img> </td>
                                    <td><?php echo $row["category"]; ?></td>
                                    <td><?php echo $row["tags"]; ?></td>
                                    <td><?php echo $row["description"]; ?></td>
                                    <td>
                                        <!-- Icons -->
                                        <a href="products.php?id=<?php echo $row["id"]; ?>&name=<?php echo $row["name"]; ?>&price=<?php echo $row["price"]; ?>&img=<?php echo $row["image"]; ?>&cat=<?php echo $row["category"]; ?>&tags=<?php echo $row["tags"]; ?>&action=edit" title="Edit"><img src="resources/images/icons/pencil.png" alt="Edit" /></a>
                                        <a href="products.php?id=<?php echo $row["id"]; ?>&action=delete" title="Delete"><img src="resources/images/icons/cross.png" alt="Delete" /></a>
                                        <a href="#" title="Edit Meta"><img src="resources/images/icons/hammer_screwdriver.png" alt="Edit Meta" /></a>
                                    </td>
                                </tr>

                            <?php } ?>
                        <?php
                        }
                        ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="9">
                                <div class="bulk-actions align-left">
                                    <select name="dropdown">
                                        <option value="option1">Choose an action...</option>
                                        <option value="option2">Edit</option>
                                        <option value="option3">Delete</option>
                                    </select>
                                    <a class="button" href="#">Apply to selected</a>
                                </div>
                                <?php
                                $sql = "SELECT COUNT(*) FROM products";
                                $result = $conn->query($sql);
                                $row = mysqli_fetch_row($result);
                                $total_row = $row[0];
                                $total_page = ceil($total_row / $row_page);
                                $pagelink = "";
                                $prev = "";
                                $next = "";
                                if ($page > 1) {
                                    $prev = "<a href='products.php?page=" . ($page - 1) . "' title='Previous Page'>&laquo; Previous</a>";
                                }
                                for ($i = 1; $i <= $total_page; $i++) {
                                    if ($i == $page) {
                                        $pagelink .= "<a class='active' href='products.php?page=" . $i . "'>" . $i . "</a>";
                                    } else {
                                        $pagelink .= "<a href='products.php?page=" . $i . "'>" . $i . "</a>";
                                    }
                                };
                                if ($page < $total_page) {
                                    $next = "<a href='products.php?page=" . ($page + 1) . "'>  Next  &raquo; </a>";
                                }

                                ?>

                                <div class="pagination">
                                    <a href="products.php?page=1" title="First Page">&laquo; First</a>
                                    <?php echo $prev;
                                    echo $pagelink;
                                    echo $next; ?>
                                    <!-- <a href="#" title="Next Page">Next &raquo;</a> -->
                                    <a href="products.php?page=<?php echo $total_page; ?>" title="Last Page">Last &raquo;</a>
                                </div> <!-- End .pagination -->
                                <div class="clear"></div>
                            </td>
                        </tr>
                    </tfoot>

                </table>

            </div> <!-- End #tab1 -->

            <div class="tab-content <?php if ($x == 1) : ?>default-tab <?php endif; ?>" id="tab2">

                <form action="products.php" method="post">

                    <fieldset>
                        <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->

                        <input type="hidden" id="id" name="id" value="<?php echo $_GET['id']; ?>" />
                        <p>
                            <label>Name</label>
                            <input class="text-input medium-input" type="text" id="name" name="name" value="<?php echo $name; ?>" />
                        </p>
                        <p>
                            <label>Price</label>
                            <input class="text-input small-input" type="number" id="price" name="price" value=<?php echo $price; ?> />
                            <!--<span class="input-notification success png_bg">Successful message</span>  Classes for input-notification: success, error, information, attention -->
                            <br />
                            <!--<small>Input Product Id</small> -->
                        </p>
                        <p>
                            <label>Image</label>
                            <input class="text-input small-input" type="file" id="image" name="image" />
                            <input type="hidden" id="img" name="img" value="<?php echo $_GET['img']; ?>" />
                            <!--<span class="input-notification success png_bg">Successful message</span>  Classes for input-notification: success, error, information, attention -->
                            <br />
                            <!--<small>Input Product Id</small> -->
                        </p>
                        <p>
                            <label>Category</label>
                            <select name="category" class="small-input">
                                <option value="men" <?php if ($cat == "men") : ?>selected<?php endif; ?>>Men</option>
                                <option value="women" <?php if ($cat == "women") : ?>selected<?php endif; ?>>Women</option>
                                <option value="kid" <?php if ($cat == "kid") : ?>selected<?php endif; ?>>Kid</option>
                                <option value="electronics" <?php if ($cat == "electronics") : ?>selected<?php endif; ?>>Electronics</option>
                                <option value="sports" <?php if ($cat == "sports") : ?>selected<?php endif; ?>>Sports</option>
                            </select>
                        </p>
                        <p>
                            <label>Tags</label>
                            <input type="checkbox" name="check[]" value="fashion" <?php if (in_array("fashion", $tag_arr)) : ?> checked<?php endif; ?> /> Fashion
                            <input type="checkbox" name="check[]" value="ecommerce" <?php if (in_array("ecommerce", $tag_arr)) : ?> checked<?php endif; ?> /> Ecommerce
                            <input type="checkbox" name="check[]" value="shop" <?php if (in_array("shop", $tag_arr)) : ?> checked<?php endif; ?> /> Shop
                            <input type="checkbox" name="check[]" value="handbag" <?php if (in_array("handbag", $tag_arr)) : ?> checked<?php endif; ?> />Handbag
                            <input type="checkbox" name="check[]" value="laptop" <?php if (in_array("laptop", $tag_arr)) : ?> checked<?php endif; ?> /> Laptop
                            <input type="checkbox" name="check[]" value="headphones" <?php if (in_array("headphones", $tag_arr)) : ?> checked<?php endif; ?> />Headphones
                        </p>
                        <p>
                            <label>Description</label>
                            <textarea class="text-input textarea wysiwyg" id="textarea" name="description" cols="79" rows="15"><?php echo $des; ?></textarea>
                        </p>
                        <p>
                            <input class="button" type="submit" value="<?php echo $value; ?>" name="<?php echo $name1; ?>" />
                        </p>

                    </fieldset>

                    <div class="clear"></div><!-- End .clear -->

                </form>

            </div> <!-- End #tab2 -->

        </div> <!-- End .content-box-content -->

    </div> <!-- End .content-box -->

    <div class="clear"></div>


    <!-- Start Notifications -->
    <!--
	<div class="notification attention png_bg">
		<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
		<div>
			Attention notification. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vulputate, sapien quis fermentum luctus, libero.
		</div>
	</div>

	<div class="notification information png_bg">
		<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
		<div>
			Information notification. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vulputate, sapien quis fermentum luctus, libero.
		</div>
	</div>

	<div class="notification success png_bg">
		<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
		<div>
			Success notification. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vulputate, sapien quis fermentum luctus, libero.
		</div>
	</div>

	<div class="notification error png_bg">
		<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
		<div>
			Error notification. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vulputate, sapien quis fermentum luctus, libero.
		</div>
	</div> -->

    <!-- End Notifications -->

    <?php include('footer.php'); ?>