<?php
    require('connect.php');

    $message = "(Sorting By Create Date)";
    $order_by = "created_date DESC";

    if(isset($_POST['sorter']))
    {
        if($_POST['sorter'] == "title_sort")
        {
            $order_by = "title ASC";
            $message = "(Sorting By Title)";
        }

        if($_POST['sorter'] == "recently_created_sort")
        {
            $order_by = "created_date DESC";
            $message = "(Sorting By Create Date)";
        }

        if($_POST['sorter'] == "recently_updated_sort")
        {
            $order_by = "updated_date DESC";
            $message = "(Sorting By Update Date)";
        }
    }

    $query = "SELECT * FROM articles ORDER BY {$order_by}";

    $statement = $db->prepare($query);

    $statement->execute();

    $categories_query = "SELECT * FROM categories";
    $categories_statement = $db->prepare($categories_query);
    $categories_statement->execute();

    if(isset($_POST['category_filter']))
    {
        $category_filter = filter_input(INPUT_POST, 'category_filter', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $query = "SELECT * FROM articles WHERE category_name = :category_filter";

        $statement = $db->prepare($query);

        $statement->bindValue(':category_filter', $category_filter);

        $message = "(Sorting By {$category_filter} Category)";

        $statement->execute();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>HoopsPlus+</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/d4de3d3a72.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
    <?php include('nav.php'); ?>
    <div class="container-md">
        <form method="post" action="index.php">
            <div id="sorter">
                <h2><i class="fa-regular fa-newspaper"></i> News</h2>
                <p><?= $message ?></p>
                <label for="sorter"><i class="fa-solid fa-filter"></i> Sort By:</label>
                <select onchange="this.form.submit()" name="sorter" id="sorter">
                    <option value="recently_created_sort" name="recently_created_sort" <?php if($order_by == 'created_date DESC') echo 'selected="selected"';?>>Recently Created</option>
                    <option value="recently_updated_sort" name="recently_updated_sort" <?php if($order_by == 'updated_date DESC') echo 'selected="selected"';?>>Recently Updated</option>
                    <option value="title_sort" name="title_sort" <?php if($order_by == 'title ASC') echo 'selected="selected"';?>>Title Alphabetically</option>
                </select>
            </div>
            <div id="categories">
                <?php while($entries = $categories_statement->fetch()): ?>
                    <button name="category_filter" class="btn btn-primary" href="index.php" role="button" onchange="this.form.submit()" value=<?= $entries['category_name'] ?>><?= $entries['category_name'] ?></button>
                <?php endwhile ?>
            </div>
            <?php if ($statement->rowCount() == 0): ?>
                <p>No articles found.</p>
            <?php else: ?>
                <?php while($entries = $statement->fetch()): ?>
                    <div id="articles">
                        <h2><a href="full_article.php?id=<?= $entries['id'] ?>"><?= $entries['title'] ?></a></h2>
                        <p><?= substr($entries['caption'], 0, 100) . "..."?></p>
                        <p>Published: <?= date('F j, Y, g:i a', strtotime($entries['created_date'])) ?></p>
                        <button name="category_filter" class="btn btn-primary" href="index.php" role="button" onchange="this.form.submit()" value=<?= $entries['category_name'] ?>><?= $entries['category_name'] ?></button>
                    </div>
                <?php endwhile ?>
            <?php endif ?>
        </form>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>