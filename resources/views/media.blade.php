<!DOCTYPE html>
<html>
<head>
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
</body>
</html>
