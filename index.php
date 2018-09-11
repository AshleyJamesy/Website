<?php
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';
  require 'SQLiteConnection.php';
    
	if(isset($_SESSION['steamid']))
	{
		$id = $steamprofile['avatar'];
	}

	$path = '/home/PlayRP/servers/gmod/playrp/garrysmod/sv.db';
    $connection = new SQLiteConnection();
    $connection->connect($path);
     
    try {
    $connection->pdo->exec('CREATE TABLE IF NOT EXISTS patients (patient_name varchar(255), notes varchar(255))');
    $tables = $connection->pdo->query("SELECT * FROM sqlite_master WHERE type=\'table\'");
echo '<script>alert("' . print_r($tables) . '")</script>';
    
    }catch(Exception $e){
        echo '<script>alert("Commit complete!' . $e .  '")</script>';
    }
?>
<html lang="en">
	<head>
	<style>
		table, th, td {
			border: 1px solid black;
			vertical-align: middle;
		}
	</style>
	</head>
	<body>
		<table>
		<tr>
			<?php
				if(isset($_SESSION['steamid']))
				{
					echo "<td>" . getSteamProfileName() . "</td>";
					echo "<td><img src=" . getSteamProfileAvatar() . "></td>";
					echo "<td>" . getSteamProfileState() . "</td>";
					?>
						<td align=center>
					<?php
						logoutbutton();
					?>
						</td>
					<?php
				}
				else
				{
					loginbutton();
				}
			?>
		</tr>
		</table>
		<br>
			<form method="POST">
				Enter Paient Name:
				<input type="text" name="patient_name">
				<br>
				Enter Notes:
				<input type="text" name="notes">
				<input type="submit" value="save">
			</form>
	</body>
</html>

<?php
	if($connection->isConnected() == true)
	{
		if(isset($_POST['patient_name']) && isset($_POST['notes'])){
			$patient_name 	= $_POST['patient_name'];
			$notes 			= $_POST['notes'];
            
            try
			{
				$connection->pdo->beginTransaction();
				$status = $connection->pdo->exec("INSERT INTO patients (patient_name, notes) VALUES ('$patient_name', '$notes')");

echo '<script>alert("' . print_r($connection->pdo->errorInfo()) . '")</script>';

                $connection->pdo->commit();
                
                echo '<script>alert("Commit complete!' . $patient_name .  '")</script>';
			}
			catch (PDOException $e) {
        		$connection->pdo->rollback();

        		echo '<script>console.log("Failed: ' . $e->getMessage() . '")</script>';
			}
        }
    }
?>
