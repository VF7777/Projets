$(document).ready(function(){
    $('.button').click(function(){
        var clickBtnValue = $(this).val();
        var ajaxurl = 'blanc.php',
        data =  {'action': clickBtnValue};
        $.post(ajaxurl, data, function (response) {
            alert("action performed successfully");
        });
    });
});
