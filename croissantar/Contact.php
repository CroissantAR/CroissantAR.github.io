<!DOCTYPE html>
<html dir="rtl">
<head>
    <title>كروسان الرضوان- الصفحة الرئيسية</title>
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
        <div class="row">
            <div class="col-md-6">
                <h2>اتصل بنا</h2>
                <form>
                    <div class="mb-3">
                        <label for="nameInput" class="form-label">الاسم:</label>
                        <input type="text" class="form-control" id="nameInput" placeholder="أدخل اسمك">
                    </div>
                    <div class="mb-3">
                        <label for="emailInput" class="form-label">البريد الإلكتروني:</label>
                        <input type="email" class="form-control" id="emailInput" placeholder="أدخل بريدك الإلكتروني">
                    </div>
                    <div class="mb-3">
                        <label for="messageInput" class="form-label">الرسالة:</label>
                        <textarea class="form-control" id="messageInput" rows="4" placeholder="أدخل رسالتك"></textarea>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- Bootstrap Footer -->
<footer class="bg-dark text-white mt-4 py-3">
    <div class="container text-center">
        <p>&copy; <?php echo date("Y"); ?> كروسان الرضوان - برج حمود، النبعة</p>
    </div>
</footer>
</body>
</html>
