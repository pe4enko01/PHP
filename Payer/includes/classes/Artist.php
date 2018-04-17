<?php
/**
 * Created by PhpStorm.
 * User: pe4en
 * Date: 10.02.2018
 * Time: 15:55
 */

class Artist
{
    private $con;
    private $id;
    Private $name;

    public function __construct($con,$id)
    {
        $this->con = $con;
        $this->id = $id;
    }
    public function getName(){
        $artistQuery = mysqli_query($this->con,"SELECT name FROM artists WHERE id='$this->id'");
        $artist = mysqli_fetch_array($artistQuery);
        return $artist['name'];
    }
}