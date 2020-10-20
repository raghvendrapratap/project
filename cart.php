<?php
include('admin/config.php');

if (isset($_GET['id']) && isset($_GET['action'])) {

  if ($_GET['action'] == 'remove') {
    $id = $_GET['id'];
    $sql = "DELETE from cart WHERE id='$id'";
    $result = $conn->query($sql);
  }
}

$x = 0;
if (isset($_GET['update'])) {

  $quant = $_GET['quant'];

  foreach ($quant as $key => $val) {
    $id = $key;
    $quantity = $val;
    $sql = "UPDATE cart SET quantity =$quantity WHERE id = $id;";
    $result = $conn->query($sql);
  }
}
?>

<?php include('header.php'); ?>
<!-- catg header banner section -->
<section id="aa-catg-head-banner">
  <img src="img/fashion/fashion-header-bg-8.jpg" alt="fashion img">
  <div class="aa-catg-head-banner-area">
    <div class="container">
      <div class="aa-catg-head-banner-content">
        <h2>Cart Page</h2>
        <ol class="breadcrumb">
          <li><a href="index.html">Home</a></li>
          <li class="active">Cart</li>
        </ol>
      </div>
    </div>
  </div>
</section>
<!-- / catg header banner section -->

<!-- Cart view section -->
<section id="cart-view">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="cart-view-area">
          <div class="cart-view-table">
            <form action="" method="GET">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th></th>
                      <th></th>
                      <th>Product</th>
                      <th>Price</th>
                      <th>Quantity</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php
                    $totalprice = 0;
                    $sql = "SELECT * FROM cart ";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                    ?>

                        <tr>
                          <td><a class="remove" href="cart.php?id=<?php echo $row['id']; ?>&action=remove">
                              <fa class="fa fa-close"></fa>
                            </a></td>
                          <td><a href="#"><img src="admin/resources/pimages/<?php echo $row['image']; ?>" alt="img"></a></td>
                          <td><a class="aa-cart-title" href="#"><?php echo $row['name']; ?></a></td>
                          <td>$<?php echo $row['price']; ?></td>
                          <td><input class="aa-cart-quantity" type="number" name="quant[<?php echo $row['id']; ?>]" value="<?php echo $row['quantity']; ?>"></td>
                          <td>$<?php $total = $row['price'] * $row['quantity'];
                                $totalprice += $total;
                                echo $total; ?></td>
                        </tr>

                      <?php } ?>
                    <?php } ?>

                    <tr>
                      <td colspan="6" class="aa-cart-view-bottom">
                        <div class="aa-cart-coupon">
                          <input class="aa-coupon-code" type="text" placeholder="Coupon">
                          <input class="aa-cart-view-btn" type="submit" value="Apply Coupon">
                        </div>
                        <input class="aa-cart-view-btn" type="submit" name="update" value="update" />
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </form>
            <!-- Cart Total view -->
            <div class="cart-view-total">
              <h4>Cart Totals</h4>
              <table class="aa-totals-table">
                <tbody>
                  <tr>
                    <th>Subtotal</th>
                    <td>$ <?php echo $totalprice ?></td>
                  </tr>
                  <tr>
                    <th>Total</th>
                    <td>$<?php echo $totalprice ?></td>
                  </tr>
                </tbody>
              </table>
              <a href="checkout.php" class="aa-cart-view-btn">Proced to Checkout</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- / Cart view section -->
<?php include('footer.php'); ?>