<?php
/**
 * Created by PhpStorm.
 * User: bilipp
 * Date: 30.05.17
 * Time: 12:59
 */
namespace JodelWrapper;
require_once(__DIR__ . "/Provider.php");
require_once(__DIR__ . "/Jodel.php");
require_once (__DIR__. "/Database.php");
require_once (__DIR__. "/relatedPosts.php");

use JodelWrapper\Provider;
use JodelWrapper\Database;
use JodelWrapper\relatedPosts;

header('Access-Control-Allow-Origin: *');

if(isset($_GET["api"]) && isset($_GET["id"])){
    $db = new Database();
    echo json_encode(array("details" => $db->getJodel($_GET["id"]), "replies" => $db->getChildrenJodel($_GET["id"])));
}
else if(isset($_GET["related"]) && isset($_GET["text"])){
    $related = new relatedPosts();
    echo $related->request($_GET["text"]);
}
else if(isset($_GET["api"]) && isset($_REQUEST["array"])){
    $db = new Database();
//    var_dump($_POST["array"]);
    echo json_encode(array("posts" => $db->getJodelArray($_REQUEST["array"])));
}
else{
    echo "update db";

    $cached = false;
    $type = "recent";

    $provider = new Provider($type, $cached);
    $lastId = $provider->getJodel();
    $provider->getJodel(1);

}
