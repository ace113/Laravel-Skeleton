function previewImage(event, imgSection)
{
    console.log(imgSection);
    let reader = new FileReader();
    $('.'+imgSection).css('opacity', 0);
    $('.'+imgSection).removeClass('no-height');
    reader.onload = function()
    {
        setTimeout(function () {
            $('.'+imgSection).css('opacity', 1);
            $('.'+imgSection).css('background-image', 'url(' + reader.result + ')');
        },300);
    }
    reader.readAsDataURL(event.target.files[0]);
}
