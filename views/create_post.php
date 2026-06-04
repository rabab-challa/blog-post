<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
</head>
<body>
    <h2> title </h2>
    <form action="../controllers/postController.php"
      method="POST"
      enctype="multipart/form-data">
        <input
            type="text"
            name="title"
            placeholder="Title"
            required>
        <br><br>
        <textarea
            name="content"
            rows="6"
            cols="50"
            required>
        </textarea>
        <br><br>
        <select name="category" required>

            <option value="1">Entertainment</option>

            <option value="2">Educational</option>

        </select>
        <br><br>
        <label>Upload Image</label>
        <input type="file" name="image" required>
        <br><br>
        <button type="submit" name="create_post">Create Post</button>
    </form>

</body>
</html>