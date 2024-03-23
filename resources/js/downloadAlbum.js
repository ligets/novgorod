$('#download').click(function () {
    let link = document.createElement("a");
    let url = window.location.href
    let pathSegments = url.split('/'); // Разбиваем URL по символу '/'
    let lastSegment = pathSegments.pop();
    link.href = "/resources/download/album/" + lastSegment;
    link.click();
})