@vite('resources/css/createAlbum.css')
<div class="modal fade" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="create-album" method="POST">
        @csrf
        <!-- Заголовок модального окна -->
        <div class="modal-header">
          <h4 class="modal-title">Добавить фото в альбом</h4>
          <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        </div>
        
        <!-- Тело модального окна -->
        <div class="modal-body">
          <div class="form-group">
              <label for="albumName">Название альбома:</label>
              <input type="text" name="title" class="form-control" id="albumName">
          </div>
          <div class="form-group">
              <label for="albumName">Описание:</label>
              <input type="text" name="description" class="form-control" id="albumName">
          </div>
          <div class="form-group">
              <label for="albumCover">Обложка альбома:</label>
              <input type="file" class="form-control-file mb-2 btn-pink" id="albumCover" accept="image/*">
          </div>
          <div id="dropArea" class="mb-3">Перетащите сюда файлы или кликните для выбора</div>
          <h5>Настройки доступа к альбому:</h5>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="access" id="publicAccess" value="1" checked>
            <label class="form-check-label" for="publicAccess">Открыть для всех</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="access" id="privateAccess" value="3">
            <label class="form-check-label" for="privateAccess">Сделать личным</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="access" id="customAccess" value="2">
            <label class="form-check-label" for="customAccess">Открыть для определённых пользователей</label>
          </div>
        </div>
        
        <!-- Подвал модального окна -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
          <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Подключение Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script>
    // Функция для обработки перетаскивания файлов
    function handleDrop(e) {
        e.preventDefault();
        let dt = e.dataTransfer;
        let files = dt.files;
        handleFiles(files);
    }

    function handleFiles(files) {
        for (let i = 0; i < files.length; i++) {
            let file = files[i];
            // Делаем что-то с файлом, например, загружаем его на сервер
            console.log('Файл загружен:', file.name);
        }
    }

    // Предотвращаем стандартное поведение браузера при перетаскивании файлов
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        document.getElementById('dropArea').addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // Устанавливаем стиль при наведении курсора на область перетаскивания
    document.getElementById('dropArea').addEventListener('dragenter', function(e) {
        this.classList.add('hover');
    });

    // Убираем стиль при выходе курсора за пределы области перетаскивания
    ['dragleave', 'drop'].forEach(eventName => {
        document.getElementById('dropArea').addEventListener(eventName, function(e) {
            this.classList.remove('hover');
        });
    });

    // Обрабатываем сброс файлов на область перетаскивания
    document.getElementById('dropArea').addEventListener('drop', handleDrop, false);

    // Обработка выбора чекбокса "Открыть для определённых пользователей"
    document.getElementById('customAccess').addEventListener('change', function() {
        if (this.checked) {
            document.getElementById('coauthorsGroup').style.display = 'block';
        } else {
            document.getElementById('coauthorsGroup').style.display = 'none';
        }
    });
</script>

</body>
</html>
