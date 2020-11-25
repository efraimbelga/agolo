$(function(){
	view_tito_monitoring()

	function view_tito_monitoring(){
		$.ajax({
	        url: domain + 'Basecontroller/view_tito_monitoring',
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
		var id =  $(this).attr('data-id')
		$.ajax({
	        url: domain + 'Basecontroller/analysisModal',
	        type: 'POST',
	        success: function(data, textStatus, jqXHR)
	        {
	        	var source = JSON.parse(data)
	        	$('#analysisModal .sourceurlTxt').text(source.SourceURL);
	        	$('#analysisModal .referenceidTxt').text(source.ReferenceID);
	        	$('#analysisModal .claimedbyTxt').text(source.ClaimedBy);
	        	$('#analysisModal .claimeddateTxt').text(source.ClaimedDate);
	        	
	            $('#analysisModal').modal({"backdrop": "static"})
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	     		console.log(jqXHR.responseText)
	        },
	        data: {id : id}
	    });
		
	})
})