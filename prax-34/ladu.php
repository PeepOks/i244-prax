<?php 
require_once('funksioonid.php');
session_start();
connect_db();

include_once('header.php');

?>

	<hr>
	<form action="ladu.php" method="POST">
		<p>Uhke laoprogramm</p>
		<table>
			<tbody>
				<tr>
					<td>Kaup: </td>
					<td>
						<input type="text" name="kaup" placeholder="Kauba nimetus" />
					</td>
				</tr>
				<tr>
					<td>Kogus: </td>
					<td>
						<input type="number" name="kogus" value="1"/>
					</td>
	
				</tr>
			</tbody>
		</table>
		<hr>
		
		<input type="submit" name="submit" value="Saada andmed"/>
	</form>
<?php
	include_once('footer.php');	
	if($_SERVER['REQUEST_METHOD']=='POST')
				{
       				lisa();
				}
    
	
?>  

