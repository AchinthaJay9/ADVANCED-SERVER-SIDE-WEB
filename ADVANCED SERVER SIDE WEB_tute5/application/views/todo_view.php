<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Add New To-Do Action</h2>

    <form  action="Todo" method="post">
        <div class="form-group">
            <label for="action_title">Title:</label>
            <input type="text" class="form-control" id="action_title" name="action_title" required>
        </div>
        <button type="submit" class="btn btn-primary">Add To-Do</button>
    </form>

    <!-- To-Do List Display -->
    <div class="mt-4">
        <h2>To-Do Actions</h2>
        <!-- Display To-Do actions here -->
    </div>
</div>

<!-- Bootstrap JS (optional) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
