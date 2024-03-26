
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Search Landing Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4; /* Matching background color */
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff; /* Form background color */
            padding: 20px;
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Box shadow for depth */
        }

        .section {
            margin-bottom: 30px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        input[type="submit"],
        .button {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover,
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Search for Movies</h2>

        <div class="section">
            <form action="<?php echo site_url('movies/search'); ?>" method="get">
                <label for="title">Search by Title:</label>
                <input type="text" name="title" id="title" placeholder="Enter movie title">
                <input type="submit" value="Search">
            </form>
        </div>

        <div class="section">
            <form action="<?php echo site_url('movies/search'); ?>" method="get">
                <label for="genre">Search by Genre:</label>
                <select name="genre" id="genre">
                    <option value="">Select Genre</option>
                    <?php foreach ($genres as $genre): ?>
                        <option value="<?php echo $genre['genre']; ?>"><?php echo $genre['genre']; ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" value="Search">
            </form>
        </div>

        <div class="section">
            <a href="<?php echo site_url('movies/landingpage'); ?>" class="button">Go to view all Movies</a>
        </div>
    </div>
</body>
</html>

