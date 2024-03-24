// $('#example-tabs').on('change.zf.tabs', function() {
//   grid();
// })

// function play(){
  var $grid = $(".grid").masonry({
    itemSelector: ".grid-item",
    percentPosition: true,
    columnWidth: ".grid-sizer",
    gutter: 10,
    horizontalGutter: 10,
  });
// }
// layout Masonry after each image loads
$grid.imagesLoaded().progress(function () {
  $grid.masonry();
});

// $("[data-fancybox='video']").fancybox({
//   type: "video",
//   buttons: [
//     'download',
//     'close'
//   ]
// });

// $("[data-fancybox='gallery']").fancybox({
//   type: "image", // Указываем тип контента как изображение
//   buttons: [
//     "rotateButton",
//     "zoom",
//     "slideShow",
//     "fullScreen",
//     "download",
//     "thumbs",
//     "close",
//   ],
  // btnTpl: {
  //   rotateButton:
  //     '<button data-fancybox-rotate class="fancybox-button fancybox-button--rotate" title="Rotate Image">' +
  //     '<i class="fas fa-redo"></i>' +
  //     "</button>", // Создаем кнопку для поворота изображения
  //   zoom:
  //     '<button data-fancybox-zoom class="fancybox-button fancybox-button--zoom" title="{{ZOOM}}">' +
  //     '<i class="fas fa-search-plus"></i>' +
  //     "</button>", // Задаем класс fancybox-button--zoom
  //   share:
  //     '<button data-fancybox-share class="fancybox-button fancybox-button--share" title="{{SHARE}}">' +
  //     '<i class="fas fa-share-alt"></i>' +
  //     "</button>", // Задаем класс fancybox-button--share
  //   slideShow:
  //     '<button data-fancybox-play class="fancybox-button fancybox-button--play" title="{{SLIDESHOW}}">' +
  //     '<i class="fas fa-play"></i>' +
  //     "</button>", // Задаем класс fancybox-button--play
  //   fullScreen:
  //     '<button data-fancybox-fullscreen class="fancybox-button fancybox-button--fullscreen" title="{{FULL_SCREEN}}">' +
  //     '<i class="fas fa-expand"></i>' +
  //     "</button>", // Задаем класс fancybox-button--fullscreen
  //   download:
  //     '<button data-fancybox-download class="fancybox-button fancybox-button--download" title="{{DOWNLOAD}}">' +
  //     '<i class="fas fa-download"></i>' +
  //     "</button>", // Задаем класс fancybox-button--download
  //   thumbs:
  //     '<button data-fancybox-thumbs class="fancybox-button fancybox-button--thumbs" title="{{THUMBS}}">' +
  //     '<i class="fas fa-th-large"></i>' +
  //     "</button>", // Задаем класс fancybox-button--thumbs
  //   close:
  //     '<button data-fancybox-close class="fancybox-button fancybox-button--close" title="{{CLOSE}}">' +
  //     '<i class="fas fa-times"></i>' +
  //     "</button>", // Задаем класс fancybox-button--close
  // },
  
// });
// $.fancybox.defaults.btnTpl.map = '<button data-fancybox-exif class="fancybox-button fancybox-button--map" title="Посмотреть на карте" onclick="map()">' +
// '<img src="../storage/img/site/map.png"  class="roundbutton"  alt="Посмотреть на карте" title="Посмотреть на карте" >'  +
//   '</button>';

$('[data-fancybox="gallery"]').fancybox({
  type: 'image',
  buttons : [
    'clear',
    'map',
    'close'
],
btnTpl: {
  map: '<button data-fancybox-map class="fancybox-button fancybox-button--map" title="Посмотреть на карте">' +
    '<img src="../storage/img/site/map.png" class="roundbutton" alt="Посмотреть на карте" title="Посмотреть на карте">' +
    '</button>',
  
  clear: '<button data-fancybox-map class="fancybox-button fancybox-button--map" title="Посмотреть на карте">' +
  '<img src="../storage/img/site/clear.svg" class="roundbutton" alt="Удалить" title="Удалить">' +
  '</button>'
  },
  afterShow: function(instance, current) {
    // Добавьте ваш обработчик события клика на кнопку "map" здесь
    $('[data-fancybox-map]').on('click', function() {
      let photo_id = current.opts.$orig.find('img').data('id');
      let csrfToken = $('meta[name="csrf-token"]').attr('content');
      
      let form = $('<form action="/photo/map" method="POST">' +
      '<input type="hidden" name="_token" value="' + csrfToken + '">' +
        '<input type="hidden" name="dataId" value="' + photo_id + '">' +
        '</form>');
      $('body').append(form);
      form.submit();
    }),
    $('[data-fancybox-map]').on('click', function() {
      let photo_id = current.opts.$orig.find('img').data('id');
      let csrfToken = $('meta[name="csrf-token"]').attr('content');

      let form = $('<form action="/photo/delete" method="POST">' +
      '<input type="hidden" name="_token" value="' + csrfToken + '">' +
        '<input type="hidden" name="dataId" value="' + photo_id + '">' +
        '</form>');
      $('body').append(form);
      form.submit();
    })
  }
})


$('[data-fancybox="images"]').fancybox({
  type: 'image',
  buttons : [
    'map',
    'close'
],
btnTpl: {
  map: '<button data-fancybox-map class="fancybox-button fancybox-button--map" title="Посмотреть на карте">' +
    '<img src="../storage/img/site/map.png" class="roundbutton" alt="Посмотреть на карте" title="Посмотреть на карте">' +
    '</button>',
  
  clear: '<button data-fancybox-map class="fancybox-button fancybox-button--map" title="Посмотреть на карте">' +
  '<img src="../storage/img/site/clear.svg" class="roundbutton" alt="Удалить" title="Удалить">' +
  '</button>'
  },
  afterShow: function(instance, current) {
    // Добавьте ваш обработчик события клика на кнопку "map" здесь
    $('[data-fancybox-map]').on('click', function() {
      let photo_id = current.opts.$orig.find('img').data('id');
      let csrfToken = $('meta[name="csrf-token"]').attr('content');
      
      let form = $('<form action="/photo/map" method="POST">' +
      '<input type="hidden" name="_token" value="' + csrfToken + '">' +
        '<input type="hidden" name="dataId" value="' + photo_id + '">' +
        '</form>');
      $('body').append(form);
      form.submit();
    }),
    $('[data-fancybox-map]').on('click', function() {
      let photo_id = current.opts.$orig.find('img').data('id');
      let csrfToken = $('meta[name="csrf-token"]').attr('content');

      let form = $('<form action="/photo/delete" method="POST">' +
      '<input type="hidden" name="_token" value="' + csrfToken + '">' +
        '<input type="hidden" name="dataId" value="' + photo_id + '">' +
        '</form>');
      $('body').append(form);
      form.submit();
    })
  }
})