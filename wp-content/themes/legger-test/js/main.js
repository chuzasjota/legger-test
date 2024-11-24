fetch('https://api.ipify.org?format=json')
        .then(response => response.json())
        .then(data => {
            document.getElementById('ip').value = data.ip;
})
.catch(error => console.error("Error al obtener la IP:", error));
