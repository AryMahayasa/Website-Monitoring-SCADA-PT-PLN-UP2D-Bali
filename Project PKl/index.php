<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Padam Real-Time</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <!-- Tambahkan elemen div untuk menampilkan peta -->
    <div id="map" style="height: 400px;"></div>

    <!-- Skrip JavaScript -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        // Fungsi untuk memperbarui peta dengan data padam
        function updateMapWithOutages(outagesData) {
            // Hapus semua marker pada peta (jika ada)
            for (const marker of markers) {
                marker.remove();
            }
            markers = [];

            // Loop melalui data padam dan tambahkan marker untuk setiap lokasi padam
            for (let outage of outagesData) {
                const lat = parseFloat(outage.lat);
                const lng = parseFloat(outage.lng);
                const description = outage.description;

                // Tambahkan marker pada peta untuk setiap lokasi padam
                const marker = L.marker([lat, lng]).addTo(map);
                marker.bindPopup(description);
                markers.push(marker);
            }
        }

        // Fungsi untuk mendapatkan data padam dari server (menggunakan AJAX)
        function getOutagesDataFromServer() {
            fetch("get_outages_data.php")
                .then(response => response.json())
                .then(outagesData => updateMapWithOutages(outagesData))
                .catch(error => console.error("Error fetching outage data:", error));
        }

        // Fungsi untuk memperbarui peta secara berkala (setiap 10 detik)
        function updateMapPeriodically() {
            getOutagesDataFromServer();
        }

        // Panggil fungsi updateMapPeriodically setiap 10 detik
        setInterval(updateMapPeriodically, 10000); // 10000 ms = 10 detik

        // Inisialisasi peta menggunakan Leaflet.js
        const map = L.map('map').setView([-8.4547, 115.0694], 9); // Ganti dengan koordinat awal peta
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        // Array untuk menyimpan marker pada peta
        let markers = [];
    </script>
</body>
</html>
