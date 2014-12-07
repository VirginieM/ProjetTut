<!doctype HTML>

	<head>
		<title>Accueil</title>
		<link rel="stylesheet" href="css_ppp.css">
		<meta charset="utf-8" />
	</head>
	
	<body>a
	
<!-- Affichage des choix de repas -->
		dz
		<form action="commande.php" method="POST">
			<INPUT TYPE="submit" NAME="simple" value='Repas Simple'>
			<INPUT TYPE="hidden" name="choix" value="
			<?php
				if(isset($_POST['menu'])){
					echo	$choix=1;
				}
				if(isset($_POST['simple'])){
					echo	$choix=0;
				}
				
			
			?>"/>
			<INPUT TYPE="submit" NAME="menu" value='Menu'>
			
			
<!-- Choix d'un menu ou sandwich simple -->
		
			<?php
			
//Stockage de choix Menu/Simple

				
//Lors du clic
				
				if(isset($_POST['menu']) OR isset($_POST['simple'])){
				
			?>
			<div id="repas">
				<?php
					include("params.php");
					$reponse = $bdd->query("SELECT * FROM repas");
					while ($donnees = $reponse->fetch()){
						if($donnees['reste'] != 0 OR $donnees['nombre'] != 0){
							$nom=$donnees['nom'];
							$prix=$donnees['prix'];
							$prix=$prix+$choix;
							echo"<INPUT TYPE='radio' NAME='repas' value='$nom'>";
							echo $nom." ".$prix."€<br>";
						}
					}
				?>
			</div>
			
			
<!-- Affichage des choix des ingredients -->
		
				<div id="ingredients">
					<?php
						include("params.php");
						$reponse = $bdd->query("SELECT * FROM ingredients");
						while ($donnees = $reponse->fetch()){
							if($donnees['reste'] != 0){
								$nom=$donnees['nom'];
								$sup=$donnees['supplement'];
								echo"<input type='checkbox' name='ingredients[]' value=$nom >";
								echo $nom;
								if($sup !=0){
									echo " (supplement : ".$sup."€)";
								}
								echo "</br>";
							}
						}
					?>
				</div>
		
<!-- Affichage des choix de sauces -->
		
				<div id="sauces">
					<?php
						include("params.php");
						$reponse = $bdd->query("SELECT * FROM sauces");
						while ($donnees = $reponse->fetch()){
							if($donnees['reste'] != 0){
								$nom=$donnees['nom'];
								echo"<INPUT TYPE='checkbox' NAME='sauces[]' value='$nom'>";
								echo $nom."<br>";
							}
						}
					?>
				</div>
				
<!-- Affichage des dessert/boissons si menu-->

				<?php
					if(isset($_POST['menu'])){
				?>
			
<!-- Affichage des choix de boisson -->

					<div id="boissons">
					<?php
						include("params.php");
						$reponse = $bdd->query("SELECT * FROM boissons");
						while ($donnees = $reponse->fetch()){
							if($donnees['reste'] != 0 OR $donnees['nombre'] != 0){
								$nom=$donnees['nom'];
								echo"<INPUT TYPE='radio' NAME='boissons' value='$nom'>";
								echo $nom."<br>";
							}
						}
					?>
					</div>
			
<!-- Affichage des choix de dessert -->
			
					<div id="desserts">
					<?php
						include("params.php");
						$reponse = $bdd->query("SELECT * FROM desserts");
						while ($donnees = $reponse->fetch()){
							if($donnees['reste'] != 0 OR $donnees['nombre'] != 0){
								$nom=$donnees['nom'];
								echo"<INPUT TYPE='radio' NAME='desserts' value='$nom'>";
								echo $nom."<br>";
							}
						}
					}
					?>
				</div>
				<INPUT TYPE="submit" NAME="valider" value='Valider la commande'>
			
<!-- Fin du clic sur Menu/Simple -->
			
			<?php
				}	/*fin condition*/																			
			?>
			
