<div class="modal" tabindex="-1" role="dialog" id="modalSignin">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h1 class="fw-bold mb-0 fs-2">Авторизация</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-5 pt-0">
                <form action="/auth/login" method="POST">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="floatingInput" name="login" placeholder="Логин">
                        <label for="floatingInput">Логин</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-3" id="floatingPassword" name="password" placeholder="Password">
                        <label for="floatingPassword">Пароль</label>
                    </div>
                    <button class="w-100 mb-2 btn btn-lg rounded-3 btn-dark" type="submit">Войти</button>
                </form>
            </div>
        </div>
    </div>
</div>