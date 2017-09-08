<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Film Detaials</title>
</head>

<body>

<?php 
	require_once('db_con.php');
	
	$filmId = filter_input(INPUT_GET, 'filmid', FILTER_VALIDATE_INT)
		or die('Missing or incorrect film ID');
	echo 'The ID is'. $filmId;
	$sqlSelectMovie ='SELECT f.title, f.description, f.release_year, f.length, l.name as lang
						FROM film f, language l
						WHERE f.film_id=?
						AND f.language_id = l.language_id';
	$stmtMovie=$con->prepare($sqlSelectMovie);
	$stmtMovie->bind_param('i', $filmId);
	$stmtMovie->execute();
	$stmtMovie->bind_result($filmTitle, $filmDesc, $filmDate, $filmTime, $filmLang);
	echo 'were here';
	while($stmtMovie->fetch()){
		echo '<h1>'.$filmTitle.' ('.$filmLang.')</h1>';
		echo '<p>Release year: '.$filmDate.'<br />Length: '.$filmTime.' minutes </p>';
		echo '<p>'.$filmDesc.'</p>';
	}?>

	<h3>This movie is in those categories:</h3>	
	<ul>
	<?php
		$sqlCat = 'SELECT c.category_id, c.name
		FROM film_category fc, category c
		WHERE film_id=?
		AND fc.category_id = c.category_id';
		$stmtCat = $con->prepare($sqlCat);
		$stmtCat->bind_param('i', $filmId);
		$stmtCat->execute();
		$stmtCat->bind_result($categoryId, $categoryName);
		//deletecategoryfromfilm.php
		while($stmtCat->fetch()) {
			echo '<li><a href="filmlist.php?categoryid='.$categoryId.'">'.$categoryName.'</a>';
			echo '</li>';
		}
	?>
	</ul>
	<h3>Starring:</h3>
	<ul>
	<?php 
		$sqlActors ='SELECT a.first_name, a.last_name, a.actor_id
					FROM film_actor fa, actor a
					WHERE film_id=?
					AND fa.actor_id = a.actor_id';
		$stmtAc=$con->prepare($sqlActors);
		$stmtAc->bind_param('i',$filmId);
		$stmtAc->execute();
		$stmtAc->bind_result($actorName, $actorSurname, $actorId);
		while($stmtAc->fetch()){ 
			echo '<li><a href="actordetails.php?actorid='.$actorId.'">'.$actorName.'</a>';
			echo '</li>';
		}
	
	?>
	</ul>
	<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
		<input type="submit" name="deleteSubmit" value="Delete this movie">
	</form>
	<?php
		if(!empty(filter_input(INPUT_POST, 'deleteSubmit'))){	
		$deleteID = filter_input(INPUT_POST, 'selectID', FILTER_VALIDATE_INT);
		echo $deleteID;
		$sqlDelete = 'DELETE FROM category
				  WHERE category_id =?';
		$stmtDelete = $con->prepare($sqlDelete);
		$stmtDelete->bind_param('i',$deleteID);
		$stmtDelete->execute();
		echo '<i>Succesfully deleted '.$deleteID.'</i>';
	}
	?>
	<a href="edit.php">Edit this movie</a>
</body>
</html>