<!--------------- login ----------------------->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="modal-body d-flex flex-column align-items-center" action="/auth/login" method="POST">
                @csrf
                <span class="topic">Вход</span>
                <div class="social">
                    <button class="google">
                        <img class="gg" src="{{ asset('storage/img/site/google.png') }}">
                    </button>
                    <button class="telegram">
                        <img class="tg" src="{{ asset('storage/img/site/tg.png') }}">
                    </button>
                    <button class="vkontakte">
                        <img class="vk" src="{{ asset('storage/img/site/vk.png') }}">
                    </button>
                </div>
                <input class="email form-control mb-2" type="text" name="login" placeholder="Login">
                <input class="password form-control mb-2" type="password" name="password" placeholder="Введите пароль">
                <div class="d-flex">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember" class="ms-2">Запомнить на этом устройстве</label>
                </div>
                <button id="loginBtn" type="submit" class="d-flex justify-content-center align-items-center log-in btn btn-secondary mb-2">Вход</button>
</form>
        </div>
    </div>
</div>

<!---------------- Registr ------------------->
    
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="modal-body d-flex flex-column align-items-center" action="auth/registration" method="POST">
                @csrf
                <span class="topic">Регистрация</span>
                <div class="social">
                    <button class="google">
                        <img class="gg" src="{{ asset('storage/img/site/google.png') }}">
                    </button>
                    <button class="telegram">
                        <img class="tg" src="{{ asset('storage/img/site/tg.png') }}">
                    </button>
                    <button class="vkontakte">
                        <img class="vk" src="{{ asset('storage/img/site/vk.png') }}">
                    </button>
                </div>
                <input class="email form-control mb-2" type="text" name="login" placeholder="Login" required>
                <input class="login form-control mb-2" type="email" name="email" placeholder="Email" required>
                <input class="password form-control mb-2" type="password" name="password" placeholder="Введите пароль" required>
                <input class="repit-password form-control mb-2" type="password" name="password_confirmation" placeholder="Повторите пароль" required>
                <button type="submit" class="d-flex justify-content-center align-items-center register btn btn-secondary mb-2">Регистрация</button>
            </div>
        </div>
    </div>
</div>