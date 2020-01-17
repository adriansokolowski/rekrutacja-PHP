<?php
// nie widzę potrzeby stosowania CURL, testowane na XAMPP
include('simple_html_dom.php');
$url = 'http://estoremedia.space/DataIT/';

$i = 1; 
$pages = 4; // liczba stron do przeszukania
$products = [];

// pętla zapisująca elementy DOM z podstron do tablicy
while ($i <= $pages) {
    $html = file_get_html($url.'index.php?page='.$i); 

    foreach ($html->find('div.card') as $card)
    {
        $product_rate = $card->find('small.text-muted', 0)->plaintext;
        preg_match('#\((.*?)\)#', $product_rate, $match);

        $products[] = [
            preg_replace('/\s+/', ' ', $card->find('a.title', 0)->{'data-name'}),
            $url . $card->find('a', 0)->href,
            $card->find('img', 0)->src,
            $card->find('h5', 0)->plaintext,
            $match[1],
            substr_count($product_rate, '&#9733;')
        ];
    }
    $i++;
}

// zapis do CSV
if (file_exists('save.csv')) {
    unlink('save.csv');
}

$file = fopen("save.csv","w");

if ($file != false){
    fputcsv($file, ['Product name', 'Product URL', 'Product image', 'Product price', 'Product ratings', 'Star count'], ';');
    foreach ($products as $line) {
        fputcsv($file, $line,';');
    }

    fclose($file);
    echo 'CSV is ready,';

} else {
    echo 'CSV Error';
}

?>

