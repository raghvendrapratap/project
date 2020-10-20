<?php
$bodyclass = "product.php";
include('header.php');
include('admin/config.php');

if (isset($_GET['id'])) {

    if ($_GET['action'] == 'add') {

        $id = $_GET['id'];
        $sql = "SELECT * from cart WHERE id='$id'";
        $result1 = $conn->query($sql);
        $row1 = $result1->fetch_assoc();

        if ($row1['id'] == $id) {

            $quant = $row1['quantity'] + 1;
            $sql = "UPDATE cart SET quantity= $quant WHERE id = $id;";
            $result = $conn->query($sql);
        } else {
            $sql = "SELECT * from products WHERE id='$id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {

                $row = $result->fetch_assoc();
                $username = 'user';
                $id = $row['id'];
                $name = $row['name'];
                $price = $row['price'];
                $image = $row['image'];
                $quantity = 1;
                $sql = "INSERT INTO cart (username,id, name, price,image,quantity) VALUES('$username',$id,'$name',$price,'$image',$quantity)";
                $result = $conn->query($sql);
            }
        }
    }

    if ($_GET['action'] == 'wish') {

        $id = $_GET['id'];
        $sql = "SELECT * from products WHERE id='$id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();
            $username = 'user';
            $id = $row['id'];
            $name = $row['name'];
            $price = $row['price'];
            $image = $row['image'];
            $size = 's';
            $sql = "INSERT INTO wish (username,id, name, price,image,size) VALUES('$username',$id,'$name',$price,'$image','$size')";
            $result = $conn->query($sql);
        }
    }
}
?>


<!-- catg header banner section -->
<section id="aa-catg-head-banner">
    <img src="img/fashion/fashion-header-bg-8.jpg" alt="fashion img">
    <div class="aa-catg-head-banner-area">
        <div class="container">
            <div class="aa-catg-head-banner-content">
                <h2>Fashion</h2>
                <ol class="breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li class="active">Women</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- / catg header banner section -->

