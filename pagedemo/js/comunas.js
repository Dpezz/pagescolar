$(function () {

    $('#region').change(function(){
        var region = $('#region').val();
        var str = window.location;
        if(str.pathname.indexOf("new") == -1)
            var url = "../../load/comuna"
        else
            var url = "../load/comuna"
        $.ajax({
            url: url,
            data: {'region':region},
            success: function(item){
                $('#comuna').removeAttr('disabled');
                var comunas = item.split(',');
                $("#comuna").html('');

                $("<option value=''>-- Comuna --</option>").appendTo("#comuna");
                for (var i = 0; i < comunas.length; i++) {
                    $("<option value='"+comunas[i]+"'>"+comunas[i]+"</option>").appendTo("#comuna");
                };
            }
        })
    })
    //load comunas
   
    if($('#region').val() != '' && (document.URL.indexOf("docentes/perfil") != -1 || document.URL.indexOf("alumnos/perfil") != -1) ){
        var region = $('#region').val();
        var comuna = $('#comuna_load').val();
        $.ajax({
            url:'../../load/comuna',
            data: {'region':region},
            success: function(item){
                $('#comuna').removeAttr('disabled');
                var comunas = item.split(',');
                $("#comuna").html('');

                $("<option value=''>-- Comuna --</option>").appendTo("#comuna");
                for (var i = 0; i < comunas.length; i++) {
                    if(comunas[i] == comuna){
                        $("<option value='"+comunas[i]+"' selected>"+comunas[i]+"</option>").appendTo("#comuna");
                    }else{
                        $("<option value='"+comunas[i]+"'>"+comunas[i]+"</option>").appendTo("#comuna");
                    }
                };
            }
        })
    }
})