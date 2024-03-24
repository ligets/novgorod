<header class="d-flex flex-row align-items-center justify-content-between py-3 theme-changeable header">
    <div class="col-md-4">
        <a id="header-txt" href="/" class="d-flex align-items-center ms-4 col-md-5 mb-1 mb-md-0 text-dark text-decoration-none">#ImageHub</a>
    </div>
    <div class="container d-flex align-items-center justify-content-center col-md-4 me-4">
        <form action="{{ route('search') }}" method="GET" class="input-group d-flex justify-content-center">
            <select name="tags[]" id="searchCont" multiple>
                @foreach(App\Models\Tag::all() as $tag)
                    <option value="{{ $tag->name }}">{{ $tag->name }}</option>
                @endforeach
            </select>
            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
                <img src="{{ asset('storage/img/site/search-ico.png') }}" alt="Иконка поиска" class="search-ico">
            </button>
        </form>
    </div>

    <div class="container d-flex flex-row align-items-center justify-content-end col-md-3 mb-md-0 ">
        <div class="me-2">
            <div class="theme-switcher btn btn-outline-dark rounded-pill me-2 align-self-center"></div>
            @guest
            <button type="button" class="btn btn-outline-dark rounded-pill btn-txt text-center me-2" data-bs-toggle="modal" data-bs-target="#loginModal"><span class="log-text">Вход</span></button>
            <button type="button" class="btn btn-dark rounded-pill btn-txt text-center" data-bs-toggle="modal" data-bs-target="#signupModal"><span class="reg-text">Регистрация</span></button>
            @endguest
            @auth
                @if(Request::is('gallery'))
                <button type="button" id="albBtn" class="btn btn-outline-dark rounded-pill" data-bs-toggle="modal" data-bs-target="#myModal">
                    Создать альбом
                </button>
                @else
                <a href="/gallery" class="btn btn-outline-dark rounded-pill">Галлерея</a>
                @endif
            @if(!Request::is('lk'))
            <a href="/lk" class="btn btn-outline-dark rounded-pill">Личный кабинет</a>
            @endif
            @endauth
        </div>
    </div>
</header>
@guest
    @include('includes.modalAuth')
@endguest
@if(Request::is('gallery'))
    @include('includes.createAlbum')
@endif