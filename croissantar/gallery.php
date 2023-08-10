<?php
session_start(); // Ensure session is started

// Check if $_SESSION['cart'] is set, if not, initialize it with an empty array
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
?>

<!DOCTYPE html>
<html dir="rtl">
<head>
    <title>كروسان الرضوان-المنتجات</title>
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
					<li class="nav-item">
                        <a class="nav-link" href="cart.php">الطلبية</a>
                    </li>
                </ul>
            </div>
        </div>

    </nav>
    <!-- Main Content -->
    <div class="container mt-4">
        <h2>منتوجاتنا الطازجة</h2>
            <?php
            // Read image files from "img" directory and display them in the gallery
            $categoriesDirectory = 'img/';
			$categoryFolders = scandir($categoriesDirectory);
// List category folders

        foreach ($categoryFolders as $categoryFolder) {
            if ($categoryFolder === '.' || $categoryFolder === '..') {
                continue;
            }

            // Display category title
            echo '<h2>' . $categoryFolder . '</h2>';
            echo '<div class="row">';
            
            // Path to images within the category folder
            $categoryPath = $categoriesDirectory . $categoryFolder . '/';

            // List images in the category
            $images = scandir($categoryPath);
            foreach ($images as $image) {
                if ($image === '.' || $image === '..') {
                    continue;
                }

                // Extract item name and price from image name
				$imagetrim = pathinfo($image, PATHINFO_FILENAME);
                $imageNameParts = explode('_', $imagetrim);
				$imageId = $imageNameParts[0];
                $itemName = $imageNameParts[1];
                $itemPrice = $imageNameParts[2];

                // Display image, name, and price with an "Add to Cart" button
                echo '<div class="col-md-4">';
                echo '<div class="card mb-4">';
                echo '<img src="' . $categoryPath . $image . '" alt="' . $itemName . '">';
                //echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $itemName . ' - ' . $itemPrice . ' ل.ل. </h5>';
                echo '<button onclick="showPopup(\'' . $imageId . '\', \'' . $itemName . '\', \'' . $itemPrice . '\')">أضف إلى السلة</button>';				
               // echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            
            echo '</div>'; // Close the row
        }
        ?>
        </div>
    <!-- Popup -->
<div class="modal fade" id="addToCartModal" tabindex="-1" aria-labelledby="addToCartModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addToCartModalLabel">إضافة إلى السلة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="quantityInput">الكمية:</label>
                    <input type="number" id="quantityInput" class="form-control" min="1" value="1">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="button" class="btn btn-primary" id="addToCartBtn">أضف إلى السلة</button>
                </div>
            </div>
        </div>
    </div>
<!-- Bootstrap Footer -->
<footer class="bg-dark text-white mt-4 py-3">
    <div class="container text-center">
        <p>&copy; <?php echo date("Y"); ?> كروسان الرضوان - برج حمود، النبعة</p>
    </div>
</footer>

    <!-- JavaScript/jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>


// Function to show the popup and store selected item ID
        // Function to show the modal and store selected item ID
        function showPopup(itemId,imageName,itemPrice) {
            $("#addToCartModal").modal("show");
            $("#addToCartBtn").attr("data-item-id", itemId);
			$("#addToCartBtn").attr("data-item-name", imageName);
			$("#addToCartBtn").attr("data-item-price", itemPrice);

        }

        // Function to hide the modal
        function hidePopup() {
            $("#addToCartModal").modal("hide");
        }

        // Function to add item to cart using AJAX
        function addToCart(itemId,name,quantity,price) {
            $.ajax({
                url: "add_to_cart.php",
                method: "POST",
                data: { itemId: itemId, name: name, quantity: quantity, price: price },
                success: function (response) {
                    alert(response);
                    hidePopup();
                },
                error: function () {
                    alert("خطأ في الإضافة");
                }
            });
        }

        // Event listener for gallery item click
        $(document).ready(function () {
            $(".gallery-item").click(function () {
                const itemId = $(this).data("item-id");
                showPopup(itemId);
            });

            // Event listener for popup close button
            $("#addToCartBtn").click(function () {
                const itemId = $(this).attr("data-item-id");
                const name = $(this).attr("data-item-name");
                const quantity = $("#quantityInput").val();
				const price = $(this).attr("data-item-price");

                addToCart(itemId,name, quantity,price);
            });
        });
    </script>
</body>
</html>
