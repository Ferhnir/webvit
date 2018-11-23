//Form
//1* date picker
$('#datepicker_from').datepicker({
    uiLibrary: 'bootstrap4'
});
$('#datepicker_to').datepicker({
    uiLibrary: 'bootstrap4'
});
//2* download report bttn
$("#DownloadCsv").on('click', reloadPage);
//=======================================

//Password reset validation
$("#ReNewPassword").keyup(checkPasswordMatch);

function checkPasswordMatch() {
    var password = $("#NewPassword").val();
    var confirmPassword = $("#ReNewPassword").val();

    if (password != confirmPassword)
        $("#PassRessetBttn").attr("disabled", "disabled");
    else
        $("#PassRessetBttn").removeAttr("disabled"); 
}
//=======================================

//Page reload after form download
$(document).ready(function() {    
    
    setTimeout(function(){
        $("#flashAlert").fadeOut(1000);
    },4000);
    
});

function reloadPage() {
    console.log('page reloaded');
    setTimeout(function(){
        location.reload();
    },2000);
}
//=======================================

  