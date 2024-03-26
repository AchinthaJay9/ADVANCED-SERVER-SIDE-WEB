<!DOCTYPE html>
<html>
<head>
    <title>Movie Genres</title>
</head>
<body>
    <h2>Movie Genres</h2>
    <ul>
        <?php foreach ($genres as $genre): ?>
            <li><a href="<?php echo site_url('movies/genre/'.$genre['genre']); ?>"><?php echo $genre['genre']; ?></a></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>