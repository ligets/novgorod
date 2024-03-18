<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3">
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
</header>
@guest
    @include('includes.modalAuth')
@endguest