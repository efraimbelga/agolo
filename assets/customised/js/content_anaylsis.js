$(function(){

	

	$(document).on('click', '.savepsource-btn', function(e){
		e.preventDefault();
		$('.errorMsg').text('')
		var x = 0;
		var tr = $(this).closest('tr');
		tr.find('.errorinput').removeClass('errorinput');

		var formData = new FormData();
		var ParentID = $('#ParentID').val()
		formData.append('ParentID', ParentID)
		formData.append('sourceType', 'Parent')
		
		var priority = $('#Priority').text();
		priority = priority.replace(/\s/g,'')
		if(priority===""){
			$('#Priority').addClass('errorinput');
			$('#Priority').focus();
			x++;
		}
		else{
			tr.find('.form-control').each(function(){
				var el = $(this);
				var value = el.text();
				var key = el.attr('data-key');
				formData.append(key, value);
			})
			save_content_analysis(formData, ParentID, tr)
		}
	});

	$(document).on('click', '.clearsection-btn', function(e){
		e.preventDefault();
		var ParentID = $(this).closest('tr').attr('data-id')
		if(ParentID != '0'){
			$.post(domain + 'Tito_controller/delete_section', {ParentID: ParentID}, function(result){
				console.log(result)
			})
		}
		$(this).closest('tr').remove();
		if(!$('.subsection').length){
			$('.subsectiontr').addClass('displayNone');
		}
	})

	$(document).on('click', '.clearpsource-btn', function(e){
		e.preventDefault();
		$('.errorMsg').text('')
		$(this).closest('tr').find('.editablediv').text('')
		$(this).closest('tr').find('.form-control').removeClass('errorinput')
	})

	$(document).on('click', '.addsesction-btn', function(){
		$('.errorMsg').text('')
		$.post(domain + 'Tito_controller/subsectionform', function(result){
			$('.subsectiontr').removeClass('displayNone');
			$('#psourceTbl').append(result)
		})
	})

	$(document).on('click', '.taskout-btn', function(){
		$('.errorMsg').text('')

		var x = 0;
		var error = false;
		var errorMsg = "";

		var AllocationRefId = $('.CONTENT_ANALYSIS #AllocationRefId').val();
		var status = $(this).attr('data-value');
		
		var ParentID = $('.CONTENT_ANALYSIS #ParentID').val()
		var ReferenceID = $('.CONTENT_ANALYSIS #ReferenceID').val();
		var NewSourceID = $('.CONTENT_ANALYSIS #NewSourceID').val();
		var SourceURL = $('.CONTENT_ANALYSIS #SourceURL').text();
		var SourceName = $('.CONTENT_ANALYSIS #SourceName').text();

		var formData = new FormData();		
		formData.append('ParentID', ParentID)
		formData.append('AllocationRefId', AllocationRefId)
		formData.append('status', status)
		formData.append('ReferenceID', ReferenceID)
		formData.append('NewSourceID', NewSourceID)
		formData.append('SourceURL', SourceURL)
		formData.append('SourceName', SourceName)
		

		$('.contentanalysisTbl .requiredDiv').each(function(){
			if($(this).text()==''){
				$(this).addClass('errorinput')
				error=true;
				errorMsg="Please complete all required fields";
			}
		})

		$('.subsection').each(function(){
			var id = $(this).attr('data-id');
			if(id=='0'){
				error=true;
				errorMsg="Please save or delete newly added subsection";
			}
		})

		if(status=='Pending'){
			formData.append('Remark', '')
			x=0;
		}else{
			$('.contentanalysisTbl .Remark').each(function(){
				var value = $(this).text();
				formData.append('Remark', value)
				if($(this).text()==''){
					$(this).addClass('errorinput')
					error=true;
					errorMsg="Please add remark";
				}
			})
		}
		
		if($( ".edited" ).length) {
			$(".edited").addClass('errorinput')
			error=true;
			errorMsg="Please save all the changes made";
		}

		if(error){
			alert(errorMsg)
		}else{
			console.log(status)
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
			    	$('.CONTENT_ANALYSIS .errorMsg').text(data)
			    	if(data=='' || data=='success'){
			        	window.opener.CloseChildWindows();
			        	window.opener.view_source_request(1)
			    	}
			    },
			    error: function (jqXHR, textStatus, errorThrown)
			    {
			    	$('#loadingModal').modal('hide');
			    	$('.CONTENT_ANALYSIS .errorMsg').text(jqXHR.responseText)
			 		
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
			el.removeClass('errorinput');
			var value = el.text();
			var nospace = value.replace(/\s/g,'');
			var key = el.attr('data-key');
			if(key=='Priority' || key=='SourceURL'){
				if(nospace===""){
					el.addClass('errorinput');
					el.focus();
					x++;
				}
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
		    	console.log(data)
		    	$('#loadingModal').modal('hide');
		    	if(ParentID=='0'){
		    		if(parseInt(data) > 0){
		    			tr.attr("data-id", data);
		    			$('.CONTENT_ANALYSIS .errorMsg').text('Data saved')
		    			tr.find('.form-control').removeClass('edited')
		    		}
		    	}else{
		    		if(data=='' || data=='success'){
		    			$('.CONTENT_ANALYSIS .errorMsg').text('Data saved')
		    			tr.find('.form-control').removeClass('edited')
		    		}else{
		    			$('.CONTENT_ANALYSIS .errorMsg').text(data)
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
})