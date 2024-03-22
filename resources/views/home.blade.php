@extends('layouts.main')

@section('title-block')Я ХУЕСОС@endsection

@section('style')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
  @vite('resources/css/style.css')
@endsection

@section('content')
    <main class="col-md-12 overflow-hidden main-content theme-changeable"> 
      <div class="div-txt ms-4 mt-4">
        <span class="txt theme-changeable">ФОТОГРАФИИ</span>
      </div>
      <div class="slider1">
        @foreach($photos as $photo)
        <div class="item">
          <a data-fancybox="gallery" href="{{ 'storage/' . $photo->path }}">
            <img class="slider__item" src="{{ asset('storage/' . $photo->path) }}" alt="#">
          </a>
          <div class="video-info d-flex flex-row justify-content-center">
            <img src="{{ asset('storage/' . $photo->user->pathIco) }}" alt="User Icon">
            <div class="video-author d-flex flex-column">
                <span class="author-name theme-changeable">{{ '@' . $photo->user->login }}</span>
            </div>
          </div>
        </div>
        @endforeach
        @if(count($photos) >  9)
        <a class="item d-flex justify-content-center" href="{{ route('public') }}">
          <span style="color: #fff;">СМОТРЕТЬ ЕЩЁ</span>
        </a>
        @endif
      </div>
      <div class="div-txt ms-4">
        <span class="txt theme-changeable">ВИДЕО</span>
      </div>
      <div class="slider2">
        @foreach($movies as $movie)
        <div class="video-preview-container">
          <a data-fancybox="gallery" data-caption="{{ $movie->title }}" href="{{ asset('storage/' . $movie->path) }}">
            <img class="video-preview" alt="Video Preview">
            <video class="video" src="{{ asset('storage/' . $movie->path) }}" controls></video>
          </a>
          <div class="video-info d-flex flex-row justify-content-center">
            <img src="{{ asset('storage/' . $photo->user->pathIco) }}" alt="User Icon">
            <div class="video-author d-flex flex-column">
                <span class="author-name theme-changeable">{{ '@' . $movie->user()->first()->login }}</span>
                <div class="video-description theme-changeable">
                  @if(mb_strlen($movie->title) > 30)
                    {{ mb_substr($movie->title, 0, 30) . '...' }}
                  @else
                    {{ $movie->title }}
                  @endif
                </div>
            </div>
          </div>
        </div>
        @endforeach
        @if(count($movies) >  9)
        <a class="item d-flex justify-content-center" href="{{ route('public') }}">
          <span style="color: #fff;">СМОТРЕТЬ ЕЩЁ</span>
        </a>
        @endif
      </div>
      <div class="div-txt ms-4">
        <span class="txt theme-changeable">АЛЬБОМЫ</span>
      </div>
      <div class="slider3">
        @foreach($albums as $album)
          <div class="item-album">
            <a href="{{ '/albums/' . $album->id }}"><img src="{{ asset('storage/img/preview/album/default.png') }}" alt="#" class="slider__item"></a>
            <div class="album-info d-flex justify-content-center">
              <img src="{{ asset('storage/' . $album->authors()->first()->pathIco) }}" alt="User Icon">
              <div class="album-author d-flex flex-column">
              <span class="album-description theme-changeable">{{ '@' . $album->authors()->where('role', 'owner')->first()->login }}</span>
                <div class="album-author-name theme-changeable">{{ $album->title }}</div>
              </div>
            </div>
          </div>
        @endforeach
        @if(count($movies) >  9)
        <a class="item d-flex justify-content-center" href="{{ route('public') }}">
          <span style="color: #fff;">СМОТРЕТЬ ЕЩЁ</span>
        </a>
        @endif
      </div>
    </main> 
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
@vite('resources/js/slider.js')
@vite('resources/js/video-gallery.js')
@endsection