<!-- valider la commande -->

			<div id="valider">
				
				<?php
					
					if(isset($_POST['valider'])){
						include("params.php");
						
//choix repas
						$n_repas=$_POST['repas'];
						$reponse=$bdd->query("SELECT * FROM repas WHERE nom='$n_repas'");
						while ($donnees = $reponse->fetch()){
							$repas=$donnees['id'];
							$p_repas=$donnees['prix'];
						}
					
//choix ingredients

						$ingredients='0';
						$n_ingredients='0';
						foreach($_POST['ingredients'] as $val){
							$reponse=$bdd->query("SELECT * FROM ingredients WHERE nom='$val'");
							while ($donnees = $reponse->fetch())
							{
								if ($ingredients=='0'){
									$ingredients=$donnees['id'];
									$n_ingredients=$val;
									$sup_ingredients=$donnees['supplement'];
								}
								else{
									$ingredients=$ingredients.','.$donnees['id'];
									$n_ingredients=$n_ingredients.','.$val;
									$sup_ingredients=$p_ingredients + $donnees['supplement'];
								}
							}
						}
					
//Choix sauces
						
					$sauces='0';
					$n_sauces='0';
					foreach($_POST['sauces'] as $val){
						$reponse=$bdd->query("SELECT * FROM sauces WHERE nom='$val'");
						while ($donnees = $reponse->fetch())
						{
							if ($sauces=='0'){
								$sauces=$donnees['id'];
								$n_sauces=$val;
								$sup_sauces=$donnees['supplement'];
							}
							else{
								$sauces=$sauces.','.$donnees['id'];
								$n_sauces=$n_sauces.','.$val;
								$sup_sauces=$sup_sauces + $donnees['supplement'];
							}
						}
					}

//choix boissons
					
					$boissons='0';
					$n_boissons=$_POST['boissons'];
					$reponse=$bdd->query("SELECT * FROM boissons WHERE nom='$n_boissons'");
					while ($donnees = $reponse->fetch()){
						$boissons=$donnees['id'];
						$sup_boissons=$donnees['supplement'];
					}
					
//choix desserts
					$boissons='0';
					$n_desserts=$_POST['desserts'];
					$reponse=$bdd->query("SELECT * FROM boissons WHERE nom='$n_desserts'");
					while ($donnees = $reponse->fetch()){
						$desserts=$donnees['id'];
						echo($desserts);
						$sup_desserts=$donnees['supplement'];
					}
					
// Definition du prix
					if($_POST["choix"] == 0){
						$choix=0;
					}
					else{
						$choix=1;
					}
					$prix=$p_repas+$sup_ingredients+$sup_sauces+$sup_boissons+$sup_desserts+$choix;
					
// Afficher le résumé de la commande 
					
					echo '<b>Recapitulatif :</b></br>'.$n_repas.'</br>'.$n_ingredients.'</br>'.$n_sauces.'</br>'.$n_boissons.'</br>'.$n_desserts.'</br>'.'prix: '.$prix.'€</br>';
				?>
				<INPUT TYPE="submit" NAME="confirmer" value='Confirmer'>
				<?php
					}
				?>
				
				<INPUT TYPE="hidden" name="c_repas" value="<?php echo $repas ?>">
				<INPUT TYPE="hidden" name="c_ingredients" value="<?php echo $ingredients ?>">
				<INPUT TYPE="hidden" name="c_sauces" value="<?php echo $sauces ?>">
				<INPUT TYPE="hidden" name="c_boissons" value="<?php echo $boissons ?>">
				<INPUT TYPE="hidden" name="c_desserts" value="<?php echo $desserts ?>">
				<?php
					if (isset($_POST['confirmer'])){
						$repas=$_POST['c_repas'];
						$ingredients=$_POST['c_ingredients'];
						$ingredients=$_POST['c_ingredients'];
						$sauces=$_POST['c_sauces'];
						$boissons=$_POST['c_boissons'];
						$desserts=$_POST['c_desserts'];
//Recherche de l'ID pour la commande
						include("params.php");
						
						
						
						
						
						
						$bdd->exec("INSERT INTO commandesdetails VALUES ('3','3','$repas','$ingredients','$sauces','$boissons','$desserts','0')");
						$bdd->exec("INSERT INTO commandes VALUES ('3','1','0','0','0','175','0','0','1','0','0','0','0')");
					}
				?>
				
			</div>
			</form>
	</body>
</html>