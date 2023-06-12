// resources/js/sound.js
function playSound() {
    var audio = new Audio(asset('sound/chatify/new-message-sound.mp3'));
    audio.play();
}

// Trigger the playSound function when the event is received
Echo.channel('popup-channel')
    .listen('user-register', function (data) {
        playSound();
        // Handle the event data as needed
    });