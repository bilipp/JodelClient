<?php
/**
 * Created by PhpStorm.
 * User: bilipp
 * Date: 30.05.17
 * Time: 12:26
 */

namespace JodelWrapper;

use JodelWrapper\Jodel;
use JodelWrapper\Database;


class Provider
{
    protected $access_token = "83675738-da691805-86deb3c9-d41b-445c-a1f7-64b7bdf9a0fc";

    public $all_jodel;
    protected $type;
    protected $cached;

    public function __construct($type, $cached = false)
    {
        $this->type = $type;
        $this->cached = $cached;
        $this->database = new Database();
    }

    public function makeRequest($after = null)
    {
        $ch = curl_init();
        if(!empty($after)) {
            curl_setopt($ch, CURLOPT_URL, "https://api.go-tellm.com/api/v2/posts/location/popular?limit=500&access_token=" . $this->access_token);
        }
        else{
            curl_setopt($ch, CURLOPT_URL, "https://api.go-tellm.com/api/v2/posts/location/?limit=500&access_token=" . $this->access_token);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = [
            'Host: api.go-tellm.com:443',
            'Accept: */*',
            'Connection: keep-alive',
            'X-Client-Type: ios_3.57',
            'X-Api-Version: 0.2',
            'User-Agent: Jodel/3.57 (iPhone; iOS 10.3.2; Scale/2.00)',
            'X-Location: 52.5243/13.4105',
            'Accept-Language: de-DE;q=1',
            'Accept-Encoding: gzip, deflate'
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $jodel_data = curl_exec($ch);
        curl_close($ch);

        return $jodel_data;
    }
    public function getJodel($after = null)
    {
        if($this->cached){
            $jodel_data = file_get_contents('./example.json');
        }
        else{
            $jodel_data = $this->makeRequest($after);
        }
        $post_data = json_decode($jodel_data, true)["posts"];
        $i = 0;
        foreach ($post_data as $key => $post){
            $jodel = new Jodel();
            $jodelId = $post["post_id"];
//            var_dump($jodelId);
            $jodel->setId($jodelId);
            $jodel->setMessage($post["message"]);
            $jodel->setCreatedAt($post["created_at"]);
            $jodel->setUpdatedAt($post["updated_at"]);
            $jodel->setPinCount($post["pin_count"]);
            $jodel->setColor($post["color"]);
            $jodel->setThanksCount($post["thanks_count"]);
            $jodel->setChildCount($post["child_count"]);
            $jodel->setReplier($post["replier"]);
            $jodel->setDiscoveredBy($post["discovered_by"]);
            $jodel->setVoteCount($post["vote_count"]);
            $jodel->setShareCount($post["share_count"]);
            $jodel->setUserHandler($post["user_handle"]);
            $jodel->setPostOwn($post["post_own"]);
            $jodel->setDistance($post["distance"]);
            $jodel->setLocation($post["location"]["name"]);
            $jodel->setFromHome($post["from_home"]);
            $jodel->setImageUrl($post["image_url"]);
            $this->database->insertJodel($jodel);
            $i++;
        }
        return;
    }
}