<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Медиа</title>
</head>
<body>
    <h1>Медиа</h1>
    <div>
        @foreach($media as $item)
            @if($item->format == 'image')
                <img src="{{ asset('storage/' . $item->path) }}" width="300px" height="300px" alt="Image">
            @elseif($item->format == 'video')
                <video width="300px" height="300px" controls>
                    <source src="{{ asset('storage/' . $item->path) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            @endif
        @endforeach
    </div>
    <button id="download" type="button">Скачать 34 id ресурс</button>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</body>
</html>
