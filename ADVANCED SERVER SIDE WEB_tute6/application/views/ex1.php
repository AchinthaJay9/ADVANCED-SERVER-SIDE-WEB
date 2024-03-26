<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>jQuery Exercise</title>
    <!-- Load jQuery from CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" crossorigin="anonymous"></script>
</head>
<body>
    <h2>Welcome to jQuery Exercise</h2>
    <button id="btn1">Click me!</button>
    <button class="btn-class">Button 1</button>
    <button class="btn-class">Button 2</button>

    <!-- jQuery script block -->
    <script>
        $(document).ready(function (){
            // jquery callback function for click events on the button
            $('#btn1').click(function () {
                // open alert box to display another welcome message
                alert('Hello from button with id btn1');
            });

            // jquery callback function for mouseover events on buttons with class btn-class
            $('.btn-class').mouseover(function () {
                // open alert box to display a message
                alert('You hovered over a button with class btn-class');
            });
        });
    </script>
</body>
</html>
