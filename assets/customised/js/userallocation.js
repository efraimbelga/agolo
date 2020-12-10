$(function(){
	view_allcationlist()
	function view_allcationlist(){
		$.ajax({
	        url: domain + 'Basecontroller/view_allcationlist',
	        type: 'POST',
	        // data: {processId : processId},
	        // dataType: 'json',
	        // contentType: 'application/json',
	        success: function(data, textStatus, jqXHR)
	        {
	            $('#allocationTable tbody').html(data)
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	     		console.log(jqXHR.responseText)
	        }
	    });
	}
})