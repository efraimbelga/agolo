$(function(){
	load_published_list()

	function load_published_list(){
		$.ajax({
	        url: domain + 'Published_controller/load_published_list',
	        type: 'POST',
	        success: function(data, textStatus, jqXHR)
	        {
	            $('.tableHolder').html(data)
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	     		console.log(jqXHR.responseText)
	        }
	    });
	}

	var cState = '';
	

	$(document).on('change', '.agentState-opt', function(){
		var state = $(this).val();
		if(state != ''){
			if(confirm('Are you sure want to change state?')){
				var ParentID = $(this).closest('tr').attr('data-pid');
				var AgentID = $(this).closest('tr').attr('data-aid');
				
				var jqxhr = $.post( domain + 'Published_controller/insert_AgentStateHistory', {ParentID:ParentID, AgentID:AgentID, state:state}, function(result) {
				  	if(result=='' || result=='succss'){
				  		load_published_list()
				  	}else{
				  		alert(result)
				  	}
				})
				.fail(function() {
				    alert( "error" );
				});
 
			}
			else{
				$(this).val(cState)
			}
		}
		else{
			$(this).val(cState)
		}
		
	})

	$(document).on('focus', '.agentState-opt', function(){
		cState = $(this).val();
		console.log(cState)
	})
})