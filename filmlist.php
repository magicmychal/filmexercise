<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Film in the category</title>
</head>

<body>
<ul>
<?php   
	    $categoryid = filter_input(INPUT_GET, 'categoryid', FILTER_VALIDATE_INT)
			or die('Missin correct category id');
	    require_once('db_con.php');
		$sql ='
			SELECT f.film_id, f.title
			FROM film f, film_category fc
			WHERE f.film_id=fc.film_id
			AND fc.category_id=?';
		$stmt = $con->prepare($sql); //let's prepare to execute our sql, it's gonna be stored in $stmt
		$stmt->bind_param('i', $categoryid);
		$stmt->execute();
		$stmt->bind_result($filmID, $filmTitle);
		echo '<ul>';
		while($stmt->fetch()){?>
			<li><a href="filmdetails.php?filmid=<?php echo $filmID;?>"><?php echo $filmTitle;?></a></li>
		<?php } ?>
</ul>
</body>
</html>