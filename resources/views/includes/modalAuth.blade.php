<!--------------- login ----------------------->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column align-items-center">
                <span class="topic">Вход</span>
                <div class="social">
                    <button class="google">
                        <img class="gg" src="{{ asset('storage/img/google.png') }}">
                    </button>
                    <button class="telegram">
                        <img class="tg" src="{{ asset('storage/img/tg.png') }}">
                    </button>
                    <button class="vkontakte">
                        <img class="vk" src="{{ asset('storage/img/vk.png') }}">
                    </button>
                </div>
                <input class="email form-control mb-2" type="email" placeholder="E-mail">
                <input class="password form-control mb-2" type="password" placeholder="Введите пароль">
                <button class="d-flex justify-content-center align-items-center log-in btn btn-secondary mb-2">Вход</button>
            </div>
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
            <div class="modal-body d-flex flex-column align-items-center">
                <span class="topic">Регистрация</span>
                <div class="social">
                    <button class="google">
                        <img class="gg" src="./img/Ellipse 3.png">
                    </button>
                    <button class="telegram">
                        <img class="tg" src="./img/Ellipse 1.png">
                    </button>
                    <button class="vkontakte">
                        <img class="vk" src="./img/Ellipse 2.png">
                    </button>
                </div>
                <input class="email form-control mb-2" type="email" placeholder="E-mail">
                <input class="login form-control mb-2" type="text" placeholder="Логин">
                <input class="password form-control mb-2" type="password" placeholder="Введите пароль">
                <input class="repit-password form-control mb-2" type="password" placeholder="Повторите пароль">
                <button class="d-flex justify-content-center align-items-center register btn btn-secondary mb-2">Регистрация</button>
            </div>
        </div>
    </div>
</div>