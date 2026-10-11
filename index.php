
<?php
session_start();

if (!isset($_SESSION['michi'])) {
    $_SESSION['michi'] = [
        'nombre' => 'Michi',
        'hambre' => 70,
        'higiene' => 70,
        'felicidad' => 70,
        'energia' => 70,
        'monedas' => 0
    ];
}

$mascota = $_SESSION['michi'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Tamagotchi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<main class="juego">
    <h1>🐾 Mi Tamagotchi Felino</h1>

    <div class="pantalla">
        <h2 id="nombre"><?= htmlspecialchars($mascota['nombre']) ?></h2>

        <div id="gato">
            <img src="/imag/cat.png" alt="logo">
        </div>

        <p id="mensaje">¡Hola! Vamos a jugar.</p>

        <div class="estadistica">
            <label>🍗 Hambre</label>
            <progress id="hambre" max="100"
                value="<?= $mascota['hambre'] ?>"></progress>
            <span id="hambreTexto"><?= $mascota['hambre'] ?>%</span>
        </div>

        <div class="estadistica">
            <label>🧼 Higiene</label>
            <progress id="higiene" max="100"
                value="<?= $mascota['higiene'] ?>"></progress>
            <span id="higieneTexto"><?= $mascota['higiene'] ?>%</span>
        </div>

        <div class="estadistica">
            <label>❤️ Felicidad</label>
            <progress id="felicidad" max="100"
                value="<?= $mascota['felicidad'] ?>"></progress>
            <span id="felicidadTexto"><?= $mascota['felicidad'] ?>%</span>
        </div>

        <div class="estadistica">
            <label>⚡ Energía</label>
            <progress id="energia" max="100"
                value="<?= $mascota['energia'] ?>"></progress>
            <span id="energiaTexto"><?= $mascota['energia'] ?>🪙</span>
        </div>

        <p>🪙 Monedas: <strong id="monedas"><?= $mascota['monedas'] ?></strong></p>

        <div class="botones">
            <button onclick="reproduciraudio(); accion('alimentar')">🍗 Alimentar</button>
            <button onclick="reproduciraudio(); accion('banar')">🧼 Bañar</button>
            <button onclick="reproduciraudio(); accion('jugar')">🧶 Jugar</button>
            <button onclick="reproduciraudio(); accion('dormir')">🛏️ Dormir</button>
            <audio id="audioGato" src="audio/catto.mp3" preload="auto"></audio>
        </div>

        <button class="nombreBoton" onclick="cambiarNombre()">
            ✏️ Cambiar nombre
        </button>
    </div>
</main>

<script src="script.js"></script>
</body>
</html>