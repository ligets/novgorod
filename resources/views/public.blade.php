@extends('layouts.main')

@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
@vite('resources/css/upload.css')
@vite('resources/css/gallery.css')
<style>
    ul{
        list-style: none;
    }
</style>
@endsection

@section('content')
<main class="col-md-12 overflow-hidden main-content theme-changeable">
    <div class="h-auto" style="padding: 0 7% 0 7%">
        <div class="row justify-content-center">
            <div class="col-md-4"></div>
            <ul class="tabs d-flex align-items-center col-md-4 justify-content-center" id="navGallery">
                <li>
                    <button id="photosButton" class="mr-2 active tablinks theme-changeable">Фото</button>
                </li>
                <li>
                    <button id="videosButton" class="mr-2 tablinks theme-changeable">Видео</button>
                </li>
                <li>
                    <button id="albumsButton" class="tablinks theme-changeable">Альбомы</button>
                </li>
            </ul>
            <div class="d-flex justify-content-end col-md-4 mt-3">
                <button id="upload" class="active tablinks theme-changeable border p-2" style="border-radius: 20px;" data-bs-toggle="modal" data-bs-target="#uploadModal">Добавить</button>
                <button id="download" class="active tablinks theme-changeable border p-2">Скачать альбом</button>
            </div>
        </div>
    </div>
    <div id="photos" class="tabcontent" style="display: none;">
        <div class="grid theme-changeable">
            <div class="grid-sizer"></div>
            <div class="gutter-sizer"></div>
            @foreach($images as $image)
            <div class="grid-item">
                <a data-caption="{{ $image->title }}" href="{{ './storage/' . $image->path }}" data-fancybox="gallery">
                    <img data-path src="{{ asset('storage/' . $image->path) }}">
                </a>
            </div>
            @endforeach
        </div>
    </div>

    <div id="videos" class="tabcontent flex-wrap justify-content-center" style="display: none;">
        @foreach($videos as $video)
            <div class="video-item">
                <div class="video-preview-container">
                    <a data-fancybox="video" data-caption="{{ $video->title }}" href="{{ './storage/' . $video->path }}">
                        <img class="video-preview" alt="Video Preview">
                        <video class="video" data-path="{{ $video->path }}" src="{{ asset('storage/' . $video->path) }}" controls></video>
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
    <div id="albums" class="tabcontent flex-wrap justify-content-center" style="display: none;">
        @foreach($albums as $album)
            <div class="item-album">
                <a href="{{ '/albums/' . $album->id }}"><img src="{{ asset('storage/' . $album->pathPreview) }}" alt="#" class="img-album"></a>
                <div class="album-info d-flex justify-content-center">
                    <img src="{{ asset('storage/' . $album->authors()->where('role', 'owner')->first()->pathIco) }}" alt="User Icon">
                    <div class="album-author d-flex flex-column">
                        <span class="album-description theme-changeable">{{ '@' . $album->authors()->where('role', 'owner')->first()->login }}</span>
                        <div class="album-author-name theme-changeable">{{ $album->title }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</main>
@endsection

@section('scripts')
<script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/resumable.js/1.1.0/resumable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
@vite('resources/js/masonry.pkgd.min.js')
@vite('resources/js/tab.js')
@vite('resources/js/video-gallery.js')
@vite('resources/js/gallery.js')
@vite('resources/js/upload.js')
@endsection