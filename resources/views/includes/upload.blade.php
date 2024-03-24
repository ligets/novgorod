<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true" data-album="{{ isset($album) ? $album->id : 'null' }}">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 25px; border: none;">
            <div class="d-flex flex-column justify-content-center align-items-center">
                <div id="uploadForm" class="d-flex flex-column col-md-12">
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
                    <form id="info" style="margin-left: 3%; display: none;"> <label for="title" style="margin-top: 1%;">Название:</label><br> <input type="text" id="title" name="title" style="border-radius: 10px; border:none; outline:none; padding: 1%;" required><br></form>
                    <select name="tags[]" id="tagsCont" multiple style="display: none;">
                        @foreach(App\Models\Tag::all() as $tag)
                            <option value="{{ $tag->name }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                    <div class="d-none" id="Type">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="publicRadio" value="1">
                            <label class="form-check-label" for="publicRadio">Открыть для всех</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="privateRadio" value="3">
                            <label class="form-check-label" for="privateRadio">Сделать личным</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>