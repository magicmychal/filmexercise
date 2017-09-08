<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Categories</title>
</head>

<body>
<h1>Categories</h1>
<?php require_once('db_con.php');
		$sql = 'SELECT category_id, name FROM category';
						$stmt = $con->prepare($sql); //let's prepare to execute our sql, it's gonna be stored in $stmt
						//$stmt->bind_param('s', $mail);
						$stmt->execute();
						$stmt->bind_result($catID, $catName);
						echo '<ul>';
						while($stmt->fetch()){
							echo "<li><a href='filmlist.php?categoryid=".$catID."'>".$catName.'</a></li>';
						}
						echo '</ul>';
		?>
</body>

</html>