<?php
    session_start();

    require('connect.php');

    if(isset($_SESSION['user_id']) && $_SESSION['access'] >= 1)
    {
        if($_POST && !empty($_POST['title']) && !empty($_POST['content']) && !empty($_POST['caption']) && !empty($_POST['id']))
        {
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
            $caption = filter_input(INPUT_POST, 'caption', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $query = "UPDATE articles SET title = :title, content = :content, caption = :caption WHERE id = :id";

            $statement = $db->prepare($query);

            $statement->bindValue(':title', $title);
            $statement->bindValue(':content', $content);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->bindValue(':caption', $caption);

            $statement->execute();

            header("Location: index.php");
        } 
        else if(isset($_GET['id']) && filter_var(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT), FILTER_VALIDATE_INT))
        {
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

            $query = "SELECT * FROM articles WHERE id = :id";

            $statement = $db->prepare($query);

            $statement->bindValue(':id', $id, PDO::PARAM_INT);

            $statement->execute();

            $row = $statement->fetch(); 

            if($row)
            {
                if($_POST && (empty(trim($_POST['title'])) || empty(trim($_POST['content'])) || empty(trim($_POST['caption']))))
                {
                    $flag = false;
                    $errorMessage = "Your title, caption, or content can't be empty.";
                } 
                else 
                {
                    $flag = true;  
                }
            } 
            else 
            {
                $flag = false;
                $errorMessage = "The ID you entered does not exist in the database. ";
            }
        } 
        else 
        {
            header("Location: index.php");
        }  
    }
    else
    {
        header("Location: access_concern.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Update <?= $row['title'] ?></title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="https://kit.fontawesome.com/d4de3d3a72.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
    <?php include('nav.php') ?>
    <div class="container-md">
        <h2 class="create_edit_header">Update Article</h2>
        <?php if($flag): ?>
        <form method="post">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <label for="title">Title</label>
            <input id="title" name="title" value="<?= $row['title'] ?>">
            <label for="caption">Caption</label>
            <input id="caption" name="caption" value="<?= $row['caption'] ?>">
            <label for="content">Content</label>
            <textarea id="content" name="content" rows="50" cols="100"><?= $row['content'] ?></textarea>
            <input type="submit" value="Update Article" id="update">
            <input type="submit" value="Delete Article" id="delete" onclick="return confirm('Are you sure you want to delete this article?')" formaction="delete_article.php?id='<?= $row['id'] ?>'">     
        </form>
    <?php elseif(!$flag): ?>
        <h2><?= $errorMessage ?><a href="index.php"></a></h2>
    <?php endif ?>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>