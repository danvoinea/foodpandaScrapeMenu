<?php
require('simple_html_dom.php');
error_reporting(E_ERROR);
$adresa='https://www.takeaway.com/ro/comanda-mancare-craiova-craiova-craiova';

$listaRestaurante = file_get_html($adresa);

$out = fopen('php://output', 'w');
fputcsv($out, array("numeRestaurant","categorie","produs","descriere","pret"));


foreach($listaRestaurante->find('a.img-link') as $link){

	$restaurantLink='https://www.takeaway.com'.$link->href;

	$html = file_get_html($restaurantLink);

	$numeRestaurant=$html->find('span.title-delivery',0)->plaintext;


	foreach ($html->find('div.menucard__meals-group') as $cat){
		$categorie=trim($cat->find('div.menucard__category-name',0)->plaintext);

		foreach ($cat->find('div.meal') as $produs){
			$name=trim($produs->find('span.meal-name',0)->plaintext);
                        $description=trim($produs->find('div.meal__description-additional-info',0)->plaintext);
                        $pret=trim($produs->find('div.meal__price',0)->plaintext);
	                $pret = preg_replace("/[^0-9,]/", "", $pret);
			fputcsv($out, array($numeRestaurant,$categorie,$name,$description,$pret));

		}


	}

}


fclose($out);


?>	

