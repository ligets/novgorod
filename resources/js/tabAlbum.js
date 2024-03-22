document.addEventListener("DOMContentLoaded", function () {
    // JavaScript
    document.getElementById("photosButton").addEventListener("click", function(event) {
      openTab(event, 'photos');
    });
  
    document.getElementById("videosButton").addEventListener("click", function(event) {
      openTab(event, 'videos');
    });
  
    // По умолчанию открываем вкладку "Фото"
    document.getElementById("photos").style.display = "block";
    var defaultTabButton = document.querySelector(".tablinks:nth-child(1)"); // Выбираем первую кнопку с вкладками
    defaultTabButton.classList.add("active"); // Добавляем класс "active" для активации стилей
  });
  
  function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    let display = tabName == "photos" ? "block" : "flex";
    // Получаем все элементы с классом "tabcontent" и скрываем их
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
  
    // Получаем все элементы с классом "tablinks" и удаляем класс "active" у них
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].classList.remove("active");
    }
  
    // Показываем нужную вкладку и добавляем класс "active" к кнопке
    document.getElementById(tabName).style.display = display;
    evt.currentTarget.classList.add("active");
  }
  