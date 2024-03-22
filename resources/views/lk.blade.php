@extends('layouts.main')

@section('style')
<style>
body {
    display: flex;
    flex-direction: column;
    min-height: 100vh; /* Минимальная высота страницы */
}

header {
    flex: 0 0 auto; /* Фиксированный размер хидера */
    /* Дополнительные стили хидера */
}

main {
    flex: 1 0 auto; /* Автоматически расширяемый контент */
    /* Дополнительные стили контента */
}
main {
  transition: background-color 0.5s ease;
  box-sizing: border-box;
}
.main-content.light {
  background: rgb(250, 234, 210);
}
.main-content.dark {
  background: rgb(50, 50, 50);
}
footer {
    flex: 0 0 auto; /* Фиксированный размер футера */
    /* Дополнительные стили футера */
}
.info{
    border-radius: 55px;
    background: rgba(41, 41, 41, 0.55);
}
.login__container{
    text-align: center;
    width: auto;
}
.white{
    color: #ffff;
}
.black{
    color: #000;
    
}
.black path{
    fill: #000000;
}
.login_txt{
    font-size: 150%;
}
.pen{
    width: 60%;
    fill: #000000;
}
.edit_button{
    background: transparent;
    border: none;
}
#path{
    fill: #000000;
} 
.cont{
    box-sizing: border-box;
    border-radius: 36px;
    background: rgb(255, 255, 255);
}
.bre{
    border-radius: 0 100% 100% 0;
    
}
</style>
@endsection

@section('content')
<main class="theme-changeable main-content d-flex justify-content-center align-items-center">
    <div class="info col-md-6 border d-flex row justify-content-center">
        <div class="col-md-12 d-flex justify-content-center">
            <img src="{{ asset('storage/' . $user->pathIco) }}" alt="Ico" class="rounded-circle col-md-4 mt-4">
        </div>
        <div class="col-md-12 d-flex justify-content-center">
            <div class="login__container d-flex justify-content-center">
                <div class="login_txt white">{{ $user->login }}</div>
                <button class="edit_button"><img src="{{ asset('storage/img/site/pen.svg') }}" alt="pen" class="pen"></button>
            </div>
        </div>
        <div class="cont d-flex col-md-5 ps-3 pe-0">
            <span class="black col-md-10">{{ $user->email }}</span>
            <button class="edit_button black col-md-2 justify-content-end bre"><img src="{{ asset('storage/img/site/penBlack.svg') }}" alt="pen" class="pen black"></button>
        </div>
        <div>
            <span>Сменить пароль</span>
            <button><img src="" alt=""></button>
        </div>
        <button>Выход</button>
    </div>
</main>
@endsection

@section('scripts')

@endsection