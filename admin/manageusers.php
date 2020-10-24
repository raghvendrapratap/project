<?php include('header.php'); ?>
<?php include('sidebar.php'); ?>
<?php
$name1 = "submit";
$value = "submit";
$x = 0;
$name = "";
$email = "";
$pass = "";
$address = "";
include('config.php');

if (isset($_GET['id'])) {

    if ($_GET['action'] == 'delete') {
        $id = $_GET['id'];
        $sql = "DELETE from user WHERE id = $id";
        $result = $conn->query($sql);
    }

    if ($_GET['action'] == 'edit') {
        $x = 1;
        $id = $_GET['id'];
        $name = $_GET['name'];
        $email = $_GET['email'];
        $pass = $_GET['pass'];
        $address = $_GET['address'];
        $name1 = "update";
        $value = "update";
    }
}

if (isset($_POST['update'])) {

    $id = $_POST['id'];
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $pass = isset($_POST['pass']) ? $_POST['pass'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $sql = "UPDATE user SET name = '$name', email= '$email', pass='$pass', address='$address' WHERE id = $id;";
    $result = $conn->query($sql);
    $success = "User updation successfull !";
}


if (isset($_POST['submit'])) {

    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $pass = isset($_POST['pass']) ? $_POST['pass'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';

    if (isset($_POST['name'], $_POST['email'], $_POST['pass'])) {
        $sql = "SELECT * from user WHERE name= '$name' OR email= '$email' ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $error = "Username or Email already exist !";
            $x = 1;
        } else {
            $sql = "INSERT INTO user (name, email, pass,address) VALUES('$name','$email','$pass','$address')";
            $result = $conn->query($sql);
            $success = "User added successfully !";
        }
    }
}

?>

<div id="main-content">
    <!-- Main Content Section with everything -->

    <noscript>
        <!-- Show a notification if the user has disabled javascript -->
        <div class="notification success png_bg">
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

            <h3>Users</h3>

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
                            <th>Email</th>
                            <th>Password</th>
                            <th>Address</th>
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
                        $sql = "SELECT * FROM user LIMIT $start, $row_page";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><input type="checkbox" /></td>
                                    <td><?php echo $row["id"]; ?></td>
                                    <td><?php echo $row["name"]; ?></td>
                                    <td><?php echo $row["email"]; ?></td>
                                    <td><?php echo $row["pass"]; ?></td>
                                    <td><?php echo $row["address"]; ?></td>
                                    <td>
                                        <!-- Icons -->
                                        <a href="manageusers.php?id=<?php echo $row["id"]; ?>&name=<?php echo $row["name"]; ?>&email=<?php echo $row["email"]; ?>&pass=<?php echo $row["pass"]; ?>&address=<?php echo $row["address"]; ?>&action=edit" title="Edit"><img src="resources/images/icons/pencil.png" alt="Edit" /></a>
                                        <a href="manageusers.php?id=<?php echo $row["id"]; ?>&action=delete" title="Delete"><img src="resources/images/icons/cross.png" alt="Delete" /></a>
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
                            <td colspan="7">
                                <div class="bulk-actions align-left">
                                    <select name="dropdown">
                                        <option value="option1">Choose an action...</option>
                                        <option value="option2">Edit</option>
                                        <option value="option3">Delete</option>
                                    </select>
                                    <a class="button" href="#">Apply to selected</a>
                                </div>

                                <?php
                                $sql = "SELECT COUNT(*) FROM user";
                                $result = $conn->query($sql);
                                $row = mysqli_fetch_row($result);
                                $total_row = $row[0];
                                $total_page = ceil($total_row / $row_page);
                                $pagelink = "";
                                $prev = "";
                                $next = "";
                                if ($page > 1) {
                                    $prev = "<a href='manageusers.php?page=" . ($page - 1) . "' title='Previous Page'>&laquo; Previous</a>";
                                }
                                for ($i = 1; $i <= $total_page; $i++) {
                                    if ($i == $page) {
                                        $pagelink .= "<a class='active' href='manageusers.php?page=" . $i . "'>" . $i . "</a>";
                                    } else {
                                        $pagelink .= "<a href='manageusers.php?page=" . $i . "'>" . $i . "</a>";
                                    }
                                };
                                if ($page < $total_page) {
                                    $next = "<a href='manageusers.php?page=" . ($page + 1) . "'>  Next  &raquo; </a>";
                                }

                                ?>

                                <div class="pagination">
                                    <a href="manageusers.php?page=1" title="First Page">&laquo; First</a>
                                    <?php echo $prev;
                                    echo $pagelink;
                                    echo $next; ?>
                                    <!-- <a href="#" title="Next Page">Next &raquo;</a> -->
                                    <a href="manageusers.php?page=<?php echo $total_page; ?>" title="Last Page">Last &raquo;</a>
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

                <form action="manageusers.php" method="post">

                    <fieldset>
                        <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->

                        <input type="hidden" id="id" name="id" value="<?php if (isset($id)) {
                                                                            echo $id;
                                                                        }; ?>" />
                        <p>
                            <label>Name</label>
                            <input class="text-input medium-input" type="text" id="name" name="name" value="<?php echo $name; ?>" required />
                            <span class='input-notification success png_bg ' id="namesuccess">Valid Username</span>
                            <span class='input-notification error png_bg ' id="nameerror">Username already exist!</span>
                            <br />
                        </p>
                        <p>
                            <label>Email</label>
                            <input class="text-input small-input" type="email" id="email" name="email" value="<?php echo $email; ?>" required />
                            <span class='input-notification success png_bg ' id="emailsuccess">Valid Email</span>
                            <span class='input-notification error png_bg ' id="emailerror">Email already exist!</span>
                            <br />

                        </p>
                        <p>
                            <label>Password</label>
                            <input class="text-input small-input" type="password" id="pass" name="pass" value="<?php echo $pass; ?>" required />
                            <br />

                        </p>
                        <p>
                            <label>Address</label>
                            <input class="text-input large-input" type="text" id="address" name="address" value="<?php echo $address; ?>" />
                            <br />
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
            $('#emailsuccess').hide();
            $('#emailerror').hide();
            var name1 = $("#name").val();
            var email1 = $("#email").val();

            $('#name').keyup(function() {
                var name = $("#name").val();
                var action = $('#submit').val();
                $.ajax({
                    method: "POST",
                    url: "user-ajax.php",
                    data: {
                        name: name,
                        action: action,
                        name1: name1
                    },
                    // dataType: "text"
                }).done(function(msg) {
                    if (msg == "validName") {
                        $('#namesuccess').show();
                        $('#nameerror').hide();
                    } else if (msg == "invalidName") {
                        $('#namesuccess').hide();
                        $('#nameerror').show();
                    }
                })
            });

            $('#email').keyup(function() {
                var email = $("#email").val();
                var action = $('#submit').val();

                $.ajax({
                    method: "POST",
                    url: "ajax.php",
                    data: {
                        email: email,
                        action: action,
                        email1: email1
                    },
                    // dataType: "text"
                }).done(function(msg) {
                    if (msg == "validEmail") {
                        $('#emailsuccess').show();
                        $('#emailerror').hide();
                    } else if (msg == "invalidEmail") {
                        $('#emailsuccess').hide();
                        $('#emailerror').show();
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