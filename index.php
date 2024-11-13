<?php
global $pdo;
include 'database.php';
$sql = "SELECT * FROM news ORDER BY RAND() LIMIT 10";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$newsList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Новости</title>
    <style>
        /* styles.css */

        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        .news-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .news-item {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 15px;
            width: 300px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .news-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .news-item h2 {
            font-size: 20px;
            margin: 15px;
        }

        .news-item p {
            margin: 15px;
            color: #555;
        }

        .news-item .date {
            font-size: 14px;
            color: #999;
            margin: 15px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            padding-top: 100px;
        }

        .pagination a {
            font-size: 20px;
        }

        @media (max-width: 768px) {
            .news-item {
                width: 90%;
            }
        }
    </style>
</head>

<body>
    <h1>Последние новости</h1>

    <?

    $lim = 10;

    $pages = isset($_GET['p']) ? (int) $_GET['p'] : 1;
    if ($pages < 1) {
        $pages = 1;
    }

    $offset = ($pages - 1) * $lim;
    $sql = "SELECT COUNT(*) FROM `news`";
    $rows = $pdo->query($sql)->fetchColumn();
    $total = ceil($rows / $lim);

    ?>

    <div class="news-container">
        <?php

        $sql = "SELECT * FROM `news` LIMIT $lim OFFSET $offset";
        $newsList = $pdo->query($sql)->fetchAll();

        foreach ($newsList as $news): ?>
            <div class="news-item">
                <img src="<?php echo htmlspecialchars($news['image']); ?>"
                    alt="<?php echo htmlspecialchars($news['title']); ?>">
                <h2><?php echo htmlspecialchars($news['title']); ?></h2>
                <p><?php echo htmlspecialchars($news['content']); ?></p>
                <p class="date"><?php echo date("d.m.Y H:i", strtotime($news['publication_date'])); ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="pagination">
        <?
        for ($i = 1; $i <= $total; $i++) {
            echo '<a href="?p=' . $i . '">' . $i . '</a>';
        }
        ?>
    </div>

</body>

</html>