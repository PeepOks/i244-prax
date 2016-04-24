<html>
	<head>
		<title>yl1</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<?php 
			$taust="#008000";
			if (isset($_POST['taust']) && $_POST['taust']!="") {
    			$taust=htmlspecialchars($_POST['taust']);
			}
			$tekstivarv="#ffff00";
			if (isset($_POST['tekstivarv']) && $_POST['tekstivarv']!="") {
    			$tekstivarv=htmlspecialchars($_POST['tekstivarv']);
			}
			$tekst="";
			if (isset($_POST['tekst']) && $_POST['tekst']!="") {
    			$tekst=htmlspecialchars($_POST['tekst']);
			}
			$joonestiil="solid";
			if (isset($_POST['joonestiil']) && $_POST['joonestiil']!="") {
    			$joonestiil=htmlspecialchars($_POST['joonestiil']);
			}
			$joonelaius="5";
			if (isset($_POST['joonelaius']) && $_POST['joonelaius']!="") {
    			$joonelaius=htmlspecialchars($_POST['joonelaius']);
			}
			$joonevarv="#000000";
			if (isset($_POST['joonevarv']) && $_POST['joonevarv']!="") {
    			$joonevarv=htmlspecialchars($_POST['joonevarv']);
			}
			$raadius="10";
			if (isset($_POST['raadius']) && $_POST['raadius']!="") {
    			$raadius=htmlspecialchars($_POST['raadius']);
			}
			?>
		<style type="text/css">
			#tekstivali{
				padding: 5px;
				min-height: 100px;
				width: 200px;
				background: <?php echo $taust; ?>;
				color: <?php echo $tekstivarv; ?>;
				border-width: <?php echo $joonelaius; ?>px;
				border-style: <?php echo $joonestiil; ?>;
				border-color: <?php echo $joonevarv; ?>;
				border-radius: <?php echo $raadius; ?>px;
			}
		</style>
	</head>
	<body>
	<textarea id="tekstivali" name="tekstivali" placeholder="Siia tuleb POST-st tekst" ><?php echo $tekst; ?></textarea>
	<hr>
	<form action="yl1.php" method="POST">
		<table>
			<tbody>
				<tr>
					<td>
						<input type="text" name="tekst" value="<?php echo $tekst; ?>" placeholder="Siia kirjuta oma tekst" />
					</td>
				</tr>
				<tr>
					<td>
						<input type="color" name="taust" value="<?php echo $taust; ?>"/>
					</td>
					<td>Taustavärvus</td>
				</tr>
				<tr>
					<td>
						<input type="color" name="tekstivarv" value="<?php echo $tekstivarv; ?>"/>
					</td>
					<td>Teksti värvus</td>
				</tr>
			</tbody>
		</table>
		<hr>
		<table style="border: 1px dotted black">
			<tbody>
				<tr>
					<td>
						<input type="number" name="joonelaius" value="<?php echo $joonelaius; ?>" min="1" max="20" step="1" />
					</td>
					<td>Joone laius 1-20px</td>
				</tr>
				<tr>
					<td><select name="joonestiil">
						<option <?php if($joonestiil == 'solid'){echo("selected");}?> value="solid">solid</option>
						<option <?php if($joonestiil == 'dashed'){echo("selected");}?> value="dashed">dashed</option>
						<option <?php if($joonestiil == 'dotted'){echo("selected");}?> value="dotted">dotted</option>
					</select></td>
					<td>Joone stiil</td>
				</tr>
				<tr>
					<td><input type="color" name="joonevarv" value="<?php echo $joonevarv; ?>"/></td>
					<td>Piirjoone värvus</td>
				</tr>
				<tr>
					<td><input type="number" name="raadius" value="<?php echo $raadius; ?>" min="1" max="100" step="1"/></td>
					<td>Nurga raadius 1-100px</td>
				</tr>
			</tbody>
		</table>
		<hr>
		<input type="submit" name="submit" value="Saada andmed"/>
	</form>
	<?php
	function formaction() {
		if (isset($_POST['tekstisesestus']) && $_POST['tekstisesestus']!="") {
    		$tekstisesestus=htmlspecialchars($_POST['tekstisesestus']);
		}
	};
	
	if($_SERVER['REQUEST_METHOD']=='POST')
				{
       				formaction();
				}
    
	?>  
	</body>
</html>

