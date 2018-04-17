var mouseDown = false;
var repeat = false;

function formatTime(seconds){
    var time  = Math.round(seconds);
    var minets = Math.floor(time/60);
    var seconds = time - (minets * 60);

    var zero;

    if(seconds < 10){
        zero = "0"
    }else {
        zero = ""
    };

    return minets + ":"+ zero + seconds;
};

function updateTimeProgressBar(audio) {
    $(".progressTime.current").text(formatTime(audio.currentTime));
    $(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime));

    var progress = (audio.currentTime / audio.duration) * 100;

    $(".playbackBar .progress").css("width", progress + "%");

}

function updateVolumeProgressBar() {
    var vol = audioElement.audio.volume * 100;
    $(".volumeBar .progress").css("width",vol+"%");
}
function Audio() {


    this.audio = document.createElement('audio');

    this.audio.addEventListener("ended", function(){
        nextSong();
    })
    this.audio.addEventListener("volumechange", function(){
        updateVolumeProgressBar(this)
    })

    this.setTrack = function (src) {
        this.audio.src = src;
    };

    this.audio.addEventListener("canplay", function () {
        var duration = formatTime(this.duration);
        $(".progressTime.remaining").text(duration);
    });

    this.audio.addEventListener("timeupdate",function(){
        if(this.duration){
            updateTimeProgressBar(this);
        }
    })
    this.pause = function(){
        this.audio.pause();
    }
    
    this.setTime = function (seconds) {
        this.audio.currentTime = seconds;
    }
}
