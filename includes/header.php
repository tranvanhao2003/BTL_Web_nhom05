<head>
    <style>
    .user-menu {
        position: relative;
        display: inline-block;
    }

    .user-menu a {
        cursor: pointer;
    }

    .user-menu-content {
        display: none;
        position: absolute;
        background-color: white;
        min-width: 150px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .user-menu-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .user-menu-content a:hover {
        background-color: #f1f1f1;
    }

    .user-menu:hover .user-menu-content {
        display: block;
    }

    .login a {
        color: #0c4ca3;
        padding-right: 10px;
    }

    .login a:hover {
        color: #0a3b82;
    }

    .search1 input {
        padding: 5px;
        margin-right: 5px;
    }

    .search1 a {
        color: #0c4ca3;
    }
    </style>
    <script src="https://kit.fontawesome.com/97f11440fd.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <div class="header">
            <img src="../public/img/header.png" alt="Nền">
            <div class="login">
                <?php if (isset($_SESSION['username'])): ?>
                <div class="user-menu">
                    <a>
                        <i class="fa-solid fa-user i__login"></i>
                        <?= htmlspecialchars($_SESSION['username']) ?>
                    </a>
                    <div class="user-menu-content">
                        <a href="#">
                            Vai trò: <?= htmlspecialchars($_SESSION['user_role']) ?>
                        </a>
                        <a href="../view/logout.php">Đăng xuất</a>
                    </div>
                </div>
                <?php else: ?>
                <a href="../view/login.php">
                    <i class="fa-solid fa-user i__login"></i>
                    Đăng nhập
                </a>
                <?php endif; ?>
                <div class="search1">
                    <input type="search" placeholder="Tìm kiếm ...">
                    <a href="#"><i class="fa-solid fa-magnifying-glass i__search"></i></a>
                </div>
            </div>
        </div>
        <nav class="menu">
            <ul>
                <li><a href="../view/index.php"><i class="fa-solid fa-house"></i></a></li>
                <li><a href="#">Giới thiệu</a></li>
                <li><a href="#">Tuyển sinh</a></li>
                <li><a href="#">Tin tức</a></li>
                <li><a href="#">Đào tạo-ĐBCLGD</a></li>
                <li><a href="#">Khoa học-Công nghệ</a></li>
                <li><a href="#">Hợp tác-Đối ngoại</a></li>
                <li><a href="#">Sinh viên</a></li>
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                <li><a href="../view/admin.php">Admin</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

</body>

</html>