$(function(){
	$('#prebulishedform').submit(function(e){
		e.preventDefault();
		var formData = new FormData( $(this)[0] );
  		$.ajax({
  		    url: domain+'Register_controller/upload_prepublished',
  		    type: 'POST',
            data: formData,
            beforeSend: function() {
            	$('.errorMsg').text('')
            	$('#loadingModal').modal();
		    },
            success:function(data){
                $('#loadingModal').modal('hide');
                $('#inputfile').val('')
                $('.errorMsg').text(data)
            },
            cache: false,
            contentType: false,
            processData: false
  		});

	})
})