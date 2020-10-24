<?php include('header.php'); ?>
<?php include('sidebar.php');
include('config.php'); ?>

<?php

$name1 = "submit";
$value = "submit";
$x = 0;
$name = "";
if (isset($_GET['id'])) {

    if ($_GET['action'] == 'delete') {
        $id = $_GET['id'];
        $sql = "DELETE from colors WHERE id = $id";
        $result = $conn->query($sql);
        $success = "Deleted Successfully";
    }

    if ($_GET['action'] == 'edit') {
        $x = 1;
        $name = $_GET['name'];
        $name1 = "update";
        $value = "update";
    }
    // unset($_GET['id']);
}

if (isset($_POST['update'])) {

    $id = $_POST['id'];
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $sql = "UPDATE colors SET name = '$name' WHERE id = $id;";
    $result = $conn->query($sql);
    $success = "Color updation successfull !";
}


if (isset($_POST['submit'])) {

    $name = isset($_POST['name']) ? $_POST['name'] : '';

    if ($name != '') {
        $sql = "SELECT name from colors WHERE name= '$name' ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $error = "Color Name already exist !";
            $x = 1;
        } else {
            $sql = "INSERT INTO colors (name) VALUES('$name')";
            $result = $conn->query($sql);
            $success = "Color added successfully !";
        }
    } else {
        $x = 1;
        $error = "Please enter color name !";
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

            <h3>Colors</h3>

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

                <?php if (isset($success)) : ?>
                    <div class="notification success png_bg">
                        <a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
                        <div>
                            <?php echo $success; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <table>

                    <thead>
                        <tr>
                            <th><input class="check-all" type="checkbox" /></th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>

                    </thead>
                    <tbody>

                        <?php
                        $row_page = 10;
                        if (isset($_GET['page'])) {
                            $page = $_GET['page'];
                        } else {
                            $page = 1;
                        }

                        $start = ($page - 1) * $row_page;
                        $sql = "SELECT * FROM colors LIMIT $start, $row_page";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>

                                <tr>
                                    <td><input type="checkbox" /></td>
                                    <td><?php echo $row["id"]; ?></td>
                                    <td><?php echo $row["name"]; ?></td>
                                    <td>
                                        <!-- Icons -->
                                        <a href="colors.php?id=<?php echo $row["id"]; ?>&name=<?php echo $row["name"]; ?>&action=edit" title="Edit"><img src="resources/images/icons/pencil.png" alt="Edit" /></a>
                                        <a href="colors.php?id=<?php echo $row["id"]; ?>&name=<?php echo $row["name"]; ?>&action=delete" title="Delete"><img src="resources/images/icons/cross.png" alt="Delete" /></a>
                                        <a href="#" title="Edit Meta"><img src="resources/images/icons/hammer_screwdriver.png" alt="Edit Meta" /></a>
                                    </td>
                                </tr>

                            <?php } ?>
                        <?php } ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">
                                <div class="bulk-actions align-left">
                                    <select name="dropdown">
                                        <option value="option1">Choose an action...</option>
                                        <option value="option2">Edit</option>
                                        <option value="option3">Delete</option>
                                    </select>
                                    <a class="button" href="#">Apply to selected</a>
                                </div>

                                <?php
                                $sql = "SELECT COUNT(*) FROM colors";
                                $result = $conn->query($sql);
                                $row = mysqli_fetch_row($result);
                                $total_row = $row[0];
                                $total_page = ceil($total_row / $row_page);
                                $pagelink = "";
                                $prev = "";
                                $next = "";
                                if ($page > 1) {
                                    $prev = "<a href='colors.php?page=" . ($page - 1) . "' title='Previous Page'>&laquo; Previous</a>";
                                }
                                for ($i = 1; $i <= $total_page; $i++) {
                                    if ($i == $page) {
                                        $pagelink .= "<a class='active' href='colors.php?page=" . $i . "'>" . $i . "</a>";
                                    } else {
                                        $pagelink .= "<a href='colors.php?page=" . $i . "'>" . $i . "</a>";
                                    }
                                };
                                if ($page < $total_page) {
                                    $next = "<a href='colors.php?page=" . ($page + 1) . "'>  Next  &raquo; </a>";
                                }
                                ?>

                                <div class="pagination">
                                    <a href="colors.php?page=1" title="First Page">&laquo; First</a>
                                    <?php echo $prev;
                                    echo $pagelink;
                                    echo $next; ?>
                                    <!-- <a href="#" title="Next Page">Next &raquo;</a> -->
                                    <a href="colors.php?page=<?php echo $total_page; ?>" title="Last Page">Last &raquo;</a>
                                </div> <!-- End .pagination -->
                                <div class="clear"></div>
                            </td>
                        </tr>
                    </tfoot>

                </table>

            </div> <!-- End #tab1 -->

            <div class="tab-content <?php if ($x == 1) : ?>default-tab <?php endif; ?>" id="tab2">

                <?php if (isset($error)) : ?>
                    <div class="notification attention png_bg">
                        <a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
                        <div>
                            <?php echo $error; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <form action="colors.php" method="post">

                    <fieldset>
                        <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->



                        <p> <input type="hidden" id="id" name="id" value="<?php echo $_GET['id']; ?>" />
                            <label>Name</label>
                            <input class="text-input medium-input" type="text" id="name" name="name" value="<?php echo $name; ?>" />
                            <span class='input-notification success png_bg ' id="namesuccess">Valid Color Name</span>
                            <span class='input-notification error png_bg ' id="nameerror">Color Name already exist!</span>
                        </p>


                        <p>
                            <input class="button" type="submit" id="submit" value="<?php echo $value; ?>" name="<?php echo $name1; ?>" />
                        </p>

                    </fieldset>

                    <div class="clear"></div><!-- End .clear -->

                </form>

            </div> <!-- End #tab2 -->

        </div> <!-- End .content-box-content -->

    </div> <!-- End .content-box -->

    <div class="clear"></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#namesuccess').hide();
            $('#nameerror').hide();
            var name1 = $("#name").val();

            $('#name').keyup(function() {
                var name = $("#name").val();
                var action = $('#submit').val();
                $.ajax({
                    method: "POST",
                    url: "color-ajax.php",
                    data: {
                        name: name,
                        action: action,
                        name1: name1
                    },
                    // dataType: "text"
                }).done(function(msg) {
                    // console.log(msg);
                    if (msg == "validName") {
                        $('#namesuccess').show();
                        $('#nameerror').hide();
                    } else if (msg == "invalidName") {
                        $('#namesuccess').hide();
                        $('#nameerror').show();
                    }
                })
            });
        })
    </script>

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