<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/post.css">
    <link rel="stylesheet" href="../../public/css/Blogger/headerPost.css">
    <link rel="stylesheet" href="../../public/css/Blogger/footer.css">

    <title>Posts</title>
    <style>
    </style>
</head>
<body>

<!--ĐANG HARD CODE POST ID = 1-->
<?php
    include_once "../../src/Controllers/adminController.php";
    $controller = new AdminController();
    $postID = 1;
    $header = $controller->getPostProvince($postID);  //get for header picture each post
    $data = $controller->getAllPostDetail($postID); //get picture for post content
?>

    <script src = "../../include/footer.js"></script>
    <!--Get picture for each post, header-->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Data passed from PHP to JavaScript
            const provinceName = <?php echo json_encode($header['provinceName']); ?>;
            const imgPostURL = <?php echo json_encode($header['imgPostURL']); ?>;

            
            const header2 = `
            <header class="header">
                <div class="logo">
                    <img src="../../public/image/logo.png" alt="Logo">
                </div>
                <nav class="nav">
                    <a href = "blogger/home.html" ">Trang chủ</a>
                    <a href="" ">Tỉnh Thành</a>
                    <a href="blogger/storiesList.html" ">Blogs</a>
                    <a href="blogger/WriteReview.php" ">Viết Blog</a>
                </nav>
                <nav class="sub_nav">
                    <a href="createAccount.html"  class="btn-login"">Đăng ký</a>
                    <a href="login.html" class="btn-login"">Đăng nhập</a>
                </nav>
            </header>
            <section class="hero">
                <h1 style="font-family: Cursive; font-size: 100px; color: #F5F5DC">${provinceName}</h1>
                <section class="destinations">
                    <a href="#" class="article">
                        <img src="${imgPostURL}" alt="provinces">
                    </a>
                </section>
            </section>
            `;
            document.body.insertAdjacentHTML('afterbegin', header2);
    });
    </script>

    <div class="content">
        <div class="neo">
            <ul>
                <?php foreach ($data as $section): ?>
                    <li><a href="#<?php echo str_replace(' ', '', $section['sectionTitle']); ?>"><?php echo htmlspecialchars($section['sectionTitle']); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <?php if (isset($data) && !empty($data)): $order = 1;?>

         
            <?php foreach ($data as $section): ?>
            
                <a name="<?php echo str_replace(' ', '', $section['sectionTitle']); ?>"></a>
                <h1><?php echo htmlspecialchars($section['sectionTitle']); ?></h1>

                <?php if (!empty($section['imgPostDetURL'])): ?>
            
                    <figure class="anh_blog">
                        <img src="<?php echo htmlspecialchars($section['imgPostDetURL']); ?>" alt="Post Image">
                        <figcaption><?php echo htmlspecialchars("Hình " . $order); ?></figcaption>
                        <?php $order++; ?>
                    </figure>
                <?php endif; ?>

                <p><?php echo htmlspecialchars($section['sectionContent']); ?></p>

            <?php endforeach; ?>
        <?php endif; ?>
    </div>
   
</body>

</html>