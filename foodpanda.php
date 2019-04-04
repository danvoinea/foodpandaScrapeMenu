<?php
require('simple_html_dom.php');

$adresa='https://www.foodpanda.ro/restaurants/lat/44.33019486958456/lng/23.7934017475377/city/Craiova/address/Strada%2520Doljului%25201a%252C%2520Craiova%2520200167%252C%2520Rom%25C3%25A2nia/Strada%2520Doljului/1a?postcode=200167';

$listaRestaurante = file_get_html($adresa);

$out = fopen('php://output', 'w');

fputcsv($out, array("numeRestaurant","categorie","produs","descriere","pret"));

foreach($listaRestaurante->find('a.hreview-aggregate') as $link){

	$restaurantLink='https://www.foodpanda.ro'.$link->href;

	$html = file_get_html($restaurantLink);

	$numeRestaurant=$html->find('div.vendor-info-main-headline h1',0)->plaintext;

	foreach($html->find('div.dish-card') as $element){
		$produs=json_decode($element->attr['data-object']);
		$categorie=$element->attr['data-menu-category'];
		fputcsv($out, array($numeRestaurant,$categorie,$produs->name,$produs->description,$produs->product_variations[0]->price));
	}

}

fclose($out);

?>	

