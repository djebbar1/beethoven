var player = $('.vinyl-player'),
    audio = player.find('audio'),
    duration = $('.duration'),
    currentTime = $('.current-time'),
    progressBar = $('.progress span'),
    mouseDown = false,
    rewind, showCurrentTime;

function secsToMins(time) {
  var int = Math.floor(time),
      mins = Math.floor(int / 60),
      secs = int % 60,
      newTime = mins + ':' + ('0' + secs).slice(-2);
  
  return newTime;
}

function getCurrentTime() {
  var currentTimeFormatted = secsToMins(audio[0].currentTime),
      currentTimePercentage = audio[0].currentTime / audio[0].duration * 100;
  
  currentTime.text(currentTimeFormatted);
  progressBar.css('width', currentTimePercentage + '%');
  
  if (player.hasClass('playing')) {
    showCurrentTime = requestAnimationFrame(getCurrentTime);
  } else {
    cancelAnimationFrame(showCurrentTime);
  }
}

audio.on('loadedmetadata', function() {
  var durationFormatted = secsToMins(audio[0].duration);
  duration.text(durationFormatted);
}).on('ended', function() {
  if ($('.repeat').hasClass('active')) {
    audio[0].currentTime = 0;
    audio[0].play();
  } else {
    player.removeClass('playing').addClass('paused');
    audio[0].currentTime = 0;
  }
});

$('button').on('click', function() {
  var self = $(this);
  
  if (self.hasClass('play-pause') && player.hasClass('paused')) {
    player.removeClass('paused').addClass('playing');
    audio[0].play();
    getCurrentTime();
  } else if (self.hasClass('play-pause') && player.hasClass('playing')) {
    player.removeClass('playing').addClass('paused');
    audio[0].pause();
  }
  
  if (self.hasClass('shuffle') || self.hasClass('repeat')) {
    self.toggleClass('active');
  }
}).on('mousedown', function() {
  var self = $(this);
  
  if (self.hasClass('ff')) {
    player.addClass('ffing');
    audio[0].playbackRate = 2;
  }
  
  if (self.hasClass('rw')) {
    player.addClass('rwing');
    rewind = setInterval(function() { audio[0].currentTime -= .3; }, 100);
  }
}).on('mouseup', function() {
  var self = $(this);
  
  if (self.hasClass('ff')) {
    player.removeClass('ffing');
    audio[0].playbackRate = 1;
  }
  
  if (self.hasClass('rw')) {
    player.removeClass('rwing');
    clearInterval(rewind);
  }
});

player.on('mousedown mouseup', function() {
  mouseDown = !mouseDown;
});

progressBar.parent().on('click mousemove', function(e) {
  var self = $(this),
      totalWidth = self.width(),
      offsetX = e.offsetX,
      offsetPercentage = offsetX / totalWidth;
  
  if (mouseDown || e.type === 'click') {
    audio[0].currentTime = audio[0].duration * offsetPercentage;
    if (player.hasClass('paused')) {
      progressBar.css('width', offsetPercentage * 100 + '%');
    }
  }
});
alert('toto');

