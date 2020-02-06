<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Dontvisit\Parser;
use eftec\bladeone\BladeOne;

if (!ob_start("ob_gzhandler")) {
    //gzip-e-di-doo-da
    ob_start();
}

define('ROOT_URL', $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST']);

// remove beginning slash added by nginx(?)
$url = ltrim($_GET['u'] ?: '', '/');

$hasURL = !empty($url);

if ($hasURL) {
    // don't crawl yourself
    if (strpos($url, $_SERVER['HTTP_HOST']) !== false) {
        header("Location: " . ROOT_URL . '/', true, 301);
        die();
    }

    // prepend with scheme if not present
    if (!preg_match('!^https?://!i', $url)) {
        //  assume non ssl
        $url = 'http://'.$url;
    }

    // Remove scheme from bookmarklet and direct links.
    $articlePermalinkURL = preg_replace('#^https?://#', '', $url);

    $permalinkWithoutScheme = $_SERVER['HTTP_HOST'] . '/' . $articlePermalinkURL;
    $permalink = $_SERVER['REQUEST_SCHEME'] . "://" . $permalinkWithoutScheme;

    // redirect to permalink if current address isn't the same as the wanted permalink
    if (ltrim($_SERVER['REQUEST_URI'], '/') !== $articlePermalinkURL) {
        header("Location: " . $permalink, true, 303);
        die();
    }
} else {
    // default to homepage
    $articlePermalinkURL = false;
    $permalinkWithoutScheme = $_SERVER['HTTP_HOST'] . '/';
    $permalink = $_SERVER['REQUEST_SCHEME'] . "://" . $permalinkWithoutScheme;
}

$blade = new BladeOne(
    __DIR__ . '/../resources/views',
    __DIR__ . '/../storage/views',
    BladeOne::MODE_AUTO
);
$blade->setOptimize(false); // keep whitespace

if ($hasURL) {
    require_once "includes/dbhandler.php";
    $db = new DBHandler();
    list($title, $body) = $db->read($articlePermalinkURL);

    if (!$title){
        // no cache, let's fetch the article

        //var_dump("Fetching article ...");

        // User agent switcheroo
        $UAnum = Rand (0,3) ;

        switch ($UAnum) {
            case 0:
                // TODO DN seems to restrict content if crawled from Google
                $UAstring = "User-Agent: Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)\r\n";
                break;

            case 1:
                // TODO doesn't work with www.nytimes.com/interactive/2020/02/04/us/elections/results-iowa-caucus.html
                $UAstring = "Mozilla/5.0 (compatible; Yahoo! Slurp; http://help.yahoo.com/help/us/ysearch/slurp)\r\n";
                break;

            case 2:
                // TODO doesn't work with www.nytimes.com/interactive/2020/02/04/us/elections/results-iowa-caucus.html
                $UAstring = "Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)\r\n";
                break;

            case 3:
                // TODO doesn't work with www.nytimes.com/interactive/2020/02/04/us/elections/results-iowa-caucus.html
                $UAstring = "Baiduspider+(+http://www.baidu.com/search/spider.htm)  \r\n";
                break;

                // If this works, many lolz acquired.
        }

        //$UAstring = "User-Agent: Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)\r\n";
        //$UAstring = "Mozilla/5.0 (compatible; Yahoo! Slurp; http://help.yahoo.com/help/us/ysearch/slurp)\r\n";
        //$UAstring = "Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)\r\n";
        //$UAstring = "Baiduspider+(+http://www.baidu.com/search/spider.htm)  \r\n";

        $p = new Parser($url);
        if ($p->fetch($UAstring)) {
            $p->parse();
            if ($p->readabilitify()) {
                $p->prettify();

                $title = $p->title;
                $body = $p->body;

                // save to db
                $db->cache($articlePermalinkURL, $title, $body);
            }
        } else {
            $lastError = error_get_last();
            if ($lastError && isset($lastError['message'])) {
                $db->log($url, $lastError['message'], $UAstring);
            }
        }
    }

    if ($title && $body) {
        echo $blade->run("article",compact("title", "body", "url", "articlePermalinkURL", "permalink", "permalinkWithoutScheme"));
    } else {
        echo $blade->run("notfound",["title" => $url] + compact("articlePermalinkURL", "url"));
    }
} else {
    echo $blade->run("index");
}
