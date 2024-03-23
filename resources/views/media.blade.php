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
            <div class="d-flex justify-content-end col-md-4 mt-3">
                <button id="upload" class="active tablinks theme-changeable border p-2" style="border-radius: 20px;" data-bs-toggle="modal" data-bs-target="#uploadModal">Добавить</button>
                <button id="download" class="active tablinks theme-changeable border p-2">Скачать альбом</button>
                <button id="edit" class="active tablinks theme-changeable p-2" data-bs-toggle="modal" data-bs-target="#editAlbum">
                    <img src="{{ asset('storage/img/site/pen.svg') }}">
                </button>
            </div>
        </div>
    </div>
    @include('includes.editAlbum')
    @include('includes.upload')
    <div id="photos" class="tabcontent" style="display: none;">
        <div class="grid theme-changeable">
            <div class="grid-sizer"></div>
            <div class="gutter-sizer"></div>
            @foreach($images as $image)
            <div class="grid-item">
                <a data-caption="{{ $image->title }}" href="{{ '/storage/' . $image->resource->path }}" data-fancybox="gallery">
                    <img src="{{ asset('storage/' . $image->resource->path) }}">
                </a>
            </div>
            @endforeach
        </div>
    </div>

    <div id="videos" class="tabcontent flex-wrap justify-content-center" style="display: none;">
        @foreach($videos as $video)
            <div class="video-item">
                <div class="video-preview-container">
                    <a data-fancybox="video" data-caption="{{ $video->resource->title }}" href="{{ '/storage/' . $video->resource->path }}">
                        <img class="video-preview" alt="Video Preview">
                        <video class="video" src="{{ asset('storage/' . $video->resource->path) }}" controls></video>
                    </a>
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