
let mascota = {
    hambre: 70,
    higiene: 70,
    felicidad: 70,
    energia: 70,
    monedas: 0,
    nombre: "Michi"
};

function actualizar() {
    for (let estado of [
        "hambre",
        "higiene",
        "felicidad",
        "energia"
    ]) {
        document.getElementById(estado).value = mascota[estado];

        document.getElementById(estado + "Texto").textContent =
            mascota[estado] + "%";
    }

    document.getElementById("monedas").textContent =
        mascota.monedas;

    document.getElementById("nombre").textContent =
        mascota.nombre;


    const gato = document.getElementById("gato-img");


    if (gato) {
        if (mascota.energia < 20) {
            gato.alt = "Gato cansado";
        } else if (mascota.hambre < 20) {
            gato.alt = "Gato hambriento";
        } else if (mascota.felicidad < 20) {
            gato.alt = "Gato triste";
        } else {
            gato.alt = "Gato feliz";
        }
    }
}

async function accion(tipo) {
    let mensaje = "";

    if (tipo === "alimentar") {
        if (mascota.hambre >= 100) {
            mensaje = "¡Ya estoy lleno!";
        } else {
            mascota.hambre = Math.min(100, mascota.hambre + 25);
            mascota.felicidad = Math.min(100, mascota.felicidad + 5);
            mascota.monedas += 2;
            mensaje = "¡Miau! ¡Qué rica comida!";
        }
    } else if (tipo === "banar") {
        if (mascota.higiene >= 100) {
            mensaje = "¡Ya estoy limpio!";
        } else {
            mascota.higiene = Math.min(100, mascota.higiene + 30);
            mascota.felicidad = Math.max(0, mascota.felicidad - 3);
            mensaje = "¡Ahora estoy limpito!";
        }
    } else if (tipo === "jugar") {
        if (mascota.energia < 15) {
            mensaje = "Estoy cansado. ¡Necesito dormir!";
        } else {
            mascota.felicidad = Math.min(100, mascota.felicidad + 20);
            mascota.energia = Math.max(0, mascota.energia - 15);
            mascota.hambre = Math.max(0, mascota.hambre - 8);
            mascota.monedas += 3;
            mensaje = "¡Me encanta jugar contigo!";
        }
    } else if (tipo === "dormir") {
        mascota.energia = Math.min(100, mascota.energia + 35);
        mensaje = "Zzz... ¡Qué rico dormir!";
    }

    document.getElementById("mensaje").textContent = mensaje;

    actualizar();

    try {
        const respuesta = await fetch("guardar.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(mascota)
        });

        if (!respuesta.ok) {
            document.getElementById("mensaje").textContent =
                "No se pudo guardar el progreso.";
        }
    } catch (error) {
        console.error("Error al guardar:", error);
        document.getElementById("mensaje").textContent =
            "No se pudo conectar con PHP para guardar.";
    }
}

function cambiarNombre() {
    const nombre = prompt("¿Cómo quieres llamar a tu gato?");

    if (nombre && nombre.trim().length <= 20) {
        mascota.nombre = nombre.trim();

        document.getElementById("mensaje").textContent =
            "¡Me gusta mi nuevo nombre!";

        actualizar();
        guardarNombre();
    } else if (nombre !== null && nombre.trim() !== "") {
        alert("Escribe un nombre de máximo 20 caracteres.");
    }
}

async function guardarNombre() {
    try {
        const respuesta = await fetch("guardar.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(mascota)
        });

        if (!respuesta.ok) {
            console.error("No se pudo guardar el nombre.");
        }
    } catch (error) {
        console.error("Error al guardar el nombre:", error);
    }
}

actualizar();
function reproduciraudio(){
    const audio = document.getElementById("audioGato");
    audio.currentTime= 0;
    audio.play();
}
