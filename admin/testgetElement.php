<?php

$xml  =<<<EOT
<?xml version="1.0" encoding="ISO-8859-1"?>
<news>
    <item>
        <title>News 1</title>
        <created>04/2/2010 08:00 EST</created>
        <url>http://news.example.com/news.pdf</url>
    </item>
    <item>
        <title>News 2</title>
        <created>04/25/2010 08:00 EST</created>
        <url>http://news.example.com/news.pdf</url>
    </item>
    <item>
        <title>News 3</title>
        <created>04/27/2010 08:00 EST</created>
        <url>http://news.example.com/news.pdf</url>
    </item>
</news>
EOT;

$doc = new DOMDocument();

if ($doc->loadXML($xml)) {
    $items = $doc->getElementsByTagName('item');
    $headlines = array();
   
    foreach($items as $item) {
        $headline = array();
       
        if($item->childNodes->length) {
            foreach($item->childNodes as $i) {
                $headline[$i->nodeName] = $i->nodeValue;
            }
        }
       
        $headlines[] = $headline;
    }
   
    if(!empty($headlines)) {
        $hc = 0;
       
        echo '<ul>';
       
        foreach($headlines as $headline) {
            if(++$hc <= 3) {
                echo '<li>'
                    .'<a href="'.$headline['url'].'"  class="ddd"  target="_blank">'
                        .'<span>'.date('F j, Y', strtotime($headline['created'])).'</span><br />'
                        .$headline['title']
                    .'</a>'
                .'</li>';
            }
        }
       
        echo '</ul>';
    }
}

?>