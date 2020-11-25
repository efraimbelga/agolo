$(function(){
	// var url      = window.location.href;
	// console.log(url)

	var pathname = window.location.pathname;
	var array = pathname.split('/');
	var processId = array[array.length-1];

	view_source_request(processId)

	function view_source_request(task){
		$.ajax({
	        url: domain + 'Tito_controller/view_tito_monitoring',
	        type: 'POST',
	        data: {processId : processId},
	        // dataType: 'json',
	        // contentType: 'application/json',
	        success: function(data, textStatus, jqXHR)
	        {
	            $('#srTable tbody').html(data)
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	     		console.log(jqXHR.responseText)
	        }
	    });
	}

	$(document).on('click', '.sourceTR', function(){
		$('.sourceTR').removeClass('selected');	
		$(this).toggleClass('selected');	

		var ParentID = $(this).attr('data-ParentID');
		var ReferenceID = $(this).attr('data-ReferenceID');
		// var AllocationRefId = $(this).attr('data-AllocationRefId');
		// AllocationRefId:AllocationRefId
		$.ajax({
	        url: domain + 'Tito_controller/view_tito_form',
	        type: 'POST',
	        data: {ReferenceID : ReferenceID, ParentID:ParentID},
	        success: function(data, textStatus, jqXHR)
	        {
	        	$('#titoModal').html(data)
	            $('#titoModal').modal({
		            backdrop: 'static',
		            keyboard: false
		        });
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	     		console.log(jqXHR.responseText)
	        }
	    });
		
	})

	$(document).on('keydown', 'div[contenteditable=true]', function(e) {
	    // trap the return key being pressed
	    if (e.keyCode == 13) {
	      // insert 2 br tags (if only one br tag is inserted the cursor won't go to the second line)
	      document.execCommand('insertHTML', false, '<br><br>');
	      // prevent the default behaviour of return key pressed
	      return false;
	    }
	});

	$(document).on('click', '.addsesction-btn', function(){
		$.post(domain + 'Tito_controller/subsectionform', function(result){
			$('#psourceTbl').append(result)
		})
	})

	$(document).on('click', '.clearsection-btn', function(e){
		e.preventDefault();
		$(this).closest('tr').remove();
	})

	$(document).on('click', '.clearpsource-btn', function(e){
		e.preventDefault();
		$(this).closest('tr').find('.editablediv').text('')
		$(this).closest('tr').find('.form-control').removeClass('errorinput')
	})

	$(document).on('click', '.savepsource-btn', function(e){
		e.preventDefault();
		var x = 0;
		var tr = $(this).closest('tr');
		var formData = new FormData();
		var ParentID = $('#ParentID').val()
		formData.append('ParentID', ParentID)
		formData.append('sourceType', 'Parent')
		
		tr.find('.form-control').each(function(){
			var el = $(this);
			var value = el.text();
			var key = el.attr('data-key');
			if(value==''){
				el.addClass('errorinput');
				el.focus();
				x++;
			}
			formData.append(key, value);
		})

		if(x<=0){
			save_content_analysis(formData, ParentID, tr)
		}
	})

	$(document).on('click', '.savesection-btn', function(e){
		e.preventDefault();
		var x = 0;
		var tr = $(this).closest('tr');
		var formData = new FormData();
		var ParentID = tr.attr('data-id')
		formData.append('ParentID', ParentID)
		formData.append('sourceType', 'Section')
		formData.append('SectionParentID', $('#ParentID').val())
		formData.append('NewSourceID', $('#NewSourceID').val())
		
		tr.find('.form-control').each(function(){
			var el = $(this);
			var value = el.text();
			var key = el.attr('data-key');
			if(value==''){
				el.addClass('errorinput');
				el.focus();
				x++;
			}
			formData.append(key, value);
		})

		if(x<=0){
			save_content_analysis(formData, ParentID, tr)
		}
	})

	function save_content_analysis(formData, ParentID, tr){
		$.ajax({
		    url: domain + 'Tito_controller/save_content_analysis',
		    type: 'POST',
		    data: formData,
		    contentType: false,
		    processData: false,
		    beforeSend: function(){
		       	$('#loadingModal').modal();
		    },
		    success: function(data, textStatus, jqXHR)
		    {
		    	$('#loadingModal').modal('hide');
		    	if(ParentID=='0'){
		    		if(parseInt(data) > 0){
		    			tr.attr("data-id", data);
		    			$('.titoformModal .errorMsg').text('Data saved')
		    			tr.find('.form-control').removeClass('edited')
		    		}
		    	}else{
		    		if(data=='' || data=='success'){
		    			$('.titoformModal .errorMsg').text('Data saved')
		    			tr.find('.form-control').removeClass('edited')
		    		}else{
		    			$('.titoformModal .errorMsg').text(data)
		    		}
		    	}
		    },
		    error: function (jqXHR, textStatus, errorThrown)
		    {
		    	$('#loadingModal').modal('hide');
		    	$('.titoformModal .errorMsg').text(jqXHR.responseText)
		 		
		    }
		});
		$('.errorinput').removeClass('errorinput');
	}

	$(document).on('click', '.taskdone-btn', function(){
		var x=0;
		var status = $(this).attr('data-value');
		var ParentID = $('#titoModal #ParentID').val()
		var ReferenceID = $('#titoModal #ReferenceID').val();
		var NewSourceID = $('#titoModal #NewSourceID').val();
		var SourceURL = $('#titoModal #SourceURL').text();
		var SourceName = $('#titoModal #SourceName').text();

		var formData = new FormData();		
		formData.append('ParentID', ParentID)
		// formData.append('AllocationRefId', AllocationRefId)
		formData.append('status', status)
		formData.append('ReferenceID', ReferenceID)
		formData.append('NewSourceID', NewSourceID)
		formData.append('SourceURL', SourceURL)
		formData.append('SourceName', SourceName)
		formData.append('status', status)
		$('.myForm .editablediv').each(function(){
			var el = $(this);
			var value = el.text();
			var key = el.attr('data-key');
			formData.append(key, value);
			if(value==''){
				x++;
				el.addClass('errorinput');
				el.focus();
			}
		})
		console.log(x)

		if(x<= 0){
			$.ajax({
			    url: domain + 'Tito_controller/task_out_source',
			    type: 'POST',
			    data: formData,
			    contentType: false,
			    processData: false,
			    beforeSend: function(){
			       	$('#loadingModal').modal();
			    },
			    success: function(data, textStatus, jqXHR)
			    {
			    	$('#loadingModal').modal('hide');
			    	$('.titoformModal .errorMsg').text(data)
			    	if(data=='' || data=='success'){
			    		view_source_request(processId)
			    		setTimeout(function(){ $('#titoModal').modal('hide'); }, 1500);
			    	}
			    },
			    error: function (jqXHR, textStatus, errorThrown)
			    {
			    	$('#loadingModal').modal('hide');
			    	$('.titoformModal .errorMsg').text(jqXHR.responseText)
			 		
			    }
			});
		}
		
			


	})

	$(document).on('click', '.taskout-btn', function(){
		var x = 0;
		// var AllocationRefId = $('#titoModal #AllocationRefId').val();
		var status = $(this).attr('data-value');
		
		var ParentID = $('#titoModal #ParentID').val()
		var ReferenceID = $('#titoModal #ReferenceID').val();
		var NewSourceID = $('#titoModal #NewSourceID').val();
		var SourceURL = $('#titoModal #SourceURL').text();
		var SourceName = $('#titoModal #SourceName').text();

		var formData = new FormData();		
		formData.append('ParentID', ParentID)
		// formData.append('AllocationRefId', AllocationRefId)
		formData.append('status', status)
		formData.append('ReferenceID', ReferenceID)
		formData.append('NewSourceID', NewSourceID)
		formData.append('SourceURL', SourceURL)
		formData.append('SourceName', SourceName)

		$('#psourceTbl .form-control').each(function(){
			if($(this).text()==''){
				x++;
			}
		})

		$('.subsection').each(function(){
			var id = $(this).attr('data-id');
			if(id=='0'){
				x++;
			}
		})

		if($( ".edited" ).length) {
			x++;
			$(".edited").addClass('errorinput')
			alert('Please save all the changes and try again');
		}

		if(x > 0){
			alert('Error detected. Please check')
		}else{
			$.ajax({
			    url: domain + 'Tito_controller/task_out_source',
			    type: 'POST',
			    data: formData,
			    contentType: false,
			    processData: false,
			    beforeSend: function(){
			       	$('#loadingModal').modal();
			    },
			    success: function(data, textStatus, jqXHR)
			    {
			    	$('#loadingModal').modal('hide');
			    	$('.titoformModal .errorMsg').text(data)
			    	if(data=='' || data=='success'){
			    		view_source_request(processId)
			    		setTimeout(function(){ $('#titoModal').modal('hide'); }, 1500);
			    	}
			    },
			    error: function (jqXHR, textStatus, errorThrown)
			    {
			    	$('#loadingModal').modal('hide');
			    	$('.titoformModal .errorMsg').text(jqXHR.responseText)
			 		
			    }
			});
		}
	})

	$(document).on('focusout', '.SourceURL', function(){
		var url = $(this).text();
		var el = $(this);
		if(url.length > 0){
			if(isUrlValid(url)){

			}else{
				el.focus();
				alert("Invalid URL")
			}
		}
	})

	$(document).on('keyup', '.form-control', function(e){
		$(this).addClass('edited')
		$(this).removeClass('errorinput')
	})
})

function isUrlValid(url) {
    return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
}
