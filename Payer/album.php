<?php
include("includes/header.php");

if(isset($_GET['id'])){
    $albumId = $_GET['id'];
}else{
    echo '<script>location.replace("index.php");</script>';
};


    $album = new Album ($con,$albumId);
    $artist = $album->getArtist();

//    echo $album->getTitle() . "<br>";
//    echo $artist->getName();
?>

<div class="entityInfo">
    <div class="leftSection">
        <img src="<?php echo $album->getArtworkPath()?>">
    </div>
    <div class="rightSection">
        <h2><?php echo $album->getTitle(); ?></h2>
        <p>By <?php echo $artist->getName()?></p>
        <p><?php echo $album->getNumberOfSongs()?> songs</p>
            
    </div>
</div>

<div class="tracklictContainer">
    <ul>
        <?php
            $songIdArray = $album->gerSongId();
            $i = 1;
            foreach($songIdArray as $songId){
                $albumSong = new Song ($con, $songId);
                $albumArtist = $albumSong->getArtist();
                $albumm = new Album ($con,$songId);


                echo "<li class = 'tracklistRow'>
                        <div class = 'trackCount'>
                            <img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"". $albumSong->getId() ."\",tempPlaylist,true)'>
                            <span class='trackNumber'>".$i."</span>
                        </div>
                        
                        <div class='trackInfo'>
                        <span class='trackName'>
                            ".$albumm->getNAmeOfSong()."
                        </span>
                        <span class='artistName'>
                             ".$albumArtist->getName()."
                        </span>
                        </div>
                        <div class='trackOptions'>
                            <img class='optionButton' src = 'assets/images/icons/more.png'>
                        </div>
                        <div class='trackDuration'>
                            <span class='duration'>".$albumSong->getDuration()."</span>
                        </div>
                        </li>";
                $i++;
            }

        ?>

    </ul>
</div>

<?php include("includes/footer.php"); ?>
<script>

    var tempSongIds = '<?php echo json_encode($songIdArray);?>';
    tempPlaylist = JSON.parse(tempSongIds);
    console.log()
</script>
