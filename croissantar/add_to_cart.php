<?php
// Start the PHP session
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['itemId']) && isset($_POST['quantity']) && isset($_POST['name']) && isset($_POST['price'])) {
        $itemId = $_POST['itemId'];
		$name = $_POST['name'];
        $quantity = (int)$_POST['quantity'];
		$price = (int)$_POST['price'];
        // Add the item to the cart session
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
		$cartItem = ['name' => $name, 'quantity' => $quantity , 'price' => $price];
		if(isset($_SESSION['cart'][$itemId])){
			$_SESSION['cart'][$itemId]['quantity'] +=$quantity;
		}else {
		$_SESSION['cart'][$itemId] = $cartItem;
		}
			echo "تمت إضافة المنتج الى السلة";
    } else {
        echo "خطأ في الإضافة";
    }
}
?>
