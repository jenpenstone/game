(function () {
    "use strict"

    let btnStartGame = document.getElementById("btnStart");
    let btnContinue = document.getElementById("btnContinue");
    let btnStop = document.getElementById("btnStop");
    let btnNewRound = document.getElementById("btnNewRound");

    btnStartGame.addEventListener("click", function(event) {
        btnStartGame.class = "hide";
        btnContinue.class = "";
        btnStop.class = "";
    });

    btnStartGame.addEventListener("click", function(event) {
        btnStartGame.classList.toggle("hide");
    });

})();