/*var audio = document.getElementById("vinyl");

function myFunction() { 
  alert(audio.currentSrc);
} 


$(document).ready(function() {

    var armElement = $('.vinyl-player .player-container .player .player-element.player-element-tonearm svg');
    var vinylElement = $('.vinyl-player .player-container .player .player-element.player-element-lp svg');

    function armPositionStart() {

        armElement.velocity({
            rotateZ: "25deg"
        }, {
            duration: 1200,
            easing: "linear"
        });

    }

    function recordPlaying() {

        // Use with local tracks only
        // var trackDuration = audio.duration;
      
        var trackDuration = $('li.current-track').attr('data-duration');

        armElement.velocity({
            rotateZ: "45deg"
        }, {
            duration: (trackDuration * 1000),
            easing: "linear"
        });

        vinylElement.velocity({
            rotateZ: "+=360deg"
        }, {
            duration: 1820,
            easing: "linear",
            loop: true,
            delay: 0
        });

    }

    function armPositionReset() {

        armElement.velocity('stop');
        armElement.velocity({
            rotateZ: "25deg"
        }, {
            duration: 1200,
            easing: "linear"
        });

    }

    function recordPausing() {

        armElement.velocity('stop');
        vinylElement.velocity('stop', true);

    }

    function recordStopping() {

        vinylElement.velocity('stop', true);
        armElement.velocity('stop');
        armElement.velocity({
            rotateZ: "0deg"
        }, {
            duration: 1500,
            easing: "linear"
        });

    }

    var audio = $('.vinyl-player')[0]
        firstTrack = $('.player-playlist').find('li:first-child'),
        lastTrack = $('.player-playlist').find('li:last-child')
    ;

    $('.vinyl-player .player-button-play').click(function() {

        $(this).addClass('paused');
        $('.player-button-pause').addClass('paused');

        if (audio.currentTime > 0 && audio.paused) {

            recordPlaying();
            audio.play();

        }
        else {

            armPositionStart();

            firstTrack.addClass('current-track');
            $('.vinyl-player').attr('src', firstTrack.attr('data-src'));
            $('.player-element-lp').find('image').attr('xlink:src', firstTrack.attr('data-src'));

            setTimeout(function() {
                recordPlaying();
                audio.play();
            }, 1500);
        }

    });

    $('.player-button-pause').click(function() {

        recordPausing();

        $(this).removeClass('paused');
        $('.player-button-play').removeClass('paused');
        audio.pause();

    });

    $('.player-button-stop').click(function() {

        $('li.current-track').removeClass('current-track');
        $('.player-button-play, .player-button-pause').removeClass('paused');

        audio.pause();
        audio.currentTime = 0;

        recordStopping();

    });

    $('.player-button-prev').click(function() {

        if ( $('li.current-track').length ) {

            armPositionReset();

            var currentTrack = $('li.current-track'),
                prev = (currentTrack.is(':first-child')) ? lastTrack : currentTrack.prev(),
                prevTrack = prev.attr('data-track'),
                prevArtwork = prev.attr('data')
            ;
            currentTrack.removeClass('current-track');

        }
        else {

            armPositionStart();

            var prev = firstTrack,
                prevTrack = prev.attr('data-track'),
                prevArtwork = prev.attr('data')
            ;
        }

        $('.vinyl-player .player-button-play:not(.paused)').addClass('paused');
        $('.player-button-pause:not(.paused)').addClass('paused');

        prev.addClass('current-track');

        $('.vinyl-player').attr('src', prevTrack);
        $('.player-element-lp').find('image').attr('xlink:src', prevArtwork);

        audio.pause();
        audio.load();

        setTimeout(function() {
            recordPlaying();
            audio.oncanplaythrough = audio.play();
        }, 2000);

    });

    $('.player-button-next').click(function() {

        if ( $('li.current-track').length ) {

            armPositionReset();

            var currentTrack = $('li.current-track'),
                next = (currentTrack.is(':last-child')) ? firstTrack : currentTrack.next(),
                nextTrack = next.attr('data-track'),
                nextArtwork = next.attr('data')
            ;
            currentTrack.removeClass('current-track');
        }
        else {

            armPositionStart();

            var next = firstTrack,
                nextTrack = next.attr('data-track'),
                nextArtwork = next.attr('data')
            ;
        }

        $('.player-button-play:not(.paused)').addClass('paused');
        $('.player-button-pause:not(.paused)').addClass('paused');

        next.addClass('current-track');

        $('.vinyl-player').attr('src', nextTrack);
        $('.player-element-lp').find('image').attr('xlink:src', nextSrc);

        audio.pause();
        audio.load();

        setTimeout(function() {
            recordPlaying();
            audio.oncanplaythrough = audio.play();
        }, 2000);

    });

    $('.player-playlist').find('li').click(function() {

        selectedTrack = $(this);

        if ( $('li.current-track').length ) {

            armPositionReset();

            $('li.current-track').removeClass('current-track');

            selectedTrack.addClass('current-track');

        }
        else {

            armPositionStart();

            selectedTrack.addClass('current-track');
            $('.vinyl-player').attr('src', selectedTrack.attr('data-track'));
            $('.player-element-lp').find('image').attr('xlink:src', selectedTrack.attr('data-src'));
        }

        $('.player-button-play:not(.paused)').addClass('paused');
        $('.player-button-pause:not(.paused)').addClass('paused');

        audio.pause();
        audio.load();

        setTimeout(function() {
            recordPlaying();
            audio.oncanplaythrough = audio.play();
        }, 1500);
    });

    audio.addEventListener('ended', function(){

        var currentTrack = $('li.current-track');

        if (currentTrack.is(':last-child')) {

            currentTrack.removeClass('current-track');
            $('.player-button-play, .player-button-pause').removeClass('paused');

            audio.pause();
            audio.currentTime = 0;

            recordStopping();

        }
        else {

            armPositionReset();
            
            var next = currentTrack.next(),
                nextTrack = next.attr('data-track'),
                nextArtwork = next.attr('data')
            ;

            currentTrack.removeClass('current-track');
            next.addClass('current-track');

            $('.vinyl-player').attr('src', nextTrack);
            $('.player-element-lp').find('image').attr('xlink:src', nextSrc);

            audio.pause();
            audio.load();

            setTimeout(function() {
                recordPlaying();
                audio.oncanplaythrough = audio.play();
            }, 3000);

        }

    });

});*/