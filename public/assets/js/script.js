// Inisialisasi Peta
var map = L.map("map").setView([-2.0833, 115.3667], 10);

// Layer Map (Peta Jalan)
var mapLayer = L.tileLayer(
    "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
    {
        attribution: "&copy; OpenStreetMap contributors",
        maxZoom: 19,
    }
).addTo(map);

// Layer Satellite (Google Satellite)
var satelliteLayer = L.tileLayer(
    "https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}",
    {
        subdomains: ["mt0", "mt1", "mt2", "mt3"],
        attribution: "&copy; Google Maps",
        maxZoom: 20,
    }
);

// Layer Hybrid (Google Satellite dengan Label)
var hybridLayer = L.tileLayer(
    "https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}",
    {
        subdomains: ["mt0", "mt1", "mt2", "mt3"],
        attribution: "&copy; Google Maps",
        maxZoom: 20,
    }
);

// Muat file Shapefile dari URL
var shapefileUrl = "../assets/Kecamatan Tabalong.zip"; // Pastikan file ZIP ini ada
shp(shapefileUrl).then(function (geojson) {
    L.geoJSON(geojson, {
        style: function (feature) {
            return {
                color: "red",
                weight: 2,
                fillOpacity: 0,
            };
        },
        onEachFeature: function (feature, layer) {
            console.log(feature.properties); // Debugging
            layer.bindPopup(
                `<b>Kecamatan:</b> ${
                    feature.properties.KECAMATAN || "Tidak tersedia"
                }<br>
          <b>Kabupaten:</b> ${feature.properties.KABUPATEN || "Tidak tersedia"}`
            );
        },
    }).addTo(map);
});

// Dinamis Icon Marker dari Kategori
var icons = {};

// Tambahkan Icon untuk Setiap Kategori
categories.forEach((category) => {
    icons[category.name] = L.icon({
        iconUrl: `/storage/${category.icon}`,
        iconSize: [40, 40],
        iconAnchor: [15, 30],
        popupAnchor: [0, -30],
    });
});

// Layer untuk kategori
var categoryLayers = {};

// Muat Marker Berdasarkan Lokasi Tanpa Menambahkan ke Peta
locations.forEach((location) => {
    if (!categoryLayers[location.category.name]) {
        categoryLayers[location.category.name] = L.layerGroup(); // Inisialisasi layer jika belum ada
    }

    var marker = L.marker(location.coords, {
        icon:
            icons[location.category.name] ||
            L.icon({
                iconUrl: "/assets/images/default-icon.png",
                iconSize: [40, 40],
                iconAnchor: [15, 30],
                popupAnchor: [0, -30],
            }),
    }).bindPopup(`
        <h5>${location.name}</h5>
        <p><strong>Kategori:</strong> ${location.category.name}</p>
        <p><strong>Lokasi:</strong> ${location.additional_info}</p>
        <p><strong>Deskripsi:</strong> ${location.description}</p>
        <p><strong>Dinas Terkait:</strong> ${location.agency}</p>
        <a href="#" onclick="openModalImage('/storage/${location.image}', event)">
        <img src="/storage/${location.image}" alt="${location.name}" width="100%">
    </a>

    `);

    categoryLayers[location.category.name].addLayer(marker);
});

function openModalImage(imagePath, event) {
    event.preventDefault(); // Mencegah default <a> action
    const modalImage = document.querySelector("#imageModal img"); // Seleksi elemen gambar dalam modal
    modalImage.src = imagePath; // Perbarui sumber gambar
    modalImage.alt = "Gambar Lokasi"; // Perbarui alt gambar (opsional)

    // Tampilkan modal
    const imageModal = new bootstrap.Modal(
        document.getElementById("imageModal")
    );
    imageModal.show();
}

function toggleCategory(category, element) {
    // Pastikan layer untuk kategori ada
    if (!categoryLayers[category]) {
        Swal.fire({
            icon: "info",
            title: "Data Tidak Tersedia",
            text: `Kategori "${category}" tidak memiliki data atau marker.`,
            confirmButtonText: "OK",
        });
        return;
    }

    if (map.hasLayer(categoryLayers[category])) {
        // Jika layer aktif, hapus dari peta
        map.removeLayer(categoryLayers[category]);
        element.classList.remove("active");
    } else {
        // Jika layer tidak aktif, tambahkan ke peta
        if (categoryLayers[category]?.getLayers().length > 0) {
            map.addLayer(categoryLayers[category]);
            element.classList.add("active");
        } else {
            alert(`Kategori "${category}" tidak memiliki data atau marker.`);
        }
    }
}

// Fungsi Reset Marker
function resetMarkers() {
    Object.values(categoryLayers).forEach((layer) => {
        if (map.hasLayer(layer)) {
            map.removeLayer(layer);
        }
    });

    const buttons = document.querySelectorAll(".btn-category");
    buttons.forEach((btn) => btn.classList.remove("active"));
}

// Layer Control
var baseMaps = {
    Map: mapLayer,
    Satellite: satelliteLayer,
    Hybrid: hybridLayer,
};

L.control.layers(baseMaps, {}, { collapsed: false }).addTo(map);
