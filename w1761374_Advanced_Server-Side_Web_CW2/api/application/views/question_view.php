<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Questions</title>
</head>
<body>
<h1>Questions</h1>

<?php if (!empty($questions)): ?>
	<ul>
		<?php foreach ($questions as $question): ?>
			<li>
				<strong><?php echo $question['question']; ?></strong><br>
				<em>Tags: <?php echo $question['tags']; ?></em><br>
				<span>Likes: <?php echo $question['likes']; ?></span><br>
				<span>Dislikes: <?php echo $question['dislikes']; ?></span><br>
				<span>Asked by: <?php echo $question['user']['username']; ?></span><br>
				<a href="<?php echo base_url('question/show/'.$question['id']); ?>">View Details</a>
			</li>
		<?php endforeach; ?>
	</ul>
<?php else: ?>
	<p>No questions found.</p>
<?php endif; ?>

<p><a href="<?php echo base_url('question/ask'); ?>">Ask a Question</a></p>
</body>
</html>
