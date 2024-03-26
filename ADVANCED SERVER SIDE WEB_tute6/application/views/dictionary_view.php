<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dictionary</title>
    <!-- Load jQuery from CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" crossorigin="anonymous"></script>
</head>
<body>
    <h1>Dictionary</h1>
    <form id="dictionaryForm">
        <label for="word">Enter a word:</label>
        <input type="text" id="word" name="word">
        <button type="submit" id="submitBtn">Get Definition</button>
    </form>
    <div id="definitionResult"></div>

    <script>
        $(document).ready(function() {
            $('#dictionaryForm').submit(function(e) {
                e.preventDefault(); // Prevent form submission

                // Get the word from the input field
                var word = $('#word').val();

                // Send AJAX request to get definition
                $.ajax({
                    url: "<?php echo base_url('dictionary/get_definition'); ?>",
                    type: "POST",
                    data: { word: word },
                    success: function(data) {
                        // Display definition in the result div
                        $('#definitionResult').html(data);
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>
</html>
