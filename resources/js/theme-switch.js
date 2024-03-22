document.addEventListener("DOMContentLoaded", function() {
    const themeSwitcher = document.querySelector(".theme-switcher");
    const elementsToChangeTheme = document.querySelectorAll(".theme-changeable");
    if(!localStorage.getItem('theme')){
        localStorage.setItem("theme", 'dark');
    }

    // Функция для изменения темы
    function toggleTheme() {
        elementsToChangeTheme.forEach(element => {
            element.classList.toggle("dark");
            element.classList.toggle("light");
        });

        const currentTheme = elementsToChangeTheme[0].classList.contains("dark") ? "dark" : "light";
        themeSwitcher.innerHTML = `
            <img src="../storage/img/site/${currentTheme}-theme.png" alt="Иконка смены темы">
        `;

        localStorage.setItem("theme", currentTheme);
    }

    // Обработчик клика по переключателю темы
    themeSwitcher.addEventListener("click", function() {
        toggleTheme();
    });

    // Проверка сохраненной темы и применение ее при загрузке страницы
    const savedTheme = localStorage.getItem("theme");
    if (savedTheme) {
        elementsToChangeTheme.forEach(element => {
            element.classList.add(savedTheme);
        });
        themeSwitcher.innerHTML = `
            <img src="../storage/img/site/${savedTheme}-theme.png" alt="Иконка смены темы">
        `;
    }
});
