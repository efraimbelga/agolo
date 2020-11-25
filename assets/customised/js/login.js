$(function(){
	$(document).on('submit', '#loginform', function(e){
		e.preventDefault();
		var form = $(this);
		$.ajax({
           	type: "POST",
           	url: domain+'Basecontroller/loginuser',
           	data: form.serialize(), // serializes the form's elements.
           	success: function(data)
           	{
              console.log(data)
           		if(data == 'ok'){
           			location.reload();
           		}else{
           			$('.errorMsg').text(data)
           		}
           	}
        });
	})
})