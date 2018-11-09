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