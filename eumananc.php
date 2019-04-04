<?php
require('simple_html_dom.php');

$adresa='https://eumananc.ro/';

$listaRestaurante = file_get_html($adresa);

$out = fopen('php://output', 'w');
fputcsv($out, array("numeRestaurant","categorie","produs","descriere","pret"));


foreach($listaRestaurante->find('a.restaurant') as $link){
	$restaurantLink='https://eumananc.ro'.$link->href;

	$html = file_get_html($restaurantLink);

	$numeRestaurant=$html->find('div.page-header h1',0)->plaintext;

	foreach($html->find('tr.menu-item') as $element){

		$data=explode("/",$element->attr['data-id']);
		$name = strip_tags(trim($element->find('p[itemprop=name]',0)->plaintext));
                $description = strip_tags(trim($element->find('small[itemprop=description]',0)->plaintext));
                $pret = $element->find('p[itemprop=price]',0)->plaintext;
		$pret = preg_replace("/[^0-9]/", "", $pret);

		$categorie=$data[3];
		if ($data[1]=="craiova"){
			fputcsv($out, array($numeRestaurant,$categorie,$name,$description,$pret));
		}
	}

}


fclose($out);


?>	

