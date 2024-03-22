@extends('layouts.main')

@section('style')
<style>
    @font-face {
        font-family: Jura;
        src: url(../fonts/Jura.ttf);
    }
    #prevImage{
        max-width: 96%;
        /* max-height: 600px; */
        border-radius: 25px;
    }
    video{
        max-width: 96%;
        /* max-height: 600px; */
        border-radius: 25px;
    }
    #uploadForm{
        width: 26.26%;
        border-radius: 25px;
        padding: 2%;
    }
    #labelInput{
        height: 35vh;
        width: 100%;
        border-radius: 25px;
        font-size: 5vh;
        cursor: pointer;
    }
    #uploadForm{
        background: linear-gradient(180.00deg, rgb(204, 74, 250),rgb(237, 189, 98) 100%);
        color: rgb(255, 255, 255);
        font-family: Jura;
    }
    .flex{
        display: flex;
    }
    #submitBtn, #cancelBtn{
        border-radius: 15px;
    }
</style>
@endsection

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center">
    <div id="uploadForm" class="d-flex flex-column">
        <input type='file' id="imageFile" style="display: none;"/>
        <label for="imageFile" id="labelInput" class="border border-dark flex justify-content-center align-items-center">
            <span>Загрузить</span>
        </label>
        <div class="mauto d-flex justify-content-center align-items-center">
            <img id="prevImage" src="#" alt="Image" style="display: none;" />
            <video id="prevVideo" style="display: none;" controls>
                Ваш браузер не поддерживает видео.
            </video>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/resumable.js/1.1.0/resumable.min.js"></script> -->

@vite('resources/js/Resource.js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/resumable.js/1.1.0/resumable.min.js"></script>
<script>
$(document).ready(function() {
    // Инициализация Resumable.js
    $('#imageFile').change(function () {
        let parent = this.parentNode;
        parent.removeChild(this);
    });

    var r = new Resumable({
        target: '/resources/upload',
        query: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            type: '1',
            tags: 'Ex1, Ex2, Ex3',
            title: "Это название ресурса"
            // in_album: '1'
        },
        fileType: [
            // RAW
            'CRW', 'CR2', 'NEF', 'NRW', 'ARW', 'RW2', 'ORF', 'RAF', 'DCR', 'SRW', 'RWL', 'MOS',
            //DNG
            'DNG',
            //image
            'png', 'jpeg', 'jpg', 'gif', 'webp', 'bmp', 'ico',
            //video
            'mp4', 'ogv', 'webm', 'avi', 'mpeg', 'mpg', 'mov', 'wmv'
        ],
        chunkSize: 2 * 1024 * 1024, // default is 1*1024*1024, this should be less than your maximum limit in php.ini
        headers: {
            'Accept': 'application/json'
        },
        testChunks: false,
        throttleProgressCallbacks: 1,
    });

    // Обработчик изменения поля ввода файла
    $("#imageFile").change(function() {
        readURL(this);
    });

    // Обработчик отправки формы
    $("#uploadForm").on('click', '#submitBtn', function(event) {
        event.preventDefault(); // Предотвращаем обычную отправку формы
        if (r.files.length > 0) {
            r.upload(); // Запускаем процесс загрузки
        } else {
            alert('Выберите файл для загрузки.');
        }
    });

    r.on('fileProgress', function (file) { // trigger when file progress update
        updateProgress(Math.floor(file.progress() * 100));
    });

    function updateProgress(value) {
        $('#submitBtn').html(`${value}%`)
    }

    // Обработчик завершения загрузки файла
    r.on('fileSuccess', function(file, message) {
        console.log('Файл успешно загружен.');
        // Дополнительные действия после успешной загрузки файла
    });

    // Обработчик ошибки загрузки файла
    r.on('fileError', function(file, message) {
        console.log('Ошибка загрузки файла: ' + message);
        // Дополнительные действия в случае ошибки загрузки файла
    });

    // Функция для отображения изображения перед загрузкой
    function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onloadend = function(e) {
            // Проверяем тип файла
            if(input.files[0].type.startsWith('video')){
                // Если это видео, отображаем его в элементе <video>
                $('#labelInput').css('display', 'none');
                $('#prevVideo').attr('src', e.target.result).css('display', 'block');
                $('#prevVideo')[0].load();
            } else {
                // Если это изображение, отображаем его в элементе <img>
                $('#labelInput').css('display', 'none');
                $('#prevImage').attr('src', e.target.result).css('display', 'block');
            }
            $('#uploadForm').append('<div class="col-md-12 d-flex justify-content-center align-items-center mt-2"><button id="cancelBtn" class="btn border-dark col-md-4">Отмена</button><button id="submitBtn" class="btn border-dark col-md-4 ms-2">Отправить</button></div>')
        }
        reader.readAsDataURL(input.files[0]);
        // Добавляем файл в Resumable.js
        r.addFile(input.files[0]);
    }
}
});
</script>
@endsection