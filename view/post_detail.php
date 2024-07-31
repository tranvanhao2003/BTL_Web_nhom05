<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết bài viết</title>
    <link rel="stylesheet" href="../public/css/include2.css">
    <link rel="stylesheet" href="../public/css/post_detail.css">
</head>

<body>
    <?php include "../includes/header.php"; ?>
    <?php include "../config.php"; ?>

    <?php
    if (isset($_GET['id'])) {
        $postId = $_GET['id'];

        // Prepare and execute query to fetch post by id
        $stmt = $conn->prepare("SELECT title, content, img, author FROM blog WHERE id = ?");
        $stmt->bind_param("i", $postId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $post = $result->fetch_assoc();
        } else {
            echo "<p class='text-center text-red-500'>Không tìm thấy bài viết.</p>";
            exit();
        }
    } else {
        echo "<p class='text-center text-red-500'>Không có ID bài viết.</p>";
        exit();
    }
    ?>

    <section class="container">
        <div class="post">
            <h1><?php echo htmlspecialchars($post['title']); ?></h1>
            <div>
                <img src="<?php echo htmlspecialchars($post['img']); ?>"
                    alt="<?php echo htmlspecialchars($post['title']); ?>">
            </div>
            <p class="content"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
            <p class="author">Tác giả: <?php echo htmlspecialchars($post['author']); ?></p>
        </div>
    </section>

</body>

</html>