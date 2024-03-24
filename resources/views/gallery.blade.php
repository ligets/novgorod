@extends('layouts.main')

@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@vite('resources/css/upload.css')
@vite('resources/css/gallery.css')
<style>
    ul{
        list-style: none;
    }
    .select2-close-mask{
        z-index: 2099;
    }
    .select2-dropdown{
        z-index: 3051;
    }
    .select2{
        margin-left: 3%;
        margin-right: 3%;
        margin-top: 1vh;
        
    }
    .select2-selection--multiple{
        border-radius: 10px!important;
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
                <button id="upload" class="active tablinks theme-changeable align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#uploadModal">
                    <svg class="svg" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60"  width="30" height="30" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#FFFFFF" enable-background="new 0 0 60 60">
                        <g>
                            <g>
                            <path d="m30,.076c-16.568,0-30,13.431-30,30 0,15.556 11.84,28.343 27,29.849v-0.005c0.552,0 1-0.448 1-1 0-0.552-0.448-1-1-1v-0.01c-14.052-1.498-25-13.384-25-27.834 0-15.464 12.536-28 28-28 15.464,0 28,12.536 28,28 0,14.45-10.948,26.337-25,27.835v0.009c-0.552,0-1,0.448-1,1 0,0.552 0.448,1 1,1v0.005c15.159-1.506 27-14.293 27-29.849 0-16.569-13.431-30-30-30z"/>
                            </g>
                        </g>
                        <g>
                            <g>
                            <path d="m30,14.076c-0.552,0-1,0.448-1,1v14h-14c-0.552,0-1,0.448-1,1s0.448,1 1,1h14v14c0,0.552 0.448,1 1,1 0.552,0 1-0.448 1-1v-30c0-0.553-0.448-1-1-1zm15,15h-9c-0.552,0-1,0.448-1,1s0.448,1 1,1h9c0.552,0 1-0.448 1-1s-0.448-1-1-1z"/>
                            </g>
                        </g>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    @include('includes.upload')
    <div id="photos" class="tabcontent" style="display: none;">
        <div class="grid theme-changeable">
            <div class="grid-sizer"></div>
            <div class="gutter-sizer"></div>
            
            @foreach($images as $image)
            <div class="grid-item">
                <a data-caption="{{ $image->title }}" href="{{ '/storage/' . $image->path }}" data-fancybox="gallery">
                    <img data-id="{{ $image->id }}" src="{{ 'storage/' . $image->path }}">
                </a>
            </div>
            @endforeach
        </div>
    </div>
    <div id="videos" class="tabcontent flex-wrap justify-content-center" style="display: none;">
        @foreach($videos as $video)
            <div class="video-item">
                <div class="video-preview-container">
                    <a data-caption="{{ $video->title }}" href="{{ './storage/' . $image->path }}" data-fancybox="gallery">
                        <img class="video-preview" alt="Video Preview">
                        <video data-id="{{ $video->id }}" class="video" data-path="{{ $video->path }}" src="{{ asset('storage/' . $video->path) }}" controls></video>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@vite('resources/js/masonry.pkgd.min.js')
@vite('resources/js/tab.js')
@vite('resources/js/video-gallery.js')
@vite('resources/js/upload.js')
@vite('resources/js/gallery.js')
@endsection