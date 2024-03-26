<!DOCTYPE html>
<html>
<head>
    <title>All Movies</title>
</head>
<body>
    <h2>All Movies</h2>
    <ul>
    <?php foreach ($movies as $movie): ?>
        <br>
        <li>
            <strong>Title:</strong> <?php echo $movie['title']; ?><br>
            <strong>Director:</strong> <?php echo $movie['director']; ?><br>
            <strong>Genre:</strong> <?php echo $movie['genre']; ?><br>
            <strong>IMDB Rating:</strong> <?php echo $movie['imdb_rating']; ?><br>
            <strong>Release Year:</strong> <?php echo $movie['release_year']; ?>
        </li>
    <?php endforeach; ?>
    </ul>
</body>
</html>
