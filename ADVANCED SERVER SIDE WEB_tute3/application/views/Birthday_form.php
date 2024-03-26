<html>
<body>
    <form action="<?php echo site_url('AgeCalculator/calculate_age'); ?>" method="post">

        <label for="birthdate">Enter Your Date of Birth:</label><br>
        <input type="date" id="birthdate" name="birthdate"><br><br>
        <input type="submit" value="Submit">

    </form>
</body>
</html>
