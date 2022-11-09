<?php
    require('authenticate.php');
    require('connect.php');

    $flag = true;

    if($_POST && !empty(trim($_POST['title'])) && !empty(trim($_POST['content'])) && !empty(trim($_POST['caption'])))
    {        
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $caption = filter_input(INPUT_POST, 'caption', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $query = "INSERT INTO articles (title, caption, content) VALUES (:title, :caption, :content)";
        $statement = $db->prepare($query);

        $statement->bindValue(':title', $title);
        $statement->bindValue(':content', $content);
        $statement->bindValue(':caption', $caption);

        $statement->execute();

        header("Location: index.php"); 
    } 
    elseif($_POST && (empty(trim($_POST['title'])) || empty(trim($_POST['content'])) || empty(trim($_POST['caption'])))) 
    {
        $flag =  false;
    }
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
        <div class="container-xxl">
            <h2 class="create_edit_header">Create Article</h2>
            <form method="post" action="creator_hub.php">
                <label for="title">Article Title</label>
                <input id="title" name="title">
                <label for="caption">Article Caption</label>
                <input id="caption" name="caption">
                <label for="content">Article Content</label>
                <textarea id="content" name="content" rows="50" cols="100"></textarea>
                <input type="submit" id="create" value="Create Article">   
            </form>
            <h2>Updating & Deleting Articles</h2>
            <p>Authorized users are able to update and delete articles by selecting the edit feature within each article page.</p>
        </div>
    <?php elseif(!$flag): ?>
        <h2>Please enter valid article titles, captions, and content.<a href="index.php"></a></h2>
    <?php endif ?>
</body>
</html>