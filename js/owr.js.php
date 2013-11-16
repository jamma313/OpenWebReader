<?php

namespace OWR;

if(empty($_GET['f']))
    die;

define('PATH', dirname(__DIR__).DIRECTORY_SEPARATOR); // define root path
define('HOME_PATH', PATH.'OWR'.DIRECTORY_SEPARATOR); // define home path

require HOME_PATH . 'cfg.php';

$file = Themes::iGet()->getPath() . 'js' . DIRECTORY_SEPARATOR . basename($_GET['f']);

if(!file_exists($file))
    die;


header('Content-type: text/javascript; charset=utf-8');
header('Cache-Control: Public, must-revalidate');
header("Expires: ".@gmdate("D, d M Y H:i:s", time() + 60*60*24*365)." GMT");
header("Last-Modified: ".@gmdate("D, d M Y H:i:s", filemtime($file))." GMT");
$etag = '"js-'.md5_file($file).'"';
header('Etag: '.$etag);
if(isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] === $etag)
{
    header("HTTP/1.1 304 Not Modified");
    exit;
}

// try to gzip the page
$encoding = false;
if(extension_loaded('zlib') && !ini_get('zlib.output_compression'))
{
    if(function_exists('ob_gzhandler') && @ob_start('ob_gzhandler'))
        $encoding = 'gzhandler';
    elseif(!headers_sent() && isset($_SERVER['HTTP_ACCEPT_ENCODING']))
    {
        if(strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false)
        {
            $encoding = 'x-gzip';
        }
        elseif(strpos($_SERVER['HTTP_ACCEPT_ENCODING'],'gzip') !== false)
        {
            $encoding = 'gzip';
        }
    }
}
switch($encoding)
{
    case 'gzhandler':
        @ob_implicit_flush(0);
        break;
    case 'gzip':
    case 'x-gzip':
        header('Content-Encoding: ' . $encoding);
        ob_start();
    default:
        break;
}

readfile($file);

switch($encoding)
{
    case 'gzhandler':
        @ob_end_flush();
        break;
    case 'gzip':
    case 'x-gzip':
        $contents = ob_get_clean();
        $size = strlen($contents);
        $contents = gzcompress($contents, 6);
        $contents = substr($contents, 0, $size);
        echo "\x1f\x8b\x08\x00\x00\x00\x00\x00";
        echo $contents;
        flush();
    default:
        flush();
        break;
}
exit;
