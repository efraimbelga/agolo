$(function(){
	view_source_request()

	function view_source_request(){
		$.ajax({
	        url: domain + 'Basecontroller/view_source_request',
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

	$(document).on('click', '.sourceTR', function(){
		$(this).toggleClass('selected');
		var s = $('.selected').length
		if(s > 0){
			$('.claim-btn').prop('disabled', false)
			$('.clear-btn').prop('disabled', false)
			
		}else{
			$('.claim-btn').prop('disabled', true)
			$('.clear-btn').prop('disabled', true)
		}
	})

	$(document).on('click', '.claim-btn', function(){
		var sourceArray = []
		$("tr.sourceTR.selected").each(function(){
	    	sourceArray.push($(this).attr('data-id'));
		});

		if(sourceArray.length > 0){
			if(confirm("Please confirm claim")){
				$.ajax({
			        url: domain + 'Basecontroller/claim_request',
			        type: 'POST',
			        data: {source : sourceArray},
			        beforeSend: function(){
			        	$('#loadingModal').modal();
			        },
			        success: function(result, textStatus, jqXHR)
			        {
			        	$('#loadingModal').modal('hide');
			        	console.log(result) 
			            if(result=='' || result == 'success'){
			            	// alert('Source requests claimed')
			            	$('.claim-btn').prop('disabled', true);
			            	$('.clear-btn').prop('disabled', true)

			            	view_source_request()
			            	
			            	// setTimeout(function(){ 
			            	// 	AutoAllocate()
			            	// }, 1000);
			            }else{
			            	alert(result)
			            	$('.claim-btn').prop('disabled', false);
			            	$('.clear-btn').prop('disabled', false)
			            }
			        },
			        error: function (jqXHR, textStatus, errorThrown)
			        {
			        	$('#loadingModal').modal('hide');
			     		console.log(jqXHR.responseText)
			     		$('.claim-btn').prop('disabled', false);
			            $('.clear-btn').prop('disabled', false)
			        }
			    });
			}
		}		
	})

	$(document).on('click', '.clear-btn', function(){
		$('.sourceTR').removeClass('selected');
		$('.clear-btn').prop('disabled', true)
		$('.claim-btn').prop('disabled', true);
	})

})


