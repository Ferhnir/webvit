$('#datepicker_from').datepicker({
    uiLibrary: 'bootstrap4'
});
$('#datepicker_to').datepicker({
    uiLibrary: 'bootstrap4'
});

$(document).ready(function() {    
    setTimeout(function(){
        $("#flashAlert").fadeOut(1000);
    },'4000');
});

function checkPasswordMatch() {
    var password = $("#NewPassword").val();
    var confirmPassword = $("#ReNewPassword").val();

    if (password != confirmPassword)
        $("#PassRessetBttn").attr("disabled", "disabled");
    else
        $("#PassRessetBttn").removeAttr("disabled"); 
}

$(document).ready(function () {
   $("#ReNewPassword").keyup(checkPasswordMatch);
});