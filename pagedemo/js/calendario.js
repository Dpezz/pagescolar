$(function () {

    xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "calendario_evaluaciones", false);
    xmlhttp.send();

    var obj = $.parseJSON(xmlhttp.responseText);
    //console.log(obj);

    var date = new Date;
    var y = date.getFullYear();
    var m = date.getMonthFormatted();
    var d = date.getDateFormatted();

    var fecha = y + "-" + m + "-" + d;

    //console.log(fecha)

    var calendar = $('#calendar').calendar({
       
            events_source: obj,
            language: 'es-ES',
            timezone: jstz.determine().name(),
            view: 'month',
            tmpl_path: '../../../bundles/pagedemo/plugin/bootstrap-calendar/tmpls/',
            tmpl_cache: false,
            day: fecha,
            onAfterEventsLoad: function(events) {
                if (!events) {
                    return;
                }
            },
            onAfterViewLoad: function(view) {
                $('.page-header h3').text(this.getTitle());
                $('.btn-group button').removeClass('active');
                $('button[data-calendar-view="' + view + '"]').addClass('active');
            },
            classes: {
                months: {
                    general: 'label'
                }
            }
    });

    $('.btn-group button[data-calendar-nav]').each(function() {
        var $this = $(this);
        $this.click(function() {
            calendar.navigate($this.data('calendar-nav'));
        });
    });

    $('.btn-group button[data-calendar-view]').each(function() {
        var $this = $(this);
        $this.click(function() {
            calendar.view($this.data('calendar-view'));
        });
    });

    $('#first_day').change(function(){
        var value = $(this).val();
        value = value.length ? parseInt(value) : null;
        calendar.setOptions({first_day: value});
        calendar.view();
    });

    $('#language').change(function(){
        calendar.setLanguage($(this).val());
        calendar.view();
    });

    $('#events-in-modal').change(function(){
        var val = $(this).is(':checked') ? $(this).val() : null;
        calendar.setOptions({modal: val});
    });
    $('#events-modal .modal-header, #events-modal .modal-footer').click(function(e){
        //e.preventDefault();
        //e.stopPropagation();
    });
})