<?php
include './koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include './layout/head.php'; ?>
    <title>SIG Lanjut</title>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
</head>

<body class="g-sidenav-show bg-gray-100">
    <div class="min-height-600 bg-success position-absolute w-100 h-100 h-100"></div>
    <?php
    $active = "dashboard";
    include './layout/sidebar.php';
    ?>
    <main class="main-content position-relative border-radius-lg">

        <div class="container-fluid">
            <div class="container-fluid py-4 d-flex justify-content-center align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-24">
                            <div class="card mb-4 px-4">
                                <h3>Scanner</h3>
                                <div class="card-body px-0 pt-0 pb-2">
                                    <div id="reader" width="600px"></div>
                                    <!-- <input type="file" id="qr-input-file" accept="image/*"> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <div class="card z-index-3">
                                <div class="card-body p-2">
                                    <form action="#" id="searchform">
                                        <!-- Kontrol untuk mengubah radius -->
                                        <div class="form-group d-flex">
                                            <label class="h6 text-nowrap">Product ID: </label>
                                            <input type="number" class="form-control form-control-sm p-0 ps-1 ms-2" id="cameraValue" value="8996001600269" />
                                        </div>

                                        <!-- <div class="form-group d-flex">
                                            <label class="h6 text-nowrap">Nama: </label>
                                            <input type="number" class="form-control form-control-sm p-0 ps-1 ms-2" id="" value="" />
                                        </div>

                                        <div class="form-group d-flex">
                                            <label class="h6 text-nowrap">Kategori: </label>
                                            <input type="number" class="form-control form-control-sm p-0 ps-1 ms-2" id="" value="" />
                                        </div>

                                        <div class="form-group d-flex">
                                            <label class="h6 text-nowrap">Jumlah: </label>
                                            <input type="number" class="form-control form-control-sm p-0 ps-1 ms-2" id="" value="" />
                                        </div>

                                        <div class="form-group d-flex">
                                            <label class="h6 text-nowrap">Harga: </label>
                                            <input type="number" class="form-control form-control-sm p-0 ps-1 ms-2" id="" value="" />
                                        </div>

                                        <div class="form-group d-flex">
                                            <label class="h6 text-nowrap">Toko: </label>
                                            <input type="number" class="form-control form-control-sm p-0 ps-1 ms-2" id="" value="" />
                                        </div> -->
                                        <div class="app container">
                                            <label for="radiusInput">
                                                <h4 class="h4 m-0">Radius</h4>
                                            </label>
                                            <input class="w-100 m-0" type="range" id="radiusInput" min="10" max="10000" step="10" value="2000">
                                            <span id="radiusValue">2000</span> Meter
                                            <button class="btn btn-success" type="submit">Submit</button>
                                            <div class="row mt-4">
                                                <div class="card z-index-3" id="map">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mt-4">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h4>Detail Produk dan Toko</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><b>Nama Produk</b></th>
                                            <th><b>Nama Toko</b></th>
                                            <th><b>Latitude</b></th>
                                            <th><b>Longitude</b></th>
                                            <th><b>Harga</b></th>
                                            <th><b>Aksi</b></th>
                                        </tr>
                                    </thead>
                                    <tbody id="shopDetailsTable">
                                        <!-- Dynamic rows will be appended here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        let productID = document.getElementById('cameraValue');
        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 10,
                qrbox: {
                    width: 200,
                    height: 120
                }
            },
            /* verbose= */
            false);
        html5QrcodeScanner.render((decodedText, decodedResult) => {
            productID.value = decodedText;
            p.value = decodedText;
        }, (error) => {
            console.warn(`Code scan error = ${error}`);
        });
        let map,
            userLocation,
            circle,
            advancedMarkers = [],
            AdvanceMarker;

        let radiusInput = document.getElementById('radiusInput');
        let radiusValue = document.getElementById('radiusValue');

        if (navigator.geolocation) {
            console.log("mengambil data lokasi...");
            navigator.geolocation.getCurrentPosition((position) => {
                    userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };
                    console.log("Lokasi Ditemukan!\nLat: ", position.coords.latitude, "\nLng: ", position.coords.longitude);
                },
                (error) => {
                    // Penanganan error
                    switch (error.code) {
                        case error.PERMISSION_DENIED:
                            alert("Pengguna menolak permintaan Geolocation.");
                            break;
                        case error.POSITION_UNAVAILABLE:
                            alert("Informasi lokasi tidak tersedia.");
                            break;
                        case error.TIMEOUT:
                            alert("Permintaan mengambil lokasi mengalami timeout.");
                            break;
                        case error.UNKNOWN_ERROR:
                            alert("Terjadi kesalahan yang tidak diketahui.");
                            break;
                    }
                }, {
                    enableHighAccuracy: true, // Menggunakan GPS atau metode yang lebih akurat
                    timeout: 10000, // Timeout jika tidak bisa mengambil lokasi dalam 10 detik
                    maximumAge: 0 // Tidak menggunakan cache, selalu mengambil lokasi terbaru
                }
            )
        } else {
            alert("Geolocation is not supported by this browser.\nstart using defailt value");
        }

        async function initMap() {
            // Request needed libraries.
            const {
                Map
            } = await google.maps.importLibrary("maps");
            const {
                AdvancedMarkerElement
            } = await google.maps.importLibrary("marker");
            AdvanceMarker = AdvancedMarkerElement;
            //draw map

            map = new Map(document.getElementById('map'), {
                center: userLocation,
                zoom: 13,
                mapId: 'storied-deck-432408-h3'
            });

            // marker mySelf
            new AdvancedMarkerElement({
                map,
                position: userLocation,
                title: "Lokasi Anda",
            });

            circle = new google.maps.Circle({
                map: map,
                radius: parseInt(radiusInput.value), // Radius dari input range
                center: userLocation,
                fillColor: '#AA0000',
                fillOpacity: 0.2,
                strokeColor: '#AA0000',
                strokeOpacity: 0.5,
                strokeWeight: 2
            });

            // Event listener untuk mengubah radius ketika input berubah
            radiusInput.addEventListener('input', function() {
                const newRadius = parseInt(radiusInput.value);
                radiusValue.textContent = newRadius;
                circle.setRadius(newRadius);
                // fetchDataAndDisplayPOI(); // Refresh PoI sesuai radius baru
            });

            // pilih posisi intu input
            google.maps.event.addListener(advancedMarkers, 'position_changed', function() {
                const lat = marker.getPosition().lat();
                const lng = marker.getPosition().lng();
                circle.setCenter({
                    lat,
                    lng
                });
                // fetchDataAndDisplayPOI(); //data marker in radius berubah secara realtime
                console.log(circle.getCenter().lat(), circle.getCenter().lng());
            });

            map.addListener('click', (event) => {
                marker.setPosition(event.latLng);
            });
        }

        function drawCircle(lat, lng) {
            let center = new google.maps.LatLng(-0.899187, 109.349460);
        }

        // Form submission handler
        document.getElementById("searchform")
            .addEventListener("submit", async function(event) {
                event.preventDefault();
                console.log("go submit...");

                fetch(`<?= $url ?>ambil.php?id=${productID.value}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log("Masuk ke Fetching...");
                        console.log(data);
                        const shops = data.filter(shop => {
                            const distance = calculateDistance({
                                lat: circle.getCenter().lat(),
                                lng: circle.getCenter().lng()
                            }, {
                                lat: shop.lat,
                                lng: shop.lng
                            });

                            //tambahkan data distance
                            shop.distance = distance;
                            return distance <= circle.getRadius(); // Filter berdasarkan radius lingkaran saat ini
                        });

                        // // Sort by harga (cheapest first)
                        shops.sort((a, b) => a.harga - b.harga);
                        console.log("sort by harga: ", shops);

                        clearMarkers();
                        showShops(shops, parseInt(radiusInput.value));
                        // findCheapestShop(shops);
                    });
            })



        // Clear previous markers
        function clearMarkers() {
            advancedMarkers.forEach((marker) => (
                marker.map = null
            ));
            advancedMarkers = [];
        }

        // Show shops within range using AdvancedMarkerElement
        function showShops(shops, range) {
            // Clear previous table data
            const shopDetailsTable = document.getElementById("shopDetailsTable");
            shopDetailsTable.innerHTML = ""; // Clear existing table rows

            let bounds = new google.maps.LatLngBounds();
            console.log("range: ", range, typeof(range));
            console.log("userLocation", userLocation);

            let marker;
            shops.forEach((shop, index) => {
                if (shop.distance <= range) {
                    const shopLocation = new google.maps.LatLng(shop.lat, shop.lng);

                    // Hitung jarak antara lokasi pengguna dan toko
                    const distanceInMeters = calculateDistance(userLocation, {
                        lat: shop.lat,
                        lng: shop.lng,
                    });
                    const distanceInKm = (distanceInMeters / 1000).toFixed(2); // Konversi ke km dengan 2 desimal

                    // Tambahkan baris baru ke tabel
                    const row = document.createElement("tr");
                    row.innerHTML = `
                <td>${shop.namaproduk}</td>
                <td>${shop.toko}</td>
                <td>${shop.lat}</td>
                <td>${shop.lng}</td>
                <td>Rp. ${shop.harga.toLocaleString('id-ID')}</td>
                <td>
                    <button 
                        class="btn btn-success btn-sm" 
                        title="Lihat Lokasi" 
                        style="display: flex; align-items: center; justify-content: center; padding: 5px; border-radius: 4px;">
                        <img 
                            src="https://img.icons8.com/ios-filled/16/FFFFFF/visible.png" 
                            alt="Lihat" 
                            style="width: 16px; height: 16px; margin-right: 4px;">
                        Lihat
                    </button>
                </td>
            `;
                    shopDetailsTable.appendChild(row);

                    // Add click event to the button to zoom and draw polyline
                    const viewButton = row.querySelector("button");
                    viewButton.addEventListener("click", () => {
                        map.setZoom(15); // Set desired zoom level
                        map.panTo(shopLocation); // Center map to shop's location

                        // Remove existing polyline
                        if (routeLine) {
                            routeLine.setMap(null);
                        }

                        // Create new polyline
                        routeLine = new google.maps.Polyline({
                            path: [userLocation, shopLocation], // Start and end points
                            geodesic: true,
                            strokeColor: "#FF0000",
                            strokeOpacity: 0.8,
                            strokeWeight: 4,
                        });

                        // Add polyline to the map
                        routeLine.setMap(map);

                        // Display distance
                        alert(`Jarak ke ${shop.toko}: ${distanceInKm} km`);
                    });

                    // Create AdvancedMarkerElement
                    marker = new AdvanceMarker({
                        position: shopLocation,
                        map: map,
                        content: null,
                    });
                    advancedMarkers.push(marker);
                    bounds.extend(userLocation);
                    bounds.extend(shopLocation);
                }
            });

            console.log("marker: ", marker);
            map.fitBounds(bounds);
        }


        //find cheapest
        function findCheapestShop(shops) {
            console.log("before cheap", shops);
            let cheapestShop = shops.reduce((prev, curr) =>
                prev.harga < curr.harga ? prev : curr
            );
            console.log("after cheap", cheapestShop);

            // fokus ke objek
            let bounds = new google.maps.LatLngBounds();
            let shopLoc = new google.maps.LatLng(cheapestShop.lat, cheapestShop.lng);
            console.log(shopLoc, typeof(shopLoc));

            bounds.extend(shopLoc);
            map.fitBounds(bounds);

            // Direction Service API masih dimatikan
            let directionsRenderer = new google.maps.DirectionsRenderer();
            let directionsService = new google.maps.DirectionsService();
            directionsRenderer.setMap(map);

            // Request directions from user to cheapest shop
            let request = {
                origin: userLocation,
                destination: {
                    lat: parseFloat(cheapestShop.lat),
                    lng: parseFloat(cheapestShop.lng)
                },
                travelMode: "DRIVING",
            };
            console.log(request)
            directionsService.route(request, function(result, status) {
                if (status == "OK") {
                    directionsRenderer.setDirections(result);
                }
            });
        }

        // Fungsi untuk menghitung jarak antara dua titik menggunakan Haversine Formula
        function calculateDistance(pointA, pointB) {
            const R = 6371e3; // Radius bumi dalam meter
            const φ1 = pointA.lat * Math.PI / 180;
            const φ2 = pointB.lat * Math.PI / 180;
            const Δφ = (pointB.lat - pointA.lat) * Math.PI / 180;
            const Δλ = (pointB.lng - pointA.lng) * Math.PI / 180;

            const a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
                Math.cos(φ1) * Math.cos(φ2) *
                Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

            const distance = R * c; // Dalam meter
            return distance;
        }
        let routeLine; // Variabel global untuk menyimpan polyline (agar bisa dihapus nanti)

        // Fungsi untuk menampilkan toko pada tabel dan membuat interaksi zoom serta polyline
        function showShops(shops, range) {
            // Clear previous table data
            const shopDetailsTable = document.getElementById("shopDetailsTable");
            shopDetailsTable.innerHTML = ""; // Clear existing table rows

            let bounds = new google.maps.LatLngBounds();
            console.log("range: ", range, typeof(range));
            console.log("userLocation", userLocation);

            let marker;
            shops.forEach((shop, index) => {
                if (shop.distance <= range) {
                    const shopLocation = new google.maps.LatLng(shop.lat, shop.lng);

                    // Create custom HTML for AdvancedMarkerElement
                    const content = document.createElement("div");
                    content.className = "card shadow";
                    content.style.backgroundColor = "#f8f9fa";
                    content.style.border = "1px solid #ddd";
                    content.style.textAlign = "center";

                    content.innerHTML = `
                <div class="card-header text-center bg-success text-white py-1">
                    <strong>Harga : Rp. ${shop.harga.toLocaleString('id-ID')}</strong> <!-- Format angka harga -->
                </div>
                <div class="card-body py-2">
                    <span style="font-size: 1.1em; font-weight: bold;">${shop.namaproduk}</span>
                </div>
                <div class="card-body py-2">
                    <span style="font-size: 1.1em; font-weight: bold;">${shop.toko}</span>
                </div>
            `;

                    // Add shop details to table
                    const row = document.createElement("tr");
                    row.innerHTML = `
                <td>${shop.namaproduk}</td>
                <td>${shop.toko}</td>
                <td>${shop.lat}</td>
                <td>${shop.lng}</td>
                <td>Rp. ${shop.harga.toLocaleString('id-ID')}</td>
                <td>
                    <button 
                        class="btn btn-success btn-sm" 
                        title="Lihat Lokasi" 
                        style="display: flex; align-items: center; justify-content: center; padding: 5px; border-radius: 4px;">
                        <img 
                            src="https://img.icons8.com/ios-filled/16/FFFFFF/visible.png" 
                            alt="Lihat" 
                            style="width: 16px; height: 16px; margin-right: 4px;">
                        Lihat
                    </button>
                </td>
            `;
                    shopDetailsTable.appendChild(row);

                    // Add click event to the button to zoom and draw polyline
                    const viewButton = row.querySelector("button");
                    viewButton.addEventListener("click", () => {
                        map.setZoom(15); // Set desired zoom level
                        map.panTo(shopLocation); // Center map to shop's location

                        // Remove existing polyline
                        if (routeLine) {
                            routeLine.setMap(null);
                        }

                        // Create new polyline
                        routeLine = new google.maps.Polyline({
                            path: [userLocation, shopLocation], // Start and end points
                            geodesic: true,
                            strokeColor: "#FF0000",
                            strokeOpacity: 0.8,
                            strokeWeight: 4,
                        });

                        // Add polyline to the map
                        routeLine.setMap(map);

                        // Calculate and display distance
                        const distance = calculateDistance(userLocation, {
                            lat: shopLocation.lat(),
                            lng: shopLocation.lng(),
                        });
                        alert(`Jarak ke ${shop.toko}: ${(distance / 1000).toFixed(2)} km`);
                    });

                    // Create AdvancedMarkerElement
                    marker = new AdvanceMarker({
                        position: shopLocation,
                        map: map,
                        content: content,
                    });
                    advancedMarkers.push(marker);
                    bounds.extend(userLocation);
                    console.log("distance: ", shop.distance, typeof(shop.distance), "\nshopLocation:", shopLocation);
                    bounds.extend(shopLocation);
                }
            });

            console.log("marker: ", marker);
            map.fitBounds(bounds);
        }
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgGBjlEnlrlO2KdsQMFL70E_Ppo3GmFPs&loading=async&callback=initMap&libraries=marker"
        async type="text/javascript" defer></script>
    <?php include './layout/scripts.php' ?>
</body>

</html>