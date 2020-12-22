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
})