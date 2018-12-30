$(function(){

	$('#choose').on('keyup', function(){
		var data = $(this).val();
        $.ajax({
            url: '/stock-manage/inc/command_form.php',
            type: 'post',
            data: "choose="+data,
            beforeSend:function(){
                $('#result').html('<div class="text-center"><img src="libs/image/ajax-loader.gif"/></div>');
            },success: function(e){
                 $('#result').html(e);
            }
        });

        
	});

	$(document).on('change', '.model', function(){
		var da = $(this).val();
		var uni = $(this).parent
    	$.ajax({
        	url: '/stock-manage/controler/command.c.php',
        	type: 'post',
        	data: "model="+da,
        	success: function(e){
            	 $('.unitie').val(e);
        	}
    	});
	});

});