<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Actor details</title>
</head>
<body>
<?php 
		require_once('db_con.php'); 	
	
		$actorId = filter_input(INPUT_GET, 'actorid', FILTER_VALIDATE_INT)
			or die('Missing or incorrect actor ID');
		$sqlActor ='SELECT first_name, last_name
					FROM actor
					WHERE actor_id = ?';
		$stmtActor=$con->prepare($sqlActor);
		$stmtActor->bind_param('i', $actorId);
		$stmtActor->execute();
		$stmtActor->bind_result($actorName, $actorSurname);
		while($stmtActor->fetch()){
			echo '<h1>'.$actorName.' '.$actorSurname;
		}
?>
<h2>Starred movies:</h2>
<ul>
	<?php 
		$sqlMovies = 'SELECT film.title, film.film_id
					from  film, actor, film_actor
					WHERE film_actor.actor_id = actor.actor_id
					AND film_actor.film_id = film.film_id
					AND actor.actor_id = ?';
		$stmtMovie=$con->prepare($sqlMovies);
		$stmtMovie->bind_param('i', $actorId);
		$stmtMovie->execute();
		$stmtMovie->bind_result($movieTitle, $movieId);
		while($stmtMovie->fetch()){
			echo "<li><a href='filmdetails.php?filmid=".$movieId."'>".$movieTitle.'</a></li>';
		}
	?>

</ul>
</body>
</html>