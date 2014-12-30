<?php
session_start();
?>

<!doctype HTML>

	<head>
		<title>Acceuil</title>
		<link rel="stylesheet" href="style.css">
		<meta charset="utf-8">
		
	</head>
	
	<body>
		<div class="centrage">
			<?php
				include("menu.php");
			?>
		
			<div class="contenu">
				<h1> Actualités </h1>
				<?php
					require 'params2.php';
					mysql_connect($host,$user,$password) or die('Erreur le connexion au SGBD.');
					mysql_select_db($base) or die('La base de données n\'existe pas');
					$queryStatut='select * FROM statut';
					$rStatut=mysql_query($queryStatut);
					mysql_close();
					while($a=mysql_fetch_object($rStatut)){
						$titre  = $a->TITRE; 
						$type  = $a->TYPE;
						$texte  = $a->TEXTE;
						$dateDebut = $a->DATEDEBUT;
						$heureDebut = $a->HEUREDEBUT;
						$dateFin = $a->DATEFIN;
						$heureFin = $a->HEUREFIN;
						//on convertit les dates et les heures pour pouvoir les comparer
						//$dateDS = new DateTime($dateDebut);
						//$debut=$dateDS->format('d-m-Y H:i:s');
						//$dateFS = new DateTime($dateFin);
						//$fin=$dateFS->format('d-m-Y H:i:s');
						//On transforme les dates et heures en nombre pour pouvoir les comparer 
						//Dates de début et fin
						$datenow= date('d-m-Y');
						$dateDS = explode("-",$dateDebut);
						$dateFS = explode("-",$dateFin);
						$dateNow = explode("-",$datenow);
						$debut = $dateDS[2].$dateDS[1].$dateDS[0];
						$fin= $dateFS[2].$dateFS[1].$dateFS[0];
						$now = $dateNow[2].$dateNow[1].$dateNow[0];
						
						//Heures de début et fin on concatène en enlevant les ":" à la position 2 de la variable 
						$heurenow= date('H:i');
						$hdebut = $heureDebut[0].$heureDebut[1].$heureDebut[3].$heureDebut[4];
						$hfin = $heureFin[0].$heureFin[1].$heureFin[3].$heureFin[4];
						$hnow = $heurenow[0].$heurenow[1].$heurenow[3].$heurenow[4];
	
						if(($debut<$now or ($debut=$now and $hdebut<=$hnow)) and ($fin>$now or ($fin=$now and $hfin>=$hnow))){

							echo"
								<table class=\"statut\">
									<tr>
										<th class=\"titreStatutGauche\">$type</th>
										<th class=\"titreStatutDroite\">$titre</th>
									</tr>
									<tr>
										<td colspan=\"2\" align=\"center\" class=\"texteStatut\">$texte</td>
									</tr>
								</table>
								";
						}
					}
				?>
				<br/>
				<h1> Bienvenue Sur le site du BDE Info </h1>
				<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc
				putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.</p>
			</div>
		</div>
	</body>
	
	
	
	
</html>