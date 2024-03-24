@extends('layouts.main')

@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@vite('resources/css/upload.css')
@vite('resources/css/gallery.css')
<style>
    body {
  display: none;
}
body.loaded {
  display: flex;
}
#download{
    border-radius: 25px;
    display: flex;
    font-size: 25px
}
.select2-close-mask{
    z-index: 2099;
}
.select2-dropdown{
    z-index: 3051;
}
.cont{
    padding: 0 7% 0 7%;
}
</style>
@endsection

@section('content')
<main class="col-md-12 overflow-hidden main-content theme-changeable">
    <div class="cont">
        <div class="d-flex justify-content-center">
            <div class="col-md-4"></div>
            <div class="tabs d-flex align-items-center justify-content-center col-md-auto col-md-4">
                <button id="photosButton" class="me-2 active tablinks theme-changeable">Фото</button>
                <button id="videosButton" class="me-2 tablinks theme-changeable">Видео</button>
            </div>
            <div class="d-flex justify-content-end col-md-4 mt-3 gap-2">
                @if($role !== null)
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
                @endif
                @if ($images !== null)
                    @php
                    $imageCount = count($images);
                    @endphp
                @else
                    @php
                    $imageCount = 0;
                    @endphp
                @endif

                @if ($videos !== null)
                    @php
                    $videoCount = count($videos);
                    @endphp
                @else
                    @php
                    $videoCount = 0;
                    @endphp
                @endif
                <button data-download="{{ $imageCount + $videoCount }}" id="download" class="active tablinks theme-changeable align-items-center justify-content-center">
                    <svg class="svg download" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24">
                        <path d="M14.7928932,11.5 L11.6464466,8.35355339 C11.4511845,8.15829124 11.4511845,7.84170876 11.6464466,7.64644661 C11.8417088,7.45118446 12.1582912,7.45118446 12.3535534,7.64644661 L16.3535534,11.6464466 C16.5488155,11.8417088 16.5488155,12.1582912 16.3535534,12.3535534 L12.3535534,16.3535534 C12.1582912,16.5488155 11.8417088,16.5488155 11.6464466,16.3535534 C11.4511845,16.1582912 11.4511845,15.8417088 11.6464466,15.6464466 L14.7928932,12.5 L4,12.5 C3.72385763,12.5 3.5,12.2761424 3.5,12 C3.5,11.7238576 3.72385763,11.5 4,11.5 L14.7928932,11.5 Z M16,4.5 C15.7238576,4.5 15.5,4.27614237 15.5,4 C15.5,3.72385763 15.7238576,3.5 16,3.5 L19,3.5 C20.3807119,3.5 21.5,4.61928813 21.5,6 L21.5,18 C21.5,19.3807119 20.3807119,20.5 19,20.5 L16,20.5 C15.7238576,20.5 15.5,20.2761424 15.5,20 C15.5,19.7238576 15.7238576,19.5 16,19.5 L19,19.5 C19.8284271,19.5 20.5,18.8284271 20.5,18 L20.5,6 C20.5,5.17157288 19.8284271,4.5 19,4.5 L16,4.5 Z" transform="rotate(90 12.5 12)" fill="#FFFFFF"/>
                    </svg>
                </button>
                @if($role == 'owner')
                <button id="edit" class="active tablinks theme-changeable" data-bs-toggle="modal" data-bs-target="#editAlbum" style="margin-top: -1%">
                    <img src="{{ asset('storage/img/site/pen.svg') }}">
                </button>
                @endif
            </div>
        </div>
    </div>
    @if($role == 'owner')
        @include('includes.editAlbum')
    @endif
    @include('includes.upload')
    <div id="photos" class="tabcontent" style="display: none;">
        <div class="grid theme-changeable">
            <div class="grid-sizer"></div>
            <div class="gutter-sizer"></div>
            @foreach($images as $image)
            <div class="grid-item">
                @if($role !== 'owner')
                <a data-caption="{{ $image->resource->title }}" href="{{ '/storage/' . $image->resource->path }}" data-fancybox="images">
                    <img data-id="{{ $image->resource->id }}" src="{{ asset('storage/' . $image->resource->path) }}">
                </a>
                @else
                <a data-caption="{{ $image->resource->title }}" href="{{ '/storage/' . $image->resource->path }}" data-fancybox="gallery">
                    <img data-id="{{ $image->resource->id }}" src="{{ asset('storage/' . $image->resource->path) }}">
                </a>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    <div id="videos" class="tabcontent flex-wrap justify-content-center" style="display: none;">
        @foreach($videos as $video)
            <div class="video-item">
                <div class="video-preview-container">
                    @if($role !== 'owner')
                    <a data-fancybox="video" data-caption="{{ $video->resource->title }}" href="{{ '/storage/' . $video->resource->path }}" data-fancybox="images">
                        <img class="video-preview" alt="Video Preview">
                        <video data-id="{{ $video->resource->id }}" class="video" src="{{ asset('storage/' . $video->resource->path) }}" controls></video>
                    </a>
                    @else
                    <a data-fancybox="video" data-caption="{{ $video->resource->title }}" href="{{ '/storage/' . $video->resource->path }}" data-fancybox="gallery">
                        <img class="video-preview" alt="Video Preview">
                        <video data-id="{{ $video->resource->id }}" class="video" src="{{ asset('storage/' . $video->resource->path) }}" controls></video>
                    </a>
                    @endif
                    <div class="video-info d-flex flex-row">
                    <img src="{{ asset('storage/' . $video->user->pathIco) }}" alt="User Icon">
                        <div class="video-author d-flex flex-column">
                            <span class="author-name theme-changeable">{{ '@' . $video->user->login }}</span>
                            <div class="video-description theme-changeable">{{ $video->resource->title }}</div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/resumable.js/1.1.0/resumable.min.js"></script>
@vite('resources/js/masonry.pkgd.js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@vite('resources/js/tabAlbum.js')
@vite('resources/js/video-gallery.js')
@vite('resources/js/downloadAlbum.js')
@vite('resources/js/upload.js')
@vite('resources/js/gallery.js')
<script>
if($("input[name='access']:checked").val() == 2){
    console.log(1);
    $("#authors").select2({
        placeholder: "Выбор соавторов",
        tags: false,
        width: 'auto'
    });
}
$("input[name='access']").change(function(){
    if($("input[name='access']:checked").val() == 2)
    $("#authors").select2({
        placeholder: "Выбор соавторов",
        tags: false,
        width: 'auto'
    });
    else{
        if ($("#authors").data('select2')) {
            $("#authors").select2("destroy");
        }
    }
})
</script>
@endsection