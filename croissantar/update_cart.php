<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['itemId']) && isset($_POST['newQuantity'])) {
    // Get the updated cart data from the POST request
		$itemId = $_POST['itemId'];
        $quantity = (int)$_POST['newQuantity'];
		$_SESSION['cart'][$itemId]['quantity'] =$quantity;
    echo "تم تحديث السلة";
} else {
    echo "خطأ في التحديث";
}
}
?>

