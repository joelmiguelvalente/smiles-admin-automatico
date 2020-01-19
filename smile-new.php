<?php
include '../header.php';
/**
 * Controlador Smiles
 *
 * @name    smile-new.php
 * @author  @Miguel92
 * @copyright 2020
*/
/**********************************\

* (VARIABLES LOCALES ESTE ARCHIVO)	*

\*********************************/
if (!mysqli_fetch_row(mysqli_query($db_link, 'SHOW TABLES LIKE \'wd_smiles\'')) == true) {
	db_exec(array(__FILE__, __LINE__), 'query', 'CREATE TABLE wd_smiles (
	wd_id INT(11) AUTO_INCREMENT PRIMARY KEY,
	wd_route VARCHAR(200) NOT NULL,
	wd_smile VARCHAR(50) NOT NULL DEFAULT "",
	wd_date VARCHAR(20) NOT NULL DEFAULT "")');
}

// BUSCAMOS LA CARPETA DE LOS SMILES
$CARPETA__SMILES = TS_ROOT.'/themes/'.TS_TEMA.'/images/smiles/*';
$URL__SMILES = $tsCore->setSecure($tsCore->settings['url'].'/themes/'.TS_TEMA.'/images/smiles/');
$FECHA = time();

// LEEMOS EL CONTENIDO
$SMILES = glob($CARPETA__SMILES); 

// CREAMOS FOREACH PARA RECORRER TODOS LOS ARCHIVOS
foreach($SMILES as $SMILE){

	// REEMPLAZAMOS LA RUTA, YA QUE NECESITAMOS SOLO LA IMAGEN
	$SMILE = str_replace(TS_ROOT.'/themes/'.TS_TEMA.'/images/smiles/', '', $SMILE);

	$result = db_exec(array(__FILE__, __LINE__), 'query', "SELECT * FROM wd_smiles") ;
	if ($row = db_exec('fetch_array', $result)){
		do {
			if(!$row['wd_smile']) {
				db_exec(array(__FILE__, __LINE__), 'query', "
					INSERT INTO `wd_smiles` (wd_route, wd_smile, wd_date) VALUES ('{$URL__SMILES}', '{$SMILE}', '{$FECHA}')");
			}
		} while ($row = db_exec('fetch_array', $result));
	}
	
}
