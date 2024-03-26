<!DOCTYPE html>
<html>
<head>
    <title>Word Definitions</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#submitBtn').click(function(e) {
                e.preventDefault();
                var word = $('#wordInput').val();
                
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url("index.php/WordController/get_definition"); ?>',
                    data: { word: word },
                    success: function(response) {
                        $('#definition').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
</head>
<body>
    <h2>Word Definitions</h2>
    <form id="wordForm">
        <label for="wordInput">Enter a word:</label>
        <input type="text" id="wordInput" name="word">
        <button type="submit" id="submitBtn">Get Definition</button>
    </form>
    <div id="definition"></div>
</body>
</html>
