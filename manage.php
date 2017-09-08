<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Manage Category</title>
</head>

<body>

<?php require_once('db_con.php');
	//ADDING A NEW CATEGORY
	// if not empty - user clicks sing up button
		if(!empty(filter_input(INPUT_POST, 'newCatNameSubmit'))){
			//read all inputs and validate them
			$newCatName = filter_input(INPUT_POST, 'newCatName')
				or die('Invalid Name input');
			
			//checking if the user exist in the database
			$sqlcheck = 'SELECT name FROM category WHERE name=?';
			$stmtcheck = $con->prepare($sqlcheck);
			$stmtcheck->bind_param('s', $newCatName);
			$stmtcheck->execute();
			$stmtcheck->bind_result($nameCheck);
			while($stmtcheck->fetch()){}
			if($newCatName == $nameCheck){
				echo "<div class='alert alert-danger' role='alert'>
					  This name is alredy in the database
					 </div>";
			}
			else{
			
			//now when everything works fine, it's time to put those infromation to the database
			$sqlAdd = 'INSERT INTO category (name) VALUES (?)';
			$stmtAdd = $con->prepare($sqlAdd);
			$stmtAdd->bind_param('s', $newCatName);
			$stmtAdd->execute();
			
			//displaying success alert
			echo '<i>Added '.$newCatName.'</i>';
			
			
		}
			
		}  	
	//DELETE CATEGORY
	
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
	
	
	//CHANGE NAME
	
	if(!empty(filter_input(INPUT_POST, 'changeSubmit'))){
		$updatedCatName = htmlspecialchars(filter_input(INPUT_POST, 'changedName'));
		$updateID = filter_input(INPUT_POST, 'updateID', FILTER_VALIDATE_INT);
		echo $updatedCatName.$updateID;
		$sqlUpdate='UPDATE category
					SET name=?
					WHERE category_id=?';
		$stmtUpdate = $con->prepare($sqlUpdate);
		$stmtUpdate->bind_param('si', $updatedCatName, $updateID);
		$stmtUpdate->execute();
		echo 'Correctet changed to '.$updatedCatName;
	
	}
	
?>

<h2>Add a new category</h2>
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
	<input type="text" name="newCatName" placeholder="Category name" required>
	<input type="submit" name="newCatNameSubmit" value="Add now">
</form>

<h2>Delete a category</h2>
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
	<select name="selectID">
		<?php $sqlSelect = 'SELECT category_id, name FROM category';
						$stmt = $con->prepare($sqlSelect); //let's prepare to execute our sql, it's gonna be stored in $stmt
						//$stmt->bind_param('s', $mail);
						$stmt->execute();
						$stmt->bind_result($catID, $catName);
						while($stmt->fetch()){
							echo "<option value='".$catID."'>".$catName."</option>";
						}
		?>
	</select>
	<input type="submit" name="deleteSubmit" value="Delete it">
</form>



<h3>Change the name</h3>
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
	<select name="updateID">
		<?php $sqlSelect = 'SELECT category_id, name FROM category';
						$stmt = $con->prepare($sqlSelect); //let's prepare to execute our sql, it's gonna be stored in $stmt
						//$stmt->bind_param('s', $mail);
						$stmt->execute();
						$stmt->bind_result($catID, $catName);
						while($stmt->fetch()){
							echo "<option value='".$catID."'>".$catName."</option>";
						}
		?>
	</select>
	<input type="text" name="changedName" placeholder="New name" required>
	<input type="submit" name="changeSubmit" value="Change">
</form>

</body>
</html>