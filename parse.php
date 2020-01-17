<?php

include('simple_html_dom.php');
$url = 'http://estoremedia.space/DataIT/product.php?id='.$_GET["id"];
$html = file_get_html($url); 

$price = $html->find('span.price', 0);
if ($price) {
    echo 'Price: '.$price. '<br>';
} else {
    echo 'Promo Price: '. $html->find('span.price-promo', 0). '<br>';
    echo 'Old price: '. $html->find('del.price-old', 0). '<br>';
}
echo 'Image URL: '. $html->find('img', 0)->src. '<br>';
$des = $html->find('script', 1)->innertext;;
$desDecode = json_decode($des);

echo 'Code: '. $desDecode->{'products'}->{'code'}.'<br>';

$variantsInit = $desDecode->{'products'}->{'variants'};

if ($variantsInit)
{
    echo $html->find('p.card-text', 0)->plaintext. ' <b>#Variant 1:</b> <br>';
    echo 'Price: '. $variantsInit->{'Variant 1'}->{'price'}.'<br>';
    echo 'Old price: '. $variantsInit->{'Variant 1'}->{'price_old'}.'<br>';

    echo $html->find('p.card-text', 0)->plaintext. '<b> #Variant 2:</b> <br>';
    echo 'Price: '.$variantsInit->{'Variant 2'}->{'price'}.'<br>';
    echo 'Old price: '. $variantsInit->{'Variant 2'}->{'price_old'}.'<br>';

    echo $html->find('p.card-text', 0)->plaintext. '<b> #Variant 3:</b> <br>';
    echo 'Price: '. $variantsInit->{'Variant 3'}->{'price'}.'<br>';
    echo 'Old price: '. $variantsInit->{'Variant 3'}->{'price_old'}.'<br>';
}
       
$product_rate = $html->find('small.text-muted', 0)->plaintext;
preg_match('#\((.*?)\)#', $product_rate, $match);

echo '<br>Rates: '. $match[1].'<br />';
echo 'Stars: '.substr_count($product_rate, '&#9733;');

?>