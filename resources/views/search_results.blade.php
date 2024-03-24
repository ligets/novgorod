@extends('layouts.main')

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    @vite('resources/css/gallery.css')
    <style>
        ul {
            list-style: none;
        }
    </style>
@endsection

@section('content')
    <main class="col-md-12 overflow-hidden main-content theme-changeable">
        <div class="container h-auto">
            <div class="row justify-content-center">
                <ul class="tabs d-flex align-items-center justify-content-center" id="navGallery">
                    <li>
                        <button id="photosButton" class="mr-2 active tablinks theme-changeable">Фото</button>
                    </li>
                    <li>
                        <button id="videosButton" class="mr-2 tablinks theme-changeable">Видео</button>
                    </li>
                </ul>
            </div>
        </div>
        <div id="photos" class="tabcontent" style="display: none;">
            <div class="grid theme-changeable">
                <div class="grid-sizer"></div>
                <div class="gutter-sizer"></div>
                @foreach($images as $image)
                <div class="grid-item">
                    <a data-caption="{{ $image->title }}" href="{{ '/storage/' . $image->path }}" data-fancybox="images">
                        <img data-id="{{ $image->id }}" src="{{ asset('storage/' . $image->path) }}">
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        <div id="videos" class="tabcontent flex-wrap justify-content-center" style="display: none;">
            @foreach($videos as $video)
                <div class="video-item">
                    <div class="video-preview-container">
                        <a data-fancybox="video" data-caption="{{ $video->title }}" href="{{ '/storage/' . $video->path }}">
                            <img class="video-preview" alt="Video Preview">
                            <video data-id="{{ $video->id }}" class="video" src="{{ asset('storage/' . $video->path) }}" controls></video>
                        </a>
                        <div class="video-info d-flex flex-row">
                        <img src="{{ asset('storage/' . $video->user->pathIco) }}" alt="User Icon">
                            <div class="video-author d-flex flex-column">
                                <span class="author-name theme-changeable">{{ '@' . $video->user->login }}</span>
                                <div class="video-description theme-changeable">{{ $video->title }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
@endsection

@section('scripts')
    <script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    @vite('resources/js/masonry.pkgd.min.js')
    @vite('resources/js/album.js')
    @vite('resources/js/video-gallery.js')
    @vite('resources/js/gallery.js')
@endsection