<!-- <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3">
    <a id="header-txt" href="/" class="d-flex align-items-center ms-4 col-md-2 mb-1 mb-md-0 text-dark text-decoration-none">#Главная</a>        
    <div class="container ms-auto m-0 me-4">
        <div class="d-flex flex-wrap align-items-center justify-content-end">
            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
                <input type="search" class="form-control form-control-dark" placeholder="Поиск...." aria-label="Search">
            </form>
            @guest
            <div class="me-2">
                <button type="button" class="btn btn-outline-dark rounded-pill" data-bs-toggle="modal" data-bs-target="#loginModal">ВХОД</button>
                <button type="button" class="btn btn-dark rounded-pill" data-bs-toggle="modal" data-bs-target="#signupModal">РЕГИСТРАЦИЯ</button>
            </div>
            @endguest
            @auth
            <div class="me-2">
                <button type="button" class="btn btn-outline-dark rounded-pill">Личный кабинет</button>
            </div>
            @endauth
        </div>
    </div>
</header> -->

<header class="d-flex flex-row align-items-center justify-content-between py-3 theme-changeable header">
    <a id="header-txt" href="/" class="d-flex align-items-center ms-4 col-md-2 mb-1 mb-md-0 text-dark text-decoration-none">#Главная</a>
    <a id="gallery-txt" href="./gallery" class="d-flex justify-content-between mb-md-0 text-dark text-decoration-none">#Глерея</a>
    <div class="container d-flex align-items-center justify-content-center  me-4">
        <div class="input-group">
            <input type="search" class="form-control theme-changeable" placeholder="Поиск...." aria-label="Search">
            <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                <img src="{{ asset('storage/img/site/search-ico.png') }}" alt="Иконка поиска" class="search-ico">
            </button>
        </div>
    </div>

    <div class="container d-flex flex-row align-items-center justify-content-end col-md-2 mb-md-0 me-4">
        <div class="me-2">
            <div class="theme-switcher btn btn-outline-dark rounded-pill me-2 align-self-center"></div>
            @guest
            <button type="button" class="btn btn-outline-dark rounded-pill btn-txt text-center me-2" data-bs-toggle="modal" data-bs-target="#loginModal"><span class="log-text">Вход</span></button>
            <button type="button" class="btn btn-dark rounded-pill btn-txt text-center" data-bs-toggle="modal" data-bs-target="#signupModal"><span class="reg-text">Регистрация</span></button>
            @endguest
            @auth
            <a href="/lk" class="btn btn-outline-dark rounded-pill">Личный кабинет</a>
            @endauth
        </div>
    </div>
</header>
@guest
    @include('includes.modalAuth')
@endguest