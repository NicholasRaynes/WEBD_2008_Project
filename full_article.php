<?php
    require('connect.php');
    
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM articles WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);

    $statement->execute();
    $entries = $statement->fetch();

    $comments_display_query = "SELECT * FROM comments WHERE article_id = :id ORDER BY created_date DESC"; 
    $comments_display_statement = $db->prepare($comments_display_query);
    $comments_display_statement->bindValue(':id', $id, PDO::PARAM_INT);

    $comments_display_statement->execute();

    if($_POST && isset($_POST['comment']) && !empty($_POST['comment_area']) && require('authenticate.php'))
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

        $content = filter_input(INPUT_POST, 'comment_area', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $comment_insert_query = "INSERT INTO comments (article_id, content) VALUES (:id, :content)";

        $comment_insert_statement = $db->prepare($comment_insert_query);

        $comment_insert_statement->bindValue(':id', $id, PDO::PARAM_INT);
        $comment_insert_statement->bindValue(':content', $content);

        $comment_insert_statement->execute();

        header("Location: full_article.php?id={$id}");
    }
    else if ($_POST && empty($_POST['comment_area']))
    {
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $entries['title'] ?></title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="https://kit.fontawesome.com/d4de3d3a72.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
    <?php include('nav.php') ?>
    <div id="full_article">
        <p><i class="fa-regular fa-pen-to-square"></i><a href="update_article.php?id=<?= $entries['id'] ?>"> Edit Article</a></p>
        <button id="full_article_category" class="btn btn-outline-primary" role="button"><?= $entries['category_name'] ?></button>
        <p id="full_article_date">Published: <?= date('F j, Y, g:i a', strtotime($entries['created_date'])) ?></p>
        <h2><?= $entries['title'] ?></h2>
        <p><?= $entries['caption'] ?></p>   
        <p><?= $entries['content'] ?></p>       
    </div>
    <form method="post" action="full_article.php">
        <div id="comment_section">
            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
            <h3>Comments</h3>
            <textarea id="comment_area" value="comment_area" name="comment_area" rows="3" cols="70" placeholder="Leave a comment..."></textarea><br>
            <input type="submit" value="Comment" id="comment" name="comment">
        </div>
    </form>
    <?php while($comments = $comments_display_statement->fetch()): ?>
        <div id="existing_comments">
            <p><?= $comments['content'] ?></p>
            <p id="comment_date">Published: <?= date('F j, Y, g:i a', strtotime($comments['created_date'])) ?></p>
        </div>
    <?php endwhile ?>
    <?php include('footer.php'); ?>
</body>
</html>