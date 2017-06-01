<?php
/**
 * Created by PhpStorm.
 * User: bilipp
 * Date: 30.05.17
 * Time: 10:44
 */

namespace JodelWrapper;


class Jodel
{
    public $id;
    public $message;
    public $created_at;
    public $updated_at;
    public $color;
    public $pinCount;
    public $thanksCount;
    public $childCount;
    public $discovered_by;
    public $vote_count;
    public $share_count;
    public $user_handler;
    public $post_own;
    public $replier;
    public $distance;
    public $location;
    public $fromHome;
    public $image_url;
    public $parentId;
    public $post_id;

    /**
     * @return mixed
     */
    public function getPostId()
    {
        return $this->post_id;
    }

    /**
     * @param mixed $post_id
     */
    public function setPostId($post_id)
    {
        $this->post_id = $post_id;
    }

    /**
     * @return mixed
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * @param mixed $parentId
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    }

    /**
     * @return mixed
     */
    public function getImageUrl()
    {
        return $this->image_url;
    }

    /**
     * @param mixed $image_url
     */
    public function setImageUrl($image_url)
    {
        $this->image_url = $image_url;
    }


    /**
     * @return mixed
     */
    public function getShareCount()
    {
        return $this->share_count;
    }

    /**
     * @param mixed $share_count
     */
    public function setShareCount($share_count)
    {
        $this->share_count = $share_count;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function getPinCount()
    {
        return $this->pinCount;
    }

    /**
     * @param mixed $pinCount
     */
    public function setPinCount($pinCount)
    {
        $this->pinCount = $pinCount;
    }

    /**
     * @return mixed
     */
    public function getThanksCount()
    {
        return $this->thanksCount;
    }

    /**
     * @param mixed $thanksCount
     */
    public function setThanksCount($thanksCount)
    {
        $this->thanksCount = $thanksCount;
    }

    /**
     * @return mixed
     */
    public function getChildCount()
    {
        return $this->childCount;
    }

    /**
     * @param mixed $childCount
     */
    public function setChildCount($childCount)
    {
        $this->childCount = $childCount;
    }

    /**
     * @return mixed
     */
    public function getDiscoveredBy()
    {
        return $this->discovered_by;
    }

    /**
     * @param mixed $discovered_by
     */
    public function setDiscoveredBy($discovered_by)
    {
        $this->discovered_by = $discovered_by;
    }

    /**
     * @return mixed
     */
    public function getVoteCount()
    {
        return $this->vote_count;
    }

    /**
     * @param mixed $vote_count
     */
    public function setVoteCount($vote_count)
    {
        $this->vote_count = $vote_count;
    }

    /**
     * @return mixed
     */
    public function getUserHandler()
    {
        return $this->user_handler;
    }

    /**
     * @param mixed $user_handler
     */
    public function setUserHandler($user_handler)
    {
        $this->user_handler = $user_handler;
    }

    /**
     * @return mixed
     */
    public function getPostOwn()
    {
        return $this->post_own;
    }

    /**
     * @param mixed $post_own
     */
    public function setPostOwn($post_own)
    {
        $this->post_own = $post_own;
    }

    /**
     * @return mixed
     */
    public function getReplier()
    {
        return $this->replier;
    }

    /**
     * @param mixed $replier
     */
    public function setReplier($replier)
    {
        $this->replier = $replier;
    }

    /**
     * @return mixed
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param mixed $distance
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getFromHome()
    {
        return $this->fromHome;
    }

    /**
     * @param mixed $fromHome
     */
    public function setFromHome($fromHome)
    {
        $this->fromHome = $fromHome;
    }

}