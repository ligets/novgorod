@vite('resources/css/createAlbum.css')
<div class="modal fade" id="editAlbum">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="/edit-album" method="POST">
        @csrf
        <input type="text" name="id" value="{{ $album->id }}" style="display: none;">
        <!-- Заголовок модального окна -->
        <div class="modal-header">
          <h4 class="modal-title">Добавить фото в альбом</h4>
        </div>
        <!-- Тело модального окна -->
        <div class="modal-body">
          <h5>Настройки альбома:</h5>
          <div class="form-group">
              <label for="albumName">Название альбома:</label>
              <input type="text" name="title" class="form-control" id="albumName" value="{{ $album->title }}">
          </div>
          <div class="form-group">
              <label for="albumName">Описание:</label>
              <input type="text" name="description" class="form-control" id="albumName" value="{{ $album->description }}">
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="access" id="publicAccess" value="1" {{ $album->type_id == 1 ? 'checked' : '' }}>
            <label class="form-check-label" for="publicAccess">Открыть для всех</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="access" id="privateAccess" value="3" {{ $album->type_id == 3 ? 'checked' : '' }}>
            <label class="form-check-label" for="privateAccess">Сделать личным</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="access" id="customAccess" value="2" {{ $album->type_id == 2 ? 'checked' : '' }}>
            <label class="form-check-label" for="customAccess">Открыть для определённых пользователей</label>
          </div>
          <div class="selCont">
            <select id="authors" name="authors[]" multiple style="display: none;">
              @foreach(App\Models\User::whereNot('login', Auth::user()->login)->get() as $user)
                <option value="{{ $user->id }}" {{ $authors->contains('user_id', $user->id) ? 'selected' : '' }}>{{ $user->login }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <!-- Подвал модального окна -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
          <button type="submit" class="btn btn-dark">Сохранить</button>
        </div>
      </form>
    </div>
  </div>
</div>
