<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý blog</title>
    <link rel="stylesheet" href="../../../public/css/Admin/blog_management.css">
    <link rel="stylesheet" href="../../../public/css/navbar.css">
    <link rel="stylesheet" href="../../../public/css/sidebar.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <?php
        include_once "../../Controllers/adminController.php";

        $adcontroller = new AdminController();

        $filter = isset($_GET['filter']) ? $_GET['filter'] : 'Chờ Duyệt';

        $blogs = $adcontroller->getAllBlogByBlogStatus($filter);

        //Phan Trang
        $limit= 10;
        $stt = 1;
        $CountData = mysqli_num_rows($blogs);

        $countPage = ceil($CountData/$limit);

        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }

        $Start = ($page - 1) * $limit;
        $stt1 = $Start+1;

        $blogOfPage = $adcontroller->getBlogOfPage($Start,$limit,$filter);
    ?>

    <?php
        include_once "../../Controllers/bothController.php";
        
            $bothcontroller = new bothController();
            $provinces = $bothcontroller->getAllProvinces();
    ?>
</head>
<body>
    <script src="../../../public/js/Admin/blog_management.js"></script>
    <script src="../../../include/navbar.js"></script>
    <script src="../../../include/sidebar.js"></script>
    <script src="../../../public/js/Admin/Notifications.js"></script>

    <div class="main-content">
        <div class="blog-management">
        <div class="filter-search-container">
            <div class="filter-container">
            <form id="form_loc" name="form_loc" method="get">
                    <!-- <label for="filter">Trạng Thái: </label> -->
                    <select name="filter" id="filter" onchange="form_loc.submit()">
                        <option value="Chờ Duyệt" <?php if(isset($_GET['filter']) && $_GET['filter'] == 'Chờ Duyệt')  echo 'selected="selected"';?>>Chờ Duyệt</option>
                        <option value="Không Được Duyệt" <?php if(isset($_GET['filter']) && $_GET['filter'] == 'Không Được Duyệt')  echo 'selected="selected"';?>>Không Được Duyệt</option>
                        <option value="Đã Duyệt" <?php if(isset($_GET['filter']) && $_GET['filter'] == 'Đã Duyệt')  echo 'selected="selected"';?>>Đã Duyệt</option>
                    </select>
                </form>
            </div>

            <div class="search-container">
                <input type="text" placeholder="Tìm kiếm bài viết" class="search-bar" oninput="toggleIcon()">
                <ion-icon name="search-outline" class="search-icon"></ion-icon>
            </div>
        </div>

    
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th class="center-heading">STT</th>
                            <th class="center-heading">Nội dung</th>
                            <th class="center-heading">Tỉnh</th>
                            <th class="center-heading">Tác giả</th>
                            <th class="center-heading">Ngày tạo</th>
                            <th class="center-heading">Trạng Thái</th>
                        </tr>
                    </thead>
                    <tbody id="blog-list">
                    <?php
                        if (mysqli_num_rows($blogOfPage) > 0) {
                            while ($blog = mysqli_fetch_array($blogOfPage)) {
                        ?>
                        <tr>
                            <td><?php echo $stt1++; $stt++ ?></td>
                            <td><?php echo $blog['blogContent'] ?? 'Lỗi Hiển Thị' ?></td>
                            <td><?php echo $blog['provinceName'] ?? 'Lỗi Hiển Thị' ?></td>
                            <td><?php echo $blog['userName'] ?? 'Lỗi Hiển Thị' ?></td>
                            <td><?php echo $blog['blogCreateDate'] ?? 'Lỗi Hiển Thị' ?></td>
                            <td>
                            <form action="../../FunctionOfActor/admin/updateapprovalStatus.php" method="POST" name="updateBlog_<?php echo $blog['blogID'] ?>" id="updateBlog_<?php echo $blog['blogID'] ?>">
                                <input type="hidden" id="blogID" name="blogID" value="<?php echo $blog['blogID'] ?>">
                                <select name="update" id="update" onchange="document.getElementById('updateBlog_<?php echo $blog['blogID'] ?>').submit()">
                                    <option style="padding: 10px; border-radius: 3px;" value="Chờ Duyệt" <?php if($blog['approvalStatus'] == 'Chờ Duyệt')  echo 'selected="selected"';?>>Chờ Duyệt</option>
                                    <option value="Không Được Duyệt" <?php if($blog['approvalStatus'] == 'Không Được Duyệt')  echo 'selected="selected"';?>>Không Được Duyệt</option>
                                    <option value="Đã Duyệt" <?php if($blog['approvalStatus'] == 'Đã Duyệt') echo 'selected="selected"';?>>Đã Duyệt</option>
                                </select>
                            </form>
                            </td>
                        </tr>
                        <?php
                        }
                    }
                else{
                    echo "Không Lấy được dữ liệu";
                }
                ?>
                    </tbody>
                </table>
                <div class="pagination">
                    <?php
                        for ($i = 1; $i <= $countPage; $i++) {
                            $activeClass = ($i == $page) ? 'active' : '';
                            echo "<a class='page-btn $activeClass' href='?page=$i'>$i</a>";
                        }
                    ?>
                </div>
            </div>
        </section>
    </div>    
</body>
</html>
    