<!DOCTYPE html>
<html>
<head>
    <title>Movies Search</title>
</head>
<body>
    <h2>Search for Movies 1</h2>

    <form action="<?php echo site_url('movies/search');?>" method="get">
        <label for="genre">Genre:</label>
        <input type="text" name="genre" id="genre">
        <input type="submit" value="Search">
    </form>
    
    <br>
    <button><a href="<?php echo site_url('movies/allmovies');?>">View All Movies</a></button>  
    
    <br><br>

    <button><a href="<?php echo site_url('movies/index');?>">Back to Landing page</a></button>
</body>
</html>