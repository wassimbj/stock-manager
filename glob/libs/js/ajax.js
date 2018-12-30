$(function(){

    $('#choose').on('keyup', function(){
        var data = $(this).val();
        $.ajax({
            url: 'inc/command_form.php',
            type: 'post',
            data: {choose: data},
            beforeSend:function(){
                $('#result').html('<div class="text-center"><img src="libs/image/ajax-loader.gif"/></div>');
            },success: function(e){
                 $('#result').html(e);
            }
        });

        
    });

    $(document).on('change', '.model', function(){
        var da = $(this).val(),
            $this = $(this),
            id = $(this).data('id');
        $.ajax({
            url: 'controler/command.c.php',
            type: 'post',
            data: {model: da},
            success: function(prix){
                 $this.closest(`#${id}`).find('#unitie').val(prix);
            }
        });
    });

});