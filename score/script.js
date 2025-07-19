const scores = {
    A: 80,
    B: 130,
    C: 130,
    D: 80,
    E1: 180,
    E2: 60,
    F1: 60,
    F2: 80,
    H1: 160,
    H2: -110,
};

function displayScores() {
    const scoreBoard = document.getElementById("score-board");
    scoreBoard.innerHTML = '';

    const sortedScores = Object.entries(scores).sort((a, b) => b[1] - a[1]);

    sortedScores.forEach(([block, score], index) => {
        const blockDiv = document.createElement("div");
        blockDiv.className = "block";
        blockDiv.innerHTML = `${block}: ${score}`;

        // Add trophy image for top three blocks
        if (index < 3) {
            const trophyImg = document.createElement("img");
            trophyImg.src = "images/trophy.png"; // Make sure trophy.png is in the images folder
            trophyImg.className = "trophy";
            blockDiv.appendChild(trophyImg);
            blockDiv.classList.add(index === 0 ? "fire-animation" : "magic-animation");
        }

        if (score === sortedScores[0][1]) {
            blockDiv.classList.add("highest");
        }
        scoreBoard.appendChild(blockDiv);
    });
}

// Call displayScores after DOM is fully loaded
window.addEventListener('DOMContentLoaded', displayScores);
