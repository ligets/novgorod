$(document).ready(function() {
    // Инициализация Resumable.js
    console.log($('#uploadModal').data('album'))
    var r = new Resumable({
        target: '/resources/upload',
        query: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            in_album: $('#uploadModal').data('album')
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
    $("#imageFile").on('change', function() {
        readURL(this);
        console.log(1);
    });

    // Обработчик отправки формы
    $("#uploadForm").on('click', '#submitBtn', function(event) {
        event.preventDefault(); // Предотвращаем обычную отправку формы
        if (r.files.length > 0) {
            let tagsValue = JSON.stringify($('#tagsCont').val());
            r.opts.query.tags = tagsValue;
            r.opts.query.type = $("input[name='type']:checked").val(),
            console.log($("input[name='type']:checked").val());
            r.upload(); // Запускаем процесс загрузки
        } else {
            alert('Выберите файл для загрузки.');
        }
    });

    $("#uploadForm").on('click', '#cancelBtn', function(event) {
        $('#labelInput').css('display', 'flex')
        $('#prevImage').css('display', 'none').attr('src', '');
        $('#prevVideo').css('display', 'none').attr('src', '');
        $('#imageFile').val('');
        $('#tagsCont').select2("destroy");
        $('#uploadForm #btn_cont').remove()
        $("#uploadForm #info").remove();
    });

    r.on('fileProgress', function (file) { // trigger when file progress update
        updateProgress(Math.floor(file.progress() * 100));
    });

    function updateProgress(value) {
        $('#submitBtn').html(`${value}%`)
    }

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
            $("#info").css('display', 'block')
            $('#tagsCont').select2({
                placeholder: "Выбор тегов",
                tags: true,
                width: 'auto'
            })
            $('#Type').removeClass('d-none').addClass('d-flex');
            $("#uploadForm").append(
                '<div class="col-md-12 d-flex justify-content-center align-items-center mt-2" id="btn_cont"><button id="cancelBtn" class="btn border-dark col-md-4" data-dismiss="modal">Очистить</button><button id="submitBtn" class="btn border-dark col-md-4 ms-2">Отправить</button></div>'
            );
        }
        reader.readAsDataURL(input.files[0]);
        // Добавляем файл в Resumable.js
        r.addFile(input.files[0]);
    }
}
});