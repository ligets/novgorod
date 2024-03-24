<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map</title>
    <script src="https://api-maps.yandex.ru/2.1/?apikey=be305c39-0ed8-44db-9f95-f5e04285b3f8&lang=ru_RU" type="text/javascript"></script>
    <style>
        #map-container {
            width: 100%; /* Установите желаемую ширину */
            height: 98vh; /* Установите желаемую высоту */
        }
    </style>
</head>
<body>
    <div id="map-container">
        <div id="map" style="width: 100%; height: 100%;"></div>
    </div>


    <script>
        ymaps.ready(init);

        function init() {
            var latitude = {{ $meta->gps_latitude }};
            var longitude = {{ $meta->gps_longitude }};

            var map = new ymaps.Map('map', {
                center: [latitude, longitude],
                zoom: 15
            });

            var placemark = new ymaps.Placemark([latitude, longitude]);
            map.geoObjects.add(placemark);
        }
    </script>
</body>
</html>