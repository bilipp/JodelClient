<?php
/**
 * Created by PhpStorm.
 * User: bilipp
 * Date: 30.05.17
 * Time: 11:27
 */

namespace JodelWrapper;

use PDO;
use JodelWrapper\Jodel;


class Database
{
    protected $connection;

    const DATABASE_HOST = "";
    const DATABASE_NAME = "";
    const DATABASE_USER = "";
    const DATABASE_PW = "";

    function __construct()
    {
        $this->connection = new PDO('mysql:host='.self::DATABASE_HOST.'; dbname='.self::DATABASE_NAME.';', self::DATABASE_USER, self::DATABASE_PW,  array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
    }

    public function insertJodel(Jodel $jodel)
    {
        $queryPrepare = $this->connection->prepare("REPLACE INTO Posts (id, message, created_at, updated_at, pin_count, color, thanks_count, child_count, replier, discovered_by, vote_count, share_count, user_handle, post_own, distance, location, from_home, image_url, parent_id) VALUES (:id, :message, :created_at, :updated_at, :pin_count, :color, :thanks_count, :child_count, :replier, :discovered_by, :vote_count, :share_count, :user_handle, :post_own, :distance, :location, :from_home, :image_url, :parent)");
        //Get Params
        $jodelId = $jodel->getId();
        $jodelMessage = $jodel->getMessage();
        $jodelCreated = $jodel->getCreatedAt();
        $jodelUpdated = $jodel->getUpdatedAt();
        $jodelPinCount = $jodel->getPinCount();
        $jodelColor = $jodel->getColor();
        $jodelThanksCount = $jodel->getThanksCount();
        $jodelChildCount = $jodel->getChildCount();
        $jodelReplier = $jodel->getReplier();
        $jodelDiscoveredBy = $jodel->getDiscoveredBy();
        $jodelVoteCount = $jodel->getVoteCount();
        $jodelShareCount = $jodel->getShareCount();
        $jodelUserHandle = $jodel->getUserHandler();
        $jodelPostOwn = $jodel->getPostOwn();
        $jodelDistance = $jodel->getDistance();
        $jodelLocation = $jodel->getLocation();
        $jodelFromHome = $jodel->getFromHome();
        $jodelImageUrl = $jodel->getImageUrl();
        $jodelParent = $jodel->getParentId();
        //BindParams
        $queryPrepare->bindParam(":id", $jodelId);
        $queryPrepare->bindParam(":message", $jodelMessage);
        $queryPrepare->bindParam(":created_at", $jodelCreated);
        $queryPrepare->bindParam(":updated_at", $jodelUpdated);
        $queryPrepare->bindParam(":pin_count", $jodelPinCount);
        $queryPrepare->bindParam(":color", $jodelColor);
        $queryPrepare->bindParam(":thanks_count", $jodelThanksCount);
        $queryPrepare->bindParam(":child_count", $jodelChildCount);
        $queryPrepare->bindParam(":replier", $jodelReplier);
        $queryPrepare->bindParam(":discovered_by", $jodelDiscoveredBy);
        $queryPrepare->bindParam(":vote_count", $jodelVoteCount);
        $queryPrepare->bindParam(":share_count", $jodelShareCount);
        $queryPrepare->bindParam(":user_handle", $jodelUserHandle);
        $queryPrepare->bindParam(":post_own", $jodelPostOwn);
        $queryPrepare->bindParam(":distance", $jodelDistance);
        $queryPrepare->bindParam(":location", $jodelLocation);
        $queryPrepare->bindParam(":from_home", $jodelFromHome);
        $queryPrepare->bindParam(":image_url", $jodelImageUrl);
        $queryPrepare->bindParam(":parent", $jodelParent);
        if(!$queryPrepare->execute()) return false;
        return true;
    }
    public function getJodel($id)
    {
        $id = htmlspecialchars($id);
        $get = $this->connection->query("SELECT * FROM Posts WHERE id = '$id'")->fetch();
        $jodel = new Jodel();
        $jodel->setParentId($get["parent_id"]);
        $jodel->setPostId($get["id"]);
        $jodel->setMessage($get["message"]);
        $jodel->setImageUrl($get["image_url"]);
        $rnd = rand(1, 6);
        if($rnd == 1){
            $color = "ABDB0";
        }
        if($rnd == 2){
            $color = "FF9908";
        }
        if($rnd == 3){
            $color = "EC41C";
        }
        if($rnd == 4){
            $color = "FFBA00";
        }
        if($rnd == 5){
            $color = "06A3CB";
        }
        if($rnd == 6){
            $color = "DD5F5F";
        }
        $jodel->setColor($color);

        return $jodel;
    }

    public function getChildrenJodel($id)
    {
        $jodel = array();
        $id = htmlspecialchars($id);
        $get = $this->connection->query("SELECT * FROM Posts WHERE parent_id = '$id'");
        while($data = $get->fetch()){
            $jodel[] = $this->getJodel($data["id"]);
        }
        return $jodel;
    }

    public function getJodelArray($array){
        $jodel = array();
        $array = explode(',', $array);
//        var_dump($array);
        foreach ($array as $key){
            $key = str_replace(array("[\"", "\"]"), '', $key);
//            var_dump($key);
            $jodel[] = $this->getJodel($key);
        }
        return $jodel;
    }
}