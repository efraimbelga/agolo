$(function(){
	// var processId = 0;
	// view_allcationlist(processId)
	function view_allcationlist(processId){
		$.ajax({
	        url: domain + 'Allocation_controller/view_allcationlist',
	        type: 'POST',
	        data: {processId : processId},
	        // dataType: 'json',
	        // contentType: 'application/json',
	        beforeSend: function(){
	        	$('.table-holder').html('<div class="col-lg-12 text-center"><h1><i class="fa fa-spinner fa-spin"></i></h1><p>Please wait</p></div>')			   	
			},
	        success: function(data, textStatus, jqXHR)
	        {
	        	$('#loadingModal').modal('hide');
	            $('.table-holder').html(data)
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	        	$('#loadingModal').modal('hide');
	     		console.log(jqXHR.responseText)
	        }
	    });
	}

	$(document).on('change', '.taskSelect', function(){
		var processId = $(this).val();
		if(processId!= ''){
			$('.clear-btn').prop('disabled', true)
			$('.allocate-btn').prop('disabled', true)
			view_allcationlist(processId)
		}
	})

	$(document).on('click', '.sourceTR', function(){
		if($(this).hasClass('active')){
			alert('Agent is Active. Please deactivate first');
		}else{
			$(this).toggleClass('selected');
			var s = $('.selected').length
			if(s > 0){
				$('.allocate-btn').prop('disabled', false)
				$('.clear-btn').prop('disabled', false)
				
			}else{
				$('.allocate-btn').prop('disabled', true)
				$('.clear-btn').prop('disabled', true)
			}
		}
		
	})

	$(document).on('click', '.allocate-btn', function(){
		var batchArray = []
		var processId = $('.taskSelect').val();

		$("tr.sourceTR.selected").each(function(){
			var BatchName = $(this).children('td:first').text();
			var AgentId = $(this).attr('data-aid');
			var ParentId = $(this).attr('data-pid')
	    	batchArray.push({
	            'BatchName'	: BatchName, 
	            'AgentId'	:  AgentId,
	            'ParentId'	: ParentId
	        });
		});

		if(batchArray.length > 0){
			if(confirm("Please confirm claim")){
				$.ajax({
			        url: domain + 'Allocation_controller/allocate_batch',
			        type: 'POST',
			        data: {batch : batchArray, processId:processId},
			        beforeSend: function(){
			        	$('#loadingModal').modal();
			        },
			        success: function(result, textStatus, jqXHR)
			        {
			        	$('#loadingModal').modal('hide');
			        	console.log(result) 
			        	view_allcationlist(processId)
			            // if(result=='' || result == 'success'){
			            // 	// alert('Source requests claimed')
			            // 	$('.allocate-btn').prop('disabled', true);
			            // 	$('.clear-btn').prop('disabled', true)

			            // 	view_source_request()
			            	
			            // 	// setTimeout(function(){ 
			            // 	// 	AutoAllocate()
			            // 	// }, 1000);
			            // }else{
			            // 	alert(result)
			            // 	$('.allocate-btn').prop('disabled', false);
			            // 	$('.clear-btn').prop('disabled', false)
			            // }
			        },
			        error: function (jqXHR, textStatus, errorThrown)
			        {
			        	$('#loadingModal').modal('hide');
			     		console.log(jqXHR.responseText)
			     		$('.allocate-btn').prop('disabled', false);
			            $('.clear-btn').prop('disabled', false)
			        }
			    });
			}
		}		
	})
})