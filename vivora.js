


  // Constantes
  const CANVAS_SIZE = 400;
  const CELL_SIZE = 10;
  const SNAKE_COLOR = "#00FF00";
  const FOOD_COLOR = "#FF0000";
  const BACKGROUND_COLOR = "#333";

  // Variables
  let snake = [[10, 10]];
  let food = [Math.floor(Math.random() * (CANVAS_SIZE / CELL_SIZE)), Math.floor(Math.random() * (CANVAS_SIZE / CELL_SIZE))];
  let direction = "right";
  let score = 0;
  let gameInterval;

  // Obtener el elemento canvas
  const canvas = document.getElementById("snakeCanvas");
  const ctx = canvas.getContext("2d");

  // Función para dibujar la víbora
  function drawSnake() {
    ctx.clearRect(0, 0, CANVAS_SIZE, CANVAS_SIZE);
    ctx.fillStyle = BACKGROUND_COLOR;
    ctx.fillRect(0, 0, CANVAS_SIZE, CANVAS_SIZE);

    ctx.fillStyle = SNAKE_COLOR;
    snake.forEach(segment => {
      ctx.fillRect(segment[0] * CELL_SIZE, segment[1] * CELL_SIZE, CELL_SIZE, CELL_SIZE);
    });

    ctx.fillStyle = FOOD_COLOR;
    ctx.fillRect(food[0] * CELL_SIZE, food[1] * CELL_SIZE, CELL_SIZE, CELL_SIZE);

    ctx.font = "16px Arial";
    ctx.fillStyle = "#fff";
    ctx.fillText("Puntuación: " + score, 10, 20);
  }

  // Función para mover la víbora
  function moveSnake() {
    const head = [...snake[0]];
    switch (direction) {
      case "up":
        head[1]--;
        break;
      case "down":
        head[1]++;
        break;
      case "left":
        head[0]--;
        break;
      case "right":
        head[0]++;
        break;
    }

    // Verificar si la víbora choca con los bordes
    if (
      head[0] < 0 ||
      head[0] >= CANVAS_SIZE / CELL_SIZE ||
      head[1] < 0 ||
      head[1] >= CANVAS_SIZE / CELL_SIZE
    ) {
      gameOver();
      return;
    }

    // Verificar si la víbora se come a sí misma
    if (snake.some((segment, index) => index !== 0 && segment[0] === head[0] && segment[1] === head[1])) {
      gameOver();
      return;
    }

    snake.unshift(head);

    // Verificar si la víbora come la comida
    if (head[0] === food[0] && head[1] === food[1]) {
      score++;
      // Generar una nueva posición de comida
      food = [Math.floor(Math.random() * (CANVAS_SIZE / CELL_SIZE)), Math.floor(Math.random() * (CANVAS_SIZE / CELL_SIZE))];
    } else {
      snake.pop();
    }

    drawSnake();
  }

  // Función para manejar el inicio del juego
  function startGame() {
    gameInterval = setInterval(moveSnake, 100);
  }

  // Función para manejar el reinicio del juego
  function resetGame() {
    clearInterval(gameInterval);
    snake = [[10, 10]];
    food = [Math.floor(Math.random() * (CANVAS_SIZE / CELL_SIZE)), Math.floor(Math.random() * (CANVAS_SIZE / CELL_SIZE))];
    direction = "right";
    score = 0;
    drawSnake();
  }

  // Función para manejar el final del juego
  function gameOver() {
    clearInterval(gameInterval);
    alert("Game Over! Tu puntuación es: " + score);
    resetGame();
  }

  // Manejo de eventos
  document.getElementById("startButton").addEventListener("click", startGame);
  document.getElementById("resetButton").addEventListener("click", resetGame);

  // Manejo de los eventos de teclado
  document.addEventListener("keydown", (event) => {
    switch (event.key) {
      case "ArrowUp":
        if (direction !== "down") {
          direction = "up";
        }
        break;
      case "ArrowDown":
        if (direction !== "up") {
          direction = "down";
        }
        break;
      case "ArrowLeft":
        if (direction !== "right") {
          direction = "left";
        }
        break;
      case "ArrowRight":
        if (direction !== "left") {
          direction = "right";
        }
        break;
    }
  });
