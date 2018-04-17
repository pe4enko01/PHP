<?php

    $songQuery = mysqli_query($con,"SELECT * FROM Songs ORDER BY RAND() LIMIT 10");
    $resuttArray = [];
    while($row = mysqli_fetch_array($songQuery)){
        array_push($resuttArray, $row['id']);
    };

    $jsonArray = json_encode($resuttArray);

?>
<script>
    var currentPlaylist = [];
    var shufflePlaylist = [];
    var tempPlaylist =  [];

    var newPlaylist = <?= $jsonArray ?>;
    var repeat = false;
    var shuffle = false;
    $(document).ready(function(){

        audioElement = new Audio();
        setTrack(newPlaylist[0],newPlaylist,false);
        var mouseDown = false;


        $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove" , function(e){
            e.preventDefault();
        });

        $(".playbackBar .progressBar").mousedown(function(){
            mouseDown = true;
        });
        $(".playbackBar .progressBar").mousemove(function(e){
           if (mouseDown == true){
               timeFromOffset(e, this)
           };
        });
        $(".playbackBar .progressBar").mouseup(function(e){
                timeFromOffset(e, this);

        });

        $(".volumeBar .progressBar").mousedown(function(){
            mouseDown = true;
        });
        $(".volumeBar .progressBar").mousemove(function(e){
            if (mouseDown == true){
                var pers = e.offsetX / $(this).width();
                if(pers >= 0 && pers <= 1){
                    audioElement.audio.volume = pers;
                }
            };
        });
        $(".volumeBar .progressBar").mouseup(function(e){
            var pers = e.offsetX / $(this).width();
            if(pers >= 0 && pers <= 1){
                audioElement.audio.volume = pers;
            }
        });

        $(document).mouseup(function(){
            mouseDown = false;
        });

    });

    function timeFromOffset(mouse, progressBar){
        var percentage = mouse.offsetX/$(progressBar).width()*100;
        var seconds = audioElement.audio.duration * (percentage / 100);
        audioElement.setTime(seconds);
    };
    function prevSong(){
        if(audioElement.audio.currentTime >= 3 || currentIndex == 0){
            audioElement.setTime(0);
        }else{
            currentIndex -= 1;
            setTrack(currentPlaylist[currentIndex],currentPlaylist,true)
        }
    }
    function nextSong(){

        if (repeat == true){
            audioElement.setTime(0);
            playSong();
            return;
        };
        if(currentIndex == currentPlaylist.length - 1){
            currentIndex = 0;
        }else {
            currentIndex += 1;
        };
        var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
        setTrack(trackToPlay,currentPlaylist, true );
    };

    function setRepeat(){
        repeat = !repeat;
        var imageName = repeat ?  "repeat-active.png" : "repeat.png";
        $(".controlButton.repeat img").attr("src","assets/images/icons/" + imageName)
    };
    function setMute(){
        audioElement.audio.muted = !audioElement.audio.muted;
        var imageName = audioElement.audio.muted ?  "volume-mute.png" : "volume.png";
        $(".controlButton.volume img").attr("src","assets/images/icons/" + imageName)
    };
    function setShuffle(){
        shuffle = !shuffle;
        var imageName = shuffle ?  "shuffle-active.png" : "shuffle.png";
        $(".controlButton.shuffle img").attr("src","assets/images/icons/" + imageName);

        if(shuffle == true){
            shuffleArray(shufflePlaylist);
            currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaing.id)
        }else{
            currentIndex = currentlyPlaing.indexOf(audioElement.currentlyPlaing.id)
        }
    };

    function shuffleArray(a){
        var j,x,i;
        for(i=a.length;i;i--){
            j = Math.floor(Math.random() * i);
            x = a[i - 1];
            a[i - 1] = a[j];
            a[j] = x;
        };
    };

    function setTrack (trackId, newPlaylist, pla){

        if(newPlaylist != currentPlaylist){
            currentPlaylist = newPlaylist;
            shufflePlaylist = currentPlaylist.slice();
            shuffleArray(shufflePlaylist);
        };
        if(shuffle == true){
            currentIndex = shufflePlaylist.indexOf(trackId);
        }else{
            currentIndex = currentPlaylist.indexOf(trackId);
        }
        ;

        pauseSong();

        $.post("includes/ajax/getSongJson.php",{songId:trackId }, function(data){
            var track  = JSON.parse(data);

            $(".trackName span ").text(track.title);

            $.post("includes/ajax/getArtistJson.php",{artistId:track.artist }, function(data){
                var artist  = JSON.parse(data);
                $(".artistName span ").text(artist.name);
            });

            $.post("includes/ajax/getAlbumJson.php",{albumId:track.album }, function(data){
                var album  = JSON.parse(data);
                $(".albumArtwork").attr("src", album.artworkPath);
            });

           audioElement.setTrack(track.path);
           audioElement.current = track.id;
           console.log(audioElement.audio.duration);



            if(pla){

                audioElement.audio.play();
            };
        });

    };

    function playSong(){

        if( audioElement.audio.currentTime == 0){
            $.post("includes/ajax/updataPlays.php",{songId: audioElement.current});
        };

        $(".controlButton.play").hide();
        $(".controlButton.pause").show();
        audioElement.audio.play();
        console.log(audioElement.audio.duration);
    };

    function pauseSong(){
        $(".controlButton.play").show();
        $(".controlButton.pause").hide();
        audioElement.pause();
    };
    console.log(tempPlaylist)

</script>

<div id="nowPlayingBarContainer">

	<div id="nowPlayingBar">

		<div id="nowPlayingLeft">
			<div class="content">
				<span class="albumLink">
					<img src="" class="albumArtwork">
				</span>

				<div class="trackInfo">

					<span class="trackName">
						<span></span>
					</span>

					<span class="artistName">
						<span></span>
					</span>

				</div>



			</div>
		</div>

		<div id="nowPlayingCenter">

			<div class="content playerControls">

				<div class="buttons">

					<button class="controlButton shuffle" title="Shuffle button" onclick="setShuffle()">
						<img src="assets/images/icons/shuffle.png" alt="Shuffle">
					</button>

					<button class="controlButton previous" title="Previous button" onclick ="prevSong()">
						<img src="assets/images/icons/previous.png" alt="Previous">
					</button>

					<button class="controlButton play" title="Play button" onclick="playSong()">
						<img src="assets/images/icons/play.png" alt="Play">
					</button>

					<button class="controlButton pause" title="Pause button" style="display: none;" onclick="pauseSong()">
						<img src="assets/images/icons/pause.png" alt="Pause">
					</button>

					<button class="controlButton next" title="Next button " onclick="nextSong()">
						<img src="assets/images/icons/next.png" alt="Next">
					</button>

					<button class="controlButton repeat" title="Repeat button" onclick = "setRepeat()">
						<img src="assets/images/icons/repeat.png" alt="Repeat">
					</button>

				</div>


				<div class="playbackBar">

					<span class="progressTime current">0.00</span>

					<div class="progressBar">
						<div class="progressBarBg">
							<div class="progress"></div>
						</div>
					</div>

					<span class="progressTime remaining">0.00</span>


				</div>


			</div>


		</div>

		<div id="nowPlayingRight">
			<div class="volumeBar">

				<button class="controlButton volume" title="Volume button" onclick="setMute()">
					<img src="assets/images/icons/volume.png" alt="Volume">
				</button>

				<div class="progressBar">
					<div class="progressBarBg">
						<div class="progress"></div>
					</div>
				</div>

			</div>
		</div>




	</div>

</div>