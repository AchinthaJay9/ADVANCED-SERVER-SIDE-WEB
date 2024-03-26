<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submission with jQuery</title>
    <!-- Load jQuery from CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" crossorigin="anonymous"></script>
</head>
<body>
    <form id="myForm">
        <input type="text" id="inputField" placeholder="Type something...">
        <button type="submit" id="submitButton">Submit</button>
    </form>
    <div id="output"></div>

    <!-- jQuery script block -->
    <script>
        $(document).ready(function () {
            $('#submitButton').click(function (e) {
                e.preventDefault();
                alert($('#inputField').val());
                $('#output').html($('#inputField').val());
            });

            $('#clearButton').click(function () {
                $('#output').html('');
            });
        });
    </script>

    <button id="clearButton">Clear</button>
</body>
</html>
