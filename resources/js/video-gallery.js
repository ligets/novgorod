document.addEventListener("DOMContentLoaded", function () {
  var videoContainers = document.querySelectorAll(".video-preview-container");

  videoContainers.forEach(function (container) {
    var video = container.querySelector(".video");
    var preview = container.querySelector(".video-preview");

    // Обработчик клика на превью видео
    preview.addEventListener("click", function () {
      // Показываем видео, скрывая превью
      video.style.display = "none";
      preview.style.display = "block";
    });

    // Обработчик события, срабатывающего при загрузке метаданных видео
    video.addEventListener("loadedmetadata", function () {
      // Устанавливаем текущее время видео на начало
      this.currentTime = 0;
    });

    // Обработчик события, срабатывающего при загрузке первого кадра
    video.addEventListener("seeked", function () {
      // Создаем изображение из первого кадра и устанавливаем его как превью
      var canvas = document.createElement("canvas");
      canvas.width = this.videoWidth;
      canvas.height = this.videoHeight;
      var ctx = canvas.getContext("2d");
      ctx.drawImage(this, 0, 0, canvas.width, canvas.height);
      preview.src = canvas.toDataURL();
    });

    // Обработчик события, срабатывающего при клике на другую область
    document.addEventListener("click", function (event) {
      if (!container.contains(event.target)) {
        // Показываем превью, скрывая видео
        video.style.display = "none";
        preview.style.display = "block";
        video.pause(); // Пауза видео, если оно воспроизводится
      }
    });

    // Загружаем видео
    video.load();
  });
});
