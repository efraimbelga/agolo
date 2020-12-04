$(function(){
	view_source_request()

	function view_source_request(){
		$.ajax({
	        url: domain + 'Tito_controller/view_published_list',
	        type: 'POST',
	        // dataType: 'json',
	        // contentType: 'application/json',
	        success: function(data, textStatus, jqXHR)
	        {
	            $('#srTable tbody').html(data)
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	     		console.log(jqXHR.responseText)
	        },
	        // data: JSON.stringify(data)
	    });
	}

	$(document).on('click', '.allocate-btn', function(){
		var BatchName = $(this).attr('data-BatchName')
		$.post(domain+'Tito_controller/allocate_refinement', {BatchName:BatchName}, function(result){
			console.log(result);
		})
	})


})

function AutoAllocate(){
	$.post(domain + 'Basecontroller/AutoAllocate', function(result){
		console.log(result)
	})
}
	
