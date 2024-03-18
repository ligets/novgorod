@extends('layouts.main')

@section('title-block')Я ХУЕСОС@endsection

@section('style')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css">
  @vite('resources/css/reset.css')
  @vite('resources/css/style.css')
@endsection

@section('content')
    <main class="col-md-12 overflow-hidden"> 
      <div class="div-txt ms-4">
        <span class="txt">ФОТОГРАФИИ</span>
      </div>
      <div class="slider1">
        @foreach($photos as $photo)
        <div class="item">
          <img class="slider__item" src="{{ asset('storage/' . $photo->path) }}" alt="#">
        </div>
        @endforeach
        @if(count($photos) >  9)
        <div class="item d-flex justify-content-center">
          <span style="color: #fff;">СМОТРЕТЬ ЕЩЁ</span>
        </div>
        @endif
      </div>
      <div class="div-txt ms-4">
        <span class="txt">ВИДЕО</span>
      </div>
      <div class="slider2">
        @foreach($movies as $movie)
        <video class="video" src="{{ asset('storage/' . $movie->path) }}" controls></video>
        @endforeach
        @if(count($movies) >  9)
        <div class="item d-flex justify-content-center">
          <span style="color: #fff;">СМОТРЕТЬ ЕЩЁ</span>
        </div>
        @endif
      </div>
      <div class="div-txt ms-4">
        <span class="txt">АЛЬБОМЫ</span>
      </div>
      <div class="slider3">
        @foreach($albums as $album)
        <div class="item">
          <img class="slider__item" src="{{ asset('storage/' . $album->path) }}">
        </div>
        @endforeach
        @if(count($movies) >  9)
        <div class="item d-flex justify-content-center">
          <span style="color: #fff;">СМОТРЕТЬ ЕЩЁ</span>
        </div>
        @endif
      </div>
    </main> 
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
@vite('resources/js/script.js')
@endsection