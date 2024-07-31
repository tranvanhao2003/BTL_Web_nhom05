<?php
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HUMG</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/include.css">
    <script src="https://kit.fontawesome.com/97f11440fd.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include "../includes/header.php"; ?>
    <?php include "../config.php"; ?>

    <!-- <div class="slideshow-container">

        <div class="mySlides fade">
            <div class="numbertext">1 / 3</div>
            <img src="../public/img/img1.jpg" style="width:100%">
        </div>

        <div class="mySlides fade">
            <div class="numbertext">2 / 3</div>
            <img src="../public/img/img2.png" style="width:100%">
            <div class="text">Caption Two</div>
        </div>

        <div class="mySlides fade">
            <div class="numbertext">3 / 3</div>
            <img src="../public/img/img3.png" style="width:100%">
            <div class="text">Caption Three</div>
        </div>

        <a class="prev" onclick="plusSlides(-1)">❮</a>
        <a class="next" onclick="plusSlides(1)">❯</a>

    </div>
    <br>
    <div style="text-align:center">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
    </div>
    <div class="nav grid wide">
        <img id="boder" src="https://humg.edu.vn/content/quangcao/AnhQuangCao/WebDangbo-v4.png" alt="">
        <img id="boder" src="https://humg.edu.vn/content/quangcao/AnhQuangCao/Bo%20phan%20mot%20cua.png" alt="">
        <img id="boder" src="https://humg.edu.vn/content/quangcao/AnhQuangCao/Eoffice_v4.png" alt="">
        <img id="boder" src="https://humg.edu.vn/content/quangcao/AnhQuangCao/Thudientu_v4.png" alt="">
        <img id="boder" src="https://humg.edu.vn/content/quangcao/AnhQuangCao/Lichtiepcongdan_v4.png" alt="">
        <img id="boder" src="https://humg.edu.vn/content/quangcao/AnhQuangCao/tapchi.png" alt="">
    </div>
    <div class="split"></div> -->

    <?php
    // Fetch posts by category
    function fetchPosts($category) {
        global $conn;
        $stmt = $conn->prepare("SELECT id, title, short_description, img FROM blog WHERE category = ?");
        $stmt->bind_param("s", $category);
        $stmt->execute();
        return $stmt->get_result();
    }

    $newsPosts = fetchPosts('news');
    $infoPosts = fetchPosts('information');
    $eventPosts = fetchPosts('event');
    ?>

    <!------------------- News ----------------------->
    <section class="body__container">
        <div class="title"><a href="#">Tin tức</a></div>
        <hr>
        <ul class="ul__list">
            <?php while ($post = $newsPosts->fetch_assoc()) { ?>
            <li class="list">
                <a href="post_detail.php?id=<?php echo $post['id']; ?>">
                    <img src="<?php echo $post['img']; ?>" alt="<?php echo $post['title']; ?>">
                </a>
                <div>
                    <p><a href="post_detail.php?id=<?php echo $post['id']; ?>"
                            style="font-weight: 700;"><?php echo $post['title']; ?></a></p>
                    <ul>
                        <li><?php echo $post['short_description']; ?></li>
                    </ul>
                </div>
            </li>
            <?php } ?>
        </ul>
    </section>

    <!------------------- Information ----------------------->
    <section class="body__container">
        <div class="title"><a href="#">Thông tin tuyển sinh</a></div>
        <hr>
        <ul class="ul__list">
            <?php while ($post = $infoPosts->fetch_assoc()) { ?>
            <li class="list">
                <a href="post_detail.php?id=<?php echo $post['id']; ?>">
                    <img src="<?php echo $post['img']; ?>" alt="<?php echo $post['title']; ?>">
                </a>
                <div>
                    <p><a href="post_detail.php?id=<?php echo $post['id']; ?>"
                            style="font-weight: 700;"><?php echo $post['title']; ?></a></p>
                </div>
            </li>
            <?php } ?>
        </ul>
    </section>

    <!------------------- Event ----------------------->
    <section class="body__container">
        <div class="title"><a href="#">Hoạt động sinh viên</a></div>
        <hr>
        <ul class="ul__list">
            <?php while ($post = $eventPosts->fetch_assoc()) { ?>
            <li class="list">
                <a href="post_detail.php?id=<?php echo $post['id']; ?>">
                    <img src="<?php echo $post['img']; ?>" alt="<?php echo $post['title']; ?>">
                </a>
                <div>
                    <p><a href="post_detail.php?id=<?php echo $post['id']; ?>"
                            style="font-weight: 700;"><?php echo $post['title']; ?></a></p>
                </div>
            </li>
            <?php } ?>
        </ul>
    </section>

    <?php include "../includes/footer.php"; ?>

    <script>
    let slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        let i;
        let slides = document.getElementsByClassName("mySlides");
        let dots = document.getElementsByClassName("dot");
        if (n > slides.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " active";
    }
    </script>
</body>

</html>