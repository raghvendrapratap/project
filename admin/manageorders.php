<?php include('header.php'); ?>
<?php include('sidebar.php'); ?>
<?php
include('config.php');

if (isset($_GET['id'])) {
    if ($_GET['action'] == 'delete') {
        $id = $_GET['id'];
        $sql = "DELETE from cart WHERE id = $id";
        $result = $conn->query($sql);
    }
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

            <h3>Orders</h3>

            <ul class="content-box-tabs">
                <li><a href="#tab1" class="default-tab">Manage</a></li> <!-- href must be unique and match the id of target div -->
            </ul>

            <div class="clear"></div>

        </div> <!-- End .content-box-header -->

        <div class="content-box-content">

            <div class="tab-content default-tab " id="tab1">
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
                            <th>Username</th>
                            <th>Product Id</th>
                            <th>Product Name</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        $totalprice = 0;
                        $row_page = 10;
                        if (isset($_GET['page'])) {
                            $page = $_GET['page'];
                        } else {
                            $page = 1;
                        }

                        $start = ($page - 1) * $row_page;
                        $sql = "SELECT * FROM cart LIMIT $start, $row_page";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><input type="checkbox" /></td>
                                    <td><?php echo $row["username"]; ?></td>
                                    <td><?php echo $row["id"]; ?></td>
                                    <td><?php echo $row["name"]; ?></td>
                                    <td><img src="resources/pimages/<?php echo $row["image"]; ?>" alt="<?php echo $row["image"]; ?>" width='84' height='100' /></img> </td>
                                    <td>$<?php echo $row["price"]; ?></td>
                                    <td><?php echo $row["quantity"]; ?></td>
                                    <td>$<?php $total = $row['price'] * $row['quantity'];
                                            $totalprice += $total;
                                            echo $total; ?></td>

                                    <td>
                                        <!-- Icons -->

                                        <a href="manageorders.php?id=<?php echo $row["id"]; ?>&action=delete" title="Delete"><img src="resources/images/icons/cross.png" alt="Delete" /></a>
                                        <a href="#" title="Edit Meta"><img src="resources/images/icons/hammer_screwdriver.png" alt="Edit Meta" /></a>
                                    </td>
                                </tr>

                            <?php } ?>
                        <?php
                        }
                        ?>
                        <tr>
                            <td colspan="7" style="text-align:center">Total amount</td>
                            <td>$<?php echo $totalprice; ?></td>
                        </tr>
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
                                $sql = "SELECT COUNT(*) FROM cart";
                                $result = $conn->query($sql);
                                $row = mysqli_fetch_row($result);
                                $total_row = $row[0];
                                $total_page = ceil($total_row / $row_page);
                                $pagelink = "";
                                $prev = "";
                                $next = "";
                                if ($page > 1) {
                                    $prev = "<a href='manageorders.php?page=" . ($page - 1) . "' title='Previous Page'>&laquo; Previous</a>";
                                }
                                for ($i = 1; $i <= $total_page; $i++) {
                                    if ($i == $page) {
                                        $pagelink .= "<a class='active' href='manageorders.php?page=" . $i . "'>" . $i . "</a>";
                                    } else {
                                        $pagelink .= "<a href='manageorders.php?page=" . $i . "'>" . $i . "</a>";
                                    }
                                };
                                if ($page < $total_page) {
                                    $next = "<a href='manageorders.php?page=" . ($page + 1) . "'>  Next  &raquo; </a>";
                                }

                                ?>

                                <div class="pagination">
                                    <a href="manageorders.php?page=1" title="First Page">&laquo; First</a>
                                    <?php echo $prev;
                                    echo $pagelink;
                                    echo $next; ?>
                                    <!-- <a href="#" title="Next Page">Next &raquo;</a> -->
                                    <a href="manageorders.php?page=<?php echo $total_page; ?>" title="Last Page">Last &raquo;</a>
                                </div> <!-- End .pagination -->
                                <div class="clear"></div>
                            </td>
                        </tr>
                    </tfoot>

                </table>

            </div> <!-- End #tab1 -->


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