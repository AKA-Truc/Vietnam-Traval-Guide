<?php
    include_once "../../Controllers/adminController.php";
    include_once "../../Controllers/authController.php";

    $auth = new AuthController();
    $auth->checkAdmin();

    $controller = new AdminController();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $destinationID = $_POST['deleteID'];
        $controller->deleteDestination($destinationID);
    }
    else{
        echo "<script>alert('Không Có Sự Kiện Submit Nào!');</script>";
        echo "<script>window.location.href = '../../Views/admin/post_management.php';</script>";
    }
?>