<!-- product category -->
<section id="aa-product-category">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-8 col-md-push-3">
                <div class="aa-product-catg-content">
                    <div class="aa-product-catg-head">
                        <div class="aa-product-catg-head-left">
                            <form action="" class="aa-sort-form">
                                <label for="">Sort by</label>
                                <select name="">
                                    <option value="1" selected="Default">Default</option>
                                    <option value="2">Name</option>
                                    <option value="3">Price</option>
                                    <option value="4">Date</option>
                                </select>
                            </form>
                            <form action="" class="aa-show-form">
                                <label for="">Show</label>
                                <select name="">
                                    <option value="1" selected="12">12</option>
                                    <option value="2">24</option>
                                    <option value="3">36</option>
                                </select>
                            </form>
                        </div>
                        <div class="aa-product-catg-head-right">
                            <a id="grid-catg" href="#"><span class="fa fa-th"></span></a>
                            <a id="list-catg" href="#"><span class="fa fa-list"></span></a>
                        </div>
                    </div>
                    <div class="aa-product-catg-body">
                        <ul class="aa-product-catg">

                            <?php
                            $row_page = 10;

                            if (isset($_GET['page'])) {
                                $page = $_GET['page'];
                            } else {
                                $page = 1;
                            }

                            $start = ($page - 1) * $row_page;

                            if (isset($_GET['category'])) {
                                $category = $_GET['category'];
                                $sql = "SELECT * FROM products where category='$category' LIMIT $start, $row_page";
                            } else if (isset($_GET['tags'])) {
                                $tags = $_GET['tags'];
                                $sql = "SELECT * FROM products where tags  LIKE '%{$tags}%' LIMIT $start, $row_page";
                            } else if (isset($_GET['filter'])) {
                                $min = $_GET['min'];
                                $max = $_GET['max'];
                                $sql = "SELECT * FROM products WHERE price BETWEEN $min AND $max  LIMIT $start, $row_page";
                            } else if (isset($_GET['color'])) {
                                $color = $_GET['color'];
                                $sql = "SELECT * FROM products where color  LIKE '%{$color}%' LIMIT $start, $row_page";
                            } else {
                                $sql = "SELECT * FROM products LIMIT $start, $row_page";
                            }

                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                            ?>

                                    <!-- start single product item -->
                                    <li>
                                        <figure>
                                            <a class="aa-product-img" href="product-detail.php?id=<?php echo $row['id']; ?>"><img src="admin/resources/pimages/<?php echo $row['image']; ?>" width='250' height='300' alt=" polo shirt img"></a>
                                            <a class="aa-add-card-btn" href="product.php?id=<?php echo $row['id']; ?>&action=add"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                                            <figcaption>
                                                <h4 class="aa-product-title"><a href="#"><?php echo $row['name']; ?></a></h4>
                                                <span class="aa-product-price">$<?php echo $row['price']; ?></span>
                                                <!-- <span class="aa-product-price"><del>$</del></span> -->
                                                <p class="aa-product-descrip">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Numquam accusamus facere iusto, autem soluta amet sapiente ratione inventore nesciunt a, maxime quasi consectetur, rerum illum.</p>
                                            </figcaption>
                                        </figure>
                                        <div class="aa-product-hvr-content">
                                            <a href="#" data-toggle="tooltip" data-placement="top" title="Add to Wishlist"><span class="fa fa-heart-o"></span></a>
                                            <a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><span class="fa fa-exchange"></span></a>
                                            <a href="#" data-toggle2="tooltip" data-placement="top" title="Quick View" data-toggle="modal" data-target="#quick-view-modal-<?php echo $row['id']; ?>"><span class="fa fa-search"></span></a>
                                        </div>
                                        <!-- product badge -->
                                        <!-- <span class="aa-badge aa-sale" href="#">SALE!</span>
                             <span class="aa-badge aa-sold-out" href="#">Sold Out!</span>
                              <span class="aa-badge aa-hot" href="#">HOT!</span> -->
                                    </li>

                                    <!-- quick view modal -->
                                    <div class="modal fade" id="quick-view-modal-<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <div class="row">
                                                        <!-- Modal view slider -->
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <div class="aa-product-view-slider">
                                                                <div class="simpleLens-gallery-container" id="demo-1">
                                                                    <div class="simpleLens-container">
                                                                        <div class="simpleLens-big-image-container">
                                                                            <a class="simpleLens-lens-image" data-lens-image="admin/resources/pimages/<?php echo $row['image']; ?>">
                                                                                <img src="admin/resources/pimages/<?php echo $row['image']; ?>" width='250' height='300' class="simpleLens-big-image">
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="simpleLens-thumbnails-container">
                                                                        <a href="#" class="simpleLens-thumbnail-wrapper" data-lens-image="admin/resources/pimages/<?php echo $row['image']; ?>" data-big-image="admin/resources/pimages/<?php echo $row['image']; ?>" width='250' height='300'>
                                                                            <img src="admin/resources/pimages/<?php echo $row['image']; ?>" width='50' height='70'>
                                                                        </a>
                                                                        <a href="#" class="simpleLens-thumbnail-wrapper" data-lens-image="admin/resources/pimages/<?php echo $row['image']; ?>" data-big-image="admin/resources/pimages/<?php echo $row['image']; ?>" width='250' height='300'>
                                                                            <img src="admin/resources/pimages/<?php echo $row['image']; ?>" width='50' height='70'>
                                                                        </a>

                                                                        <a href="#" class="simpleLens-thumbnail-wrapper" data-lens-image="admin/resources/pimages/<?php echo $row['image']; ?>" data-big-image="admin/resources/pimages/<?php echo $row['image']; ?>" width='250' height='300'>
                                                                            <img src="admin/resources/pimages/<?php echo $row['image']; ?>" width='50' height='70'>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Modal view content -->
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <div class="aa-product-view-content">
                                                                <h3><?php echo $row['name']; ?></h3>
                                                                <div class="aa-price-block">
                                                                    <span class="aa-product-view-price">$<?php echo $row['price']; ?></span>
                                                                    <p class="aa-product-avilability">Avilability: <span>In stock</span></p>
                                                                </div>
                                                                <p><?php echo $row['description']; ?></p>
                                                                <h4>Size</h4>
                                                                <div class="aa-prod-view-size">
                                                                    <a href="#">S</a>
                                                                    <a href="#">M</a>
                                                                    <a href="#">L</a>
                                                                    <a href="#">XL</a>
                                                                </div>
                                                                <div class="aa-prod-quantity">
                                                                    <form action="">
                                                                        <select name="" id="">
                                                                            <option value="0" selected="1">1</option>
                                                                            <option value="1">2</option>
                                                                            <option value="2">3</option>
                                                                            <option value="3">4</option>
                                                                            <option value="4">5</option>
                                                                            <option value="5">6</option>
                                                                        </select>
                                                                    </form>
                                                                    <p class="aa-prod-category">
                                                                        Category: <a href="#"><?php echo $row['category']; ?></a>
                                                                    </p>
                                                                </div>
                                                                <div class="aa-prod-view-bottom">
                                                                    <a href="product.php?id=<?php echo $row['id']; ?>&action=add" class="aa-add-to-cart-btn"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                                                                    <a href="product-detail.php?id=<?php echo $row['id']; ?>" class="aa-add-to-cart-btn">View Details</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>

                                <?php } ?>
                        </ul>
                    <?php } ?>

                    <!-- / quick view modal -->

                    </div>
                    <div class="aa-product-catg-pagination">
                        <nav>
                            <ul class="pagination">

                                <?php

                                if (isset($_GET['category'])) {
                                    $category = $_GET['category'];
                                    $sql = "SELECT COUNT(*) FROM products where category='$category' ";
                                } else if (isset($_GET['tags'])) {
                                    $tags = $_GET['tags'];
                                    $sql = "SELECT COUNT(*) FROM products where tags  LIKE '%{$tags}%' ";
                                } else if (isset($_GET['color'])) {
                                    $color = $_GET['color'];
                                    $sql = "SELECT COUNT(*) FROM products where color  LIKE '%{$color}%' ";
                                } else if (isset($_GET['filter'])) {
                                    $min = $_GET['min'];
                                    $max = $_GET['max'];
                                    $sql = "SELECT COUNT(*) FROM products WHERE price BETWEEN $min AND $max";
                                } else {
                                    $sql = "SELECT COUNT(*) FROM products ";
                                }

                                $result = $conn->query($sql);
                                $row = mysqli_fetch_row($result);
                                $total_row = $row[0];
                                $total_page = ceil($total_row / $row_page);
                                $pagelink = "";
                                $prev = "";
                                $next = "";

                                if ($page > 1) {
                                    $prevhref = "product.php?page=" . ($page - 1);
                                }
                                ?>

                                <li>
                                    <a href="<?php echo $prevhref; ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>

                                <?php

                                for ($i = 1; $i <= $total_page; $i++) {

                                    if (isset($_GET['category'])) {
                                        $x = "category=" . $_GET['category'];
                                    } else if (isset($_GET['tags'])) {
                                        $x = "tags=" . $_GET['tags'];
                                    } else if (isset($_GET['color'])) {
                                        $x = "color=" . $_GET['color'];
                                    } else if (isset($_GET['filter'])) {
                                        $x = "min=" . $_GET['min'] . "&max=" . $_GET['max'] . "&filter=price";
                                    } else {
                                        $x = "";
                                    }

                                    if ($i == $page) {

                                        $pagelink .= "<li><a href='product.php?" . $x . "&page=" . $i . "'>" . $i . "</a></li>";
                                    } else {
                                        $pagelink .= "<li><a href='product.php?" . $x . "&page=" . $i . "'>" . $i . "</a></li>";
                                    }
                                };

                                if ($page < $total_page) {
                                    $nexthref = "product.php?page=" . ($page + 1);
                                }
                                ?>

                                <?php echo $pagelink; ?>

                                <li>
                                    <a href=" <?php echo $nexthref; ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-4 col-md-pull-9">
                <aside class="aa-sidebar">
                    <!-- single sidebar -->
                    <div class="aa-sidebar-widget">
                        <h3>Category</h3>
                        <ul class="aa-catg-nav">
                            <li><a href="product.php?category=Men">Men</a></li>
                            <li><a href="product.php?category=Women">Women</a></li>
                            <li><a href="product.php?category=Kid">Kids</a></li>
                            <li><a href="product.php?category=Electronics">Electornics</a></li>
                            <li><a href="product.php?category=Sports">Sports</a></li>
                        </ul>
                    </div>
                    <!-- single sidebar -->
                    <div class="aa-sidebar-widget">
                        <h3>Tags</h3>
                        <div class="tag-cloud">
                            <a href="product.php?tags=Fashion">Fashion</a>
                            <a href="product.php?tags=Ecommerce">Ecommerce</a>
                            <a href="product.php?tags=Shop">Shop</a>
                            <a href="product.php?tags=Handbag">Hand Bag</a>
                            <a href="product.php?tags=Laptop">Laptop</a>
                            <a href="product.php?tags=Headphone">Head Phone</a>
                            <a href="product.php?tags=Pendrive">Pen Drive</a>
                        </div>
                    </div>
                    <!-- single sidebar -->
                    <div class="aa-sidebar-widget">
                        <h3>Shop By Price</h3>
                        <!-- price range -->
                        <div class="aa-sidebar-price-range">
                            <form action="product.php">
                                <div id="skipstep" class="noUi-target noUi-ltr noUi-horizontal noUi-background">
                                </div>
                                <span id="skip-value-lower" class="example-val"></span>
                                <span id="skip-value-upper" class="example-val"></span>
                                <input type="hidden" id="min-price" class="example-val" name="min" />
                                <input type="hidden" id="max-price" class="example-val" name="max" />
                                <button class="aa-filter-btn" type="submit" name="filter" value="price">Filter</button>
                            </form>
                        </div>

                    </div>
                    <!-- single sidebar -->
                    <div class="aa-sidebar-widget">
                        <h3>Shop By Color</h3>
                        <div class="aa-color-tag">
                            <a class="aa-color-green" href="product.php?color=Green"></a>
                            <a class="aa-color-yellow" href="product.php?color=Yellow"></a>
                            <a class="aa-color-pink" href="product.php?color=Pink"></a>
                            <a class="aa-color-purple" href="product.php?color=Purple"></a>
                            <a class="aa-color-blue" href="product.php?color=BLue"></a>
                            <a class="aa-color-orange" href="product.php?color=Orange"></a>
                            <a class="aa-color-gray" href="product.php?color=Gray"></a>
                            <a class="aa-color-black" href="product.php?color=Black"></a>
                            <a class="aa-color-white" href="product.php?color=White"></a>
                            <a class="aa-color-red" href="product.php?color=Red"></a>
                            <a class="aa-color-olive" href="product.php?color=Olive"></a>
                            <a class="aa-color-orchid" href="product.php?color=Orchid"></a>
                        </div>
                    </div>
                    <!-- single sidebar -->
                    <div class="aa-sidebar-widget">
                        <h3>Recently Views</h3>
                        <div class="aa-recently-views">
                            <ul>
                                <li>
                                    <a href="#" class="aa-cartbox-img"><img alt="img" src="img/woman-small-2.jpg"></a>
                                    <div class="aa-cartbox-info">
                                        <h4><a href="#">Product Name</a></h4>
                                        <p>1 x $250</p>
                                    </div>
                                </li>
                                <li>
                                    <a href="#" class="aa-cartbox-img"><img alt="img" src="img/woman-small-1.jpg"></a>
                                    <div class="aa-cartbox-info">
                                        <h4><a href="#">Product Name</a></h4>
                                        <p>1 x $250</p>
                                    </div>
                                </li>
                                <li>
                                    <a href="#" class="aa-cartbox-img"><img alt="img" src="img/woman-small-2.jpg"></a>
                                    <div class="aa-cartbox-info">
                                        <h4><a href="#">Product Name</a></h4>
                                        <p>1 x $250</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- single sidebar -->
                    <div class="aa-sidebar-widget">
                        <h3>Top Rated Products</h3>
                        <div class="aa-recently-views">
                            <ul>
                                <li>
                                    <a href="#" class="aa-cartbox-img"><img alt="img" src="img/woman-small-2.jpg"></a>
                                    <div class="aa-cartbox-info">
                                        <h4><a href="#">Product Name</a></h4>
                                        <p>1 x $250</p>
                                    </div>
                                </li>
                                <li>
                                    <a href="#" class="aa-cartbox-img"><img alt="img" src="img/woman-small-1.jpg"></a>
                                    <div class="aa-cartbox-info">
                                        <h4><a href="#">Product Name</a></h4>
                                        <p>1 x $250</p>
                                    </div>
                                </li>
                                <li>
                                    <a href="#" class="aa-cartbox-img"><img alt="img" src="img/woman-small-2.jpg"></a>
                                    <div class="aa-cartbox-info">
                                        <h4><a href="#">Product Name</a></h4>
                                        <p>1 x $250</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </aside>
            </div>

        </div>
    </div>
</section>
<!-- / product category -->

<?php include('footer.php'); ?>