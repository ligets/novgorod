<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Модальное окно для добавления фото в альбом</title>
<!-- Подключение Bootstrap CSS -->
<link rel="stylesheet" href="css/drop.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
    #dropArea {
        border: 2px dashed #fb3570;
        width: 100%;
        padding: 20px;
        text-align: center;
    }
    #dropArea.hover {
        border-color: #000;
    }
    #alb{
    font-family: Jura;
    font-weight: 900;
    line-height: normal;
    font-size: 15px;
    text-align: center;
    font-style: normal;
    width: 8%;
    margin-top: auto;
}
.btn {
    display: inline-block;
    border-radius: 1rem;
}
.btn-primary {
    color: #fff;
    background-color: #fb3570;
    border: none;
}
.btn-primary:not(:disabled):not(.disabled).active, .btn-primary:not(:disabled):not(.disabled):active, .show>.btn-primary.dropdown-toggle {
    color: #fff;
    background-color: #fff;
    border-color: #005cbf;
}
body {
    font-family: Jura;
}

.modal-content {
  border: 2px solid transparent;
  border-radius: 10px;
  background: linear-gradient(#fff 0 0) padding-box,
    linear-gradient(to right, #9c20aa, #fb3570) border-box;
}
.btn-pink {
        background-color: pink;
        border-color: pink;
        color: white;
    }

    .btn-pink:hover {
        background-color: #ff69b4;
        border-color: #ff69b4;
        color: white;
    }

</style>
</head>
<body>

<!-- Кнопка для открытия модального окна -->

<button type="button" id="alb" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
  Изменить альбом
</button>

<!-- Модальное окно -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    
      <!-- Заголовок модального окна -->
      <div class="modal-header">
        <h4 class="modal-title">Изменить альбом</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
      <!-- Тело модального окна -->
      <div class="modal-body">
        <div class="form-group">
            <label for="albumName">Название альбома:</label>
            <input type="text" class="form-control" id="albumName">
        </div>
        <div class="form-group">
            <label for="albumCover">Обложка альбома:</label>
            <input type="file" class="form-control-file mb-2 btn-pink" id="albumCover" accept="image/*">
        </div>
        <div id="dropArea" class="mb-3">Перетащите сюда файлы или кликните для выбора</div>
        <h5>Настройки доступа к альбому:</h5>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="access" id="publicAccess" value="public">
          <label class="form-check-label" for="publicAccess">Открыть для всех</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="access" id="privateAccess" value="private">
          <label class="form-check-label" for="privateAccess">Сделать личным</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="access" id="customAccess" value="custom">
          <label class="form-check-label" for="customAccess">Открыть для определённых пользователей</label>
        </div>
        <div class="form-group">
            <label for="albumCoAuthors">Соавторы альбома (разделяйте имена запятыми):</label>
            <input type="text" class="form-control" id="albumCoAuthors">
        </div>
      </div>
      
      <!-- Подвал модального окна -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
        <button type="button" class="btn btn-primary">Сохранить</button>
      </div>
      
    </div>
  </div>
</div>

<!-- Подключение jQuery, необходимого для Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Подключение Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
