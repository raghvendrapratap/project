<div id="sidebar">
    <div id="sidebar-wrapper">
        <?php $filename = basename($_SERVER['REQUEST_URI']);
        $file = explode('?', $filename);
        $productmenu = array('products.php', 'categories.php', 'tags.php');
        $usermenu = array('users.php', 'manageusers.php');
        $ordermenu = array('manageorders.php');
        $settingmenu = array('setting.php');

        ?>
        <!-- Sidebar with logo and menu -->

        <h1 id="sidebar-title"><a href="#">Simpla Admin</a></h1>

        <!-- Logo (221px wide) -->
        <a href="#"><img id="logo" src="resources/images/logo.png" alt="Simpla Admin logo" /></a>

        <!-- Sidebar Profile links -->
        <div id="profile-links">
            Hello, <a href="#" title="Edit your profile">John Doe</a>, you have <a href="#messages" rel="modal" title="3 Messages">3 Messages</a><br />
            <br />
            <a href="#" title="View the Site">View the Site</a> | <a href="#" title="Sign Out">Sign Out</a>
        </div>

        <ul id="main-nav">
            <!-- Accordion Menu -->

            <li>
                <a href="http://www.google.com/" class="nav-top-item no-submenu">
                    <!-- Add the class "no-submenu" to menu items with no sub menu -->
                    Dashboard
                </a>
            </li>

            <li>
                <a href="#" class="nav-top-item <?php if (in_array($file[0], $productmenu)) : ?> current<?php endif; ?>">
                    <!-- Add the class "current" to current menu item -->
                    Products
                </a>
                <ul>
                    <li><a <?php if ($file[0] == 'products.php') : ?> class="current" <?php endif; ?> href="products.php">Manage Product</a></li>
                    <li><a <?php if ($file[0] == 'categories.php') : ?> class="current" <?php endif; ?> href="categories.php">Manage Categories</a></li>
                    <li><a <?php if ($file[0] == 'tags.php') : ?> class="current" <?php endif; ?> href="tags.php">Manage Tags</a></li>
                </ul>
            </li>

            <li>
                <a href="#" class="nav-top-item  <?php if (in_array($file[0], $usermenu)) : ?> current<?php endif; ?>">
                    Users
                </a>
                <ul>
                    <li><a <?php if ($file[0] == 'users.php') : ?> class="current" <?php endif; ?> href="users.php">Add User</a></li>
                    <li><a <?php if ($file[0] == 'manageusers.php') : ?> class="current" <?php endif; ?>href="manageusers.php">Manage Users</a></li>
                </ul>
            </li>

            <li>
                <a href="#" class="nav-top-item  <?php if (in_array($file[0], $ordermenu)) : ?> current<?php endif; ?>">
                    Orders
                </a>
                <ul>

                    <li><a <?php if ($file[0] == 'manageorders.php') : ?> class="current" <?php endif; ?> href="manageorders.php">Manage Orders</a></li>
                </ul>
            </li>

            <li>
                <a href="#" class="nav-top-item <?php if (in_array($file[0], $settingmenu)) : ?> current<?php endif; ?>">
                    Settings
                </a>
                <ul>
                    <li><a <?php if ($file[0] == 'setting.php') : ?> class="current" <?php endif; ?>href="setting.php">General</a></li>
                </ul>
            </li>

        </ul> <!-- End #main-nav -->

        <div id="messages" style="display: none">
            <!-- Messages are shown when a link with these attributes are clicked: href="#messages" rel="modal"  -->

            <h3>3 Messages</h3>

            <p>
                <strong>17th May 2009</strong> by Admin<br />
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus magna. Cras in mi at felis aliquet congue.
                <small><a href="#" class="remove-link" title="Remove message">Remove</a></small>
            </p>

            <p>
                <strong>2nd May 2009</strong> by Jane Doe<br />
                Ut a est eget ligula molestie gravida. Curabitur massa. Donec eleifend, libero at sagittis mollis, tellus est malesuada tellus, at luctus turpis elit sit amet quam. Vivamus pretium ornare est.
                <small><a href="#" class="remove-link" title="Remove message">Remove</a></small>
            </p>

            <p>
                <strong>25th April 2009</strong> by Admin<br />
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus magna. Cras in mi at felis aliquet congue.
                <small><a href="#" class="remove-link" title="Remove message">Remove</a></small>
            </p>

            <form action="#" method="post">

                <h4>New Message</h4>

                <fieldset>
                    <textarea class="textarea" name="textfield" cols="79" rows="5"></textarea>
                </fieldset>

                <fieldset>

                    <select name="dropdown" class="small-input">
                        <option value="option1">Send to...</option>
                        <option value="option2">Everyone</option>
                        <option value="option3">Admin</option>
                        <option value="option4">Jane Doe</option>
                    </select>

                    <input class="button" type="submit" value="Send" />

                </fieldset>

            </form>

        </div> <!-- End #messages -->

    </div>
</div> <!-- End #sidebar -->