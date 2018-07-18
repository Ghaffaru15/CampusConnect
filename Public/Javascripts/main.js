$(document).ready(() => {
    $('#sell-nav').on('click', () => {
    $('.dropdown-nav').slideToggle('slow');
});
    $('#sell-nav').on('mouseenter', () => {
    $('.dropdown-nav').slideToggle('slow');
});
    $('#sell-nav').on('mouseleave', () => {
    $('.dropdown-nav').hide();
});

    $('#user-nav').on('click', () => {
    $('.user-dropdown').slideToggle('slow');
});
    $('#user-nav').on('mouseenter', () => {
    $('.user-dropdown').slideToggle('slow');
});
    $('#user-nav').on('mouseleave', () => {
    $('.user-dropdown').hide();
});





    $("#img-1").on("change", (e) => {
        var fileName = e.target.value.split('\\').pop();
        $('#file-text').text(fileName);
        $('#img-upload-2').show();
    });


    $("#img-2").on("change", (e) => {
        var fileName = e.target.value.split('\\').pop();
        $('#file-text-2').text(fileName);
        $('#img-upload-3').show();
    });

    $("#img-3").on("change", (e) => {
        var fileName = e.target.value.split('\\').pop();
        $('#file-text-3').text(fileName);
        $('#img-upload-4').show();
    });

    $("#img-4").on("change", (e) => {
        var fileName = e.target.value.split('\\').pop();
        $('#file-text-4').text(fileName);
    });

    let current = document.querySelector('#inner-main-img');
    let otherImgs = document.querySelectorAll('.other-imgs img');
    let opacity = 0.6;

    otherImgs.forEach(img => img.addEventListener('click', imgClick))

    function imgClick(e) {
        otherImgs.forEach(img => (img.style.opacity = 1));

        current.src = e.target.src;
        e.target.style.opacity = opacity;

    }
})
