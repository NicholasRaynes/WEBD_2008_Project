<?php
    require('authenticate.php');
    require('connect.php');

    $flag = true;

    if($_POST && !empty(trim($_POST['title'])) && !empty(trim($_POST['content'])) && !empty(trim($_POST['caption'])) && !empty(trim($_POST['category_name'])))
    {        
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $caption = filter_input(INPUT_POST, 'caption', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $category_name = filter_input(INPUT_POST, 'category_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $query = "INSERT INTO articles (title, caption, content, category_name) VALUES (:title, :caption, :content, :category_name)";
        $statement = $db->prepare($query);

        $statement->bindValue(':title', $title);
        $statement->bindValue(':content', $content);
        $statement->bindValue(':caption', $caption);
        $statement->bindValue(':category_name', $category_name);

        $statement->execute();

        header("Location: index.php"); 
    } 
    elseif($_POST && (empty(trim($_POST['title'])) || empty(trim($_POST['content'])) || empty(trim($_POST['caption'])) || empty(trim($_POST['category_name'])))) 
    {
        $flag =  false;
    }

    // Below is for populating the categories drop down options.

    $categories_query = "SELECT * FROM categories";
    $categories_statement = $db->prepare($categories_query);
    $categories_statement->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="https://kit.fontawesome.com/d4de3d3a72.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Creator Hub</title>
</head>
<body>
    <?php include('nav.php'); ?>
    <?php if($flag): ?>
        <div class="container-md">
            <h2 class="create_edit_header">Create Article</h2>
            <form method="post" action="creator_hub.php">
                <label for="title">Article Title:</label>
                <input id="title" name="title">
                <label for="caption">Article Caption:</label>
                <input id="caption" name="caption">
                <label for="content">Article Content:</label>
                <textarea id="content" name="content" rows="50" cols="100"></textarea>
                <label for="category_name">Article Category:</label>
                <select name="category_name" id="category_name">
                    <?php while($entries = $categories_statement->fetch()): ?>
                        <option><?= $entries['category_name'] ?></option>
                    <?php endwhile ?>
                </select>
                <input type="submit" id="create" value="Create Article">   
            </form>
            <h2>Updating & Deleting Articles</h2>
            <p>Authorized users are able to update and delete articles by selecting the edit feature within each article page.</p>
        </div>
    <?php elseif(!$flag): ?>
        <h2 id="details">Please enter valid values for all fields on the page.<a href="index.php"></a></h2>
    <?php endif ?>
    <?php include('footer.php'); ?>
</body>
</html>