$(function () {
    $('#date-nacimiento').datetimepicker({
        viewMode: 'days',
        format: 'DD/MM/YYYY'});

    $('#date-start').datetimepicker({
		viewMode: 'days',
        format: 'DD/MM/YYYY'});

    $('#date-end').datetimepicker({
    	viewMode: 'days',
        format: 'DD/MM/YYYY'});
    
    $("#date-start").on("dp.change",function (e) {
        $('#date-end').data("DateTimePicker").minDate(e.date);
    });
    $("#date-end").on("dp.change",function (e) {
        $('#date-start').data("DateTimePicker").maxDate(e.date);
    });
});

if($('.alert') != null ){
    setTimeout(function(){ $('.alert').hide(1000); }, 3000);
}

$('#myButton').on('click', function () {
    var $btn = $(this).button('loading')
    // business logic...
    $btn.button('reset')
})