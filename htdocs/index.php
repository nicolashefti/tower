<?php

require '../vendor/autoload.php';

use Symfony\Component\DomCrawler\Crawler;

$html = file_get_contents('http://www.2ememain.be/marche/2/dahon/');
$crawler = new Crawler($html);


$rssfeed = '<?xml version="1.0" encoding="ISO-8859-1"?>';
$rssfeed .= '<rss version="2.0">';
$rssfeed .= '<channel>';
$rssfeed .= '<title>My RSS feed</title>';
$rssfeed .= '<link>http://www.mywebsite.com</link>';
$rssfeed .= '<description>This is an example RSS feed</description>';
$rssfeed .= '<language>en-us</language>';
$rssfeed .= '<copyright>Copyright (C) 2009 mywebsite.com</copyright>';

$article = $crawler->filter('article')->each(function (Crawler $node, $i) {
    $title = "toto";
    $description = "yolo";
    $link = "http://www.google.com";
    $date = "2016-07-27T17:33:46+02:00";

    $rssfeed = '';
    $rssfeed .= "\n" . '<item>';
    $rssfeed .= "\n" . '<title>' . $node->filter('h3')->text() . '</title>';
    $rssfeed .= "\n" . '<description>' . htmlspecialchars('<img src="'.$node->filter('img')->attr('src') .'">' .
        '<br>' .
        '<p>Description: ' . $node->filter('p')->text() . '</p>'
        ) . '</description>';
    $rssfeed .= "\n" . '<link>' . $node->filter('a')->attr('href') . '</link>';
    $rssfeed .= "\n" . '<pubDate>' . date("D, d M Y H:i:s O", strtotime($node->filter('time')->attr('datetime'))) . '</pubDate>';
    $rssfeed .= "\n" . '</item>';

    return $rssfeed;
});

foreach ($article as $i) {
    $rssfeed .= $i;
}

$rssfeed .= '</channel>';
$rssfeed .= '</rss>';

echo $rssfeed;
