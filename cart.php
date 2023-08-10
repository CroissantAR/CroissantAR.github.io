<?php
session_start(); // Ensure session is started
// Check if $_SESSION['cart'] is set, if not, initialize it with an empty array
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
$total=0;
?>
<!DOCTYPE html>
<html dir="rtl">
<head>
    <title>كروسان الرضوان-الطلبية</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
   <!-- Bootstrap Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">كروسان الرضوان</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="gallery.php">المنتوجات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">الإتصال بنا</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- JavaScript/jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
			// Function to send the order to WhatsApp using AJAX
	function sendOrderToWhatsApp(address) {
    const cartString = '<?php echo json_encode($_SESSION['cart']); ?>';
	    const cart = JSON.parse(cartString);

    //const message = "الطلبية" + cart + "العنوان " + address;
	let message = "الطلبية:\n";

    // Iterate through the cart items and add item name and quantity to the message
    for (const itemId in cart) {
        if (cart.hasOwnProperty(itemId)) {
            const item = cart[itemId];
            message += `${item.name}: ${item.quantity}\n`;
        }
    }
	message += `العنوان: ${address}`;
	
    const whatsappNumber = "96170489191"; // Replace with your WhatsApp number

    // Create a WhatsApp API link with the message
    const whatsappLink = "https://api.whatsapp.com/send?phone=" + whatsappNumber + "&text=" + encodeURIComponent(message);

    // Open WhatsApp in a new tab
    window.open(whatsappLink, '_blank');
	            alert("Order with address: " + address + " sent to WhatsApp.");
				sessionStorage.clear();
}
        // Function to send the edited cart to the server using AJAX
        function updateCart(itemId, newQuantity) {
            $.ajax({
                url: "update_cart.php",
                method: "POST",
                data: { itemId: itemId, newQuantity: newQuantity },
                success: function (response) {
                    // Update the cart in the session on the server side if needed
                    console.log(response); // You can display a success message or handle the response data as required.
					location.reload();
                },
                error: function () {
                    alert("لم يتم التحديث");
                }
            });
        }
        // Event listener for "Update Cart" button

        function showAddressPopup() {
            $("#addressModal").modal("show");
        }
		
		$(document).on("change", ".cart-quantity", function () {
            const itemId = $(this).data("item-id");
            const newQuantity = parseInt($(this).val());
            updateCart(itemId, newQuantity);
        });
		
		$(document).ready(function () {
            $("#checkoutBtn").click(function () {
                showAddressPopup();
            });

            // Event listener for "Send Order Request" button in address modal
            $("#sendOrderRequest").click(function () {
                const address = $("#addressInput").val();
                if (address.trim() !== "") {
                    sendOrderToWhatsApp(address);
                    $("#addressModal").modal("hide");
                } else {
                    alert("الرجاء إدخل العنوان");
                }
            });
			$("#updateCartBtn").click(function () {
            //Get the updated cart data from the input fields
            const updatedCart = [];
            $(".cart-quantity").each(function () {
                const itemId = $(this).data("item-id");
                const quantity = parseInt($(this).val());
                if (quantity > 0) {
                    updatedCart.push({ itemid: itemId, quantity: quantity });
                }
            });

            // Send the edited cart to the server
            updateCart(updatedCart);
        });
        });
    </script>
<!-- Bootstrap Modal (Address) -->
    <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addressModalLabel">إدخال العنوان</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="addressInput">العنوان:</label>
                    <input type="text" id="addressInput" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="button" class="btn btn-primary" id="sendOrderRequest">إرسال الطلب</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Your cart content -->
    <h2>الطلبية</h2>
    <table>
        <tr>
            <th>المنتج</th>
            <th>الكمية</th>
			<th>السعر الإجمالي</th>
        </tr>
        <?php
        // Assuming you have a session variable $_SESSION['cart'] that holds cart items
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        foreach ($cart as $key => $item) {
			$price=$item['price']*$item['quantity'];
			$total=$total+$price;
            echo '<tr>';
            echo '<td>' . $item['name'] . '</td>';
            echo '<td><input type="number" class="cart-quantity" value="' . $item['quantity'] . '" data-item-id="' . $key . '"></td>';
			echo '<td>' . $price . '</td>';
            echo '</tr>';
        }
		echo     '<h2>السعر الإجمالي :</h2>' .$total.' ل.ل.'
        ?>
    </table>
    <button id="checkoutBtn">إرسال الطلبية</button>
</body>
</html>
