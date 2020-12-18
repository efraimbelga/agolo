$(function(){
	
	$(document).on('click', '.clearsection-btn', function(e){
		e.preventDefault();
		var ParentID = $(this).closest('tr').find('.ParentID').val()
		console.log(ParentID)
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
		$('.errorDiv').html('')
		var tr = $(this).closest('tr');

		tr.find('.form-control').each(function(){
			if($(this).hasClass('SourceURL')){

			}else{
				$(this).removeClass('errorinput')
				$(this).val('')
			}
		})
	})

	$(document).on('click', '.addsesction-btn', function(){
		$('.errorDiv').html('')
		$.post(domain + 'Tito_controller/subsectionform', function(result){
			$('.subsectiontr').removeClass('displayNone');
			$('#psourceTbl').append(result)
		})
	})

	$(document).on('click', '.taskout-btn', function(){
		$('.errorDiv').html('')

		var x = 0;
		var error = false;
		var errorDiv = "";
		var status = $(this).attr('data-value');
		var formData = new FormData();

		formData.append('Status', status)		
		formData.append('ParentID', $('.CONTENT_ANALYSIS #ParentID').val())
		formData.append('AllocationRefId', $('.CONTENT_ANALYSIS #AllocationRefId').val())
		formData.append('ReferenceID', $('.CONTENT_ANALYSIS #ReferenceID').val())
		formData.append('NewSourceID', $('.CONTENT_ANALYSIS #NewSourceID').val())
		formData.append('SourceURL', $('.CONTENT_ANALYSIS #SourceURL').val())
		formData.append('SourceName', $('.CONTENT_ANALYSIS #SourceName').val())
		formData.append('processId', '1')
		

		// $('.contentanalysisTbl .form-control').each(function(){
		// 	if($(this).val()==''){
		// 		$(this).addClass('errorinput')
		// 		error=true;
		// 		errorDiv="Please complete all required fields";
		// 	}
		// })

		$('.subsection').each(function(){
			var id = $(this).find('.ParentID').val()
			if(id=='0'){
				error=true;
				errorDiv="Please save or delete newly added subsection";
			}
		})

		if(status=='Pending'){
			formData.append('Remark', '')
			x=0;
		}else if(status=='Done'){
			if( $('#Remark').text() ==''){
				$('#Remark').addClass('errorinput')
				error=true;
				errorDiv="Please add remark";
			}
			else{
				formData.append('Remark', $('#Remark').text())
			}
		}else if($( ".edited" ).length) {
			$(".edited").addClass('errorinput')
			error=true;
			errorDiv="Please save all the changes made";
		}

		if(error){
			alert(errorDiv)
		}else{
			console.log(error)
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
			    	// console.log(data)
			    	var obj = JSON.parse(data);
			    	if(obj.error== false){
			    		alert('Saved');
			    		window.opener.CloseChildWindows();
			        	window.opener.view_source_request(1)
			    	}else{
			    		$('.errorDiv').html('<p class="errorMsg">'+obj.message+'</p>')
			    	}
			    },
			    error: function (jqXHR, textStatus, errorThrown)
			    {
			    	$('#loadingModal').modal('hide');
			    	$('.errorDiv').html(jqXHR.responseText)
			 		
			    }
			});
		}
	})

	$(document).on('focusout', '.SourceURL', function(){
		var url = $(this).val();
		var el = $(this);
		if(url.length > 0){
			if(isUrlValid(url)){

			}else{
				el.focus();
				alert("Invalid URL")
			}
		}
	})


	$(document).on('submit', '.subsectionFrom', function(e){
		e.preventDefault();
		var form = $(this);
		var tr = $(this).closest('tr')
		var formData = form.serialize()+'&sourceType=Section&SectionParentID='+$('#SectionParentID').val()+'&NewSourceID='+$('#NewSourceID').val();
		save_content_analysis(formData, tr)
	});

	$(document).on('submit', '#parentdataForm', function(e){
		e.preventDefault();
		var form = $(this);
		var tr = $(this).closest('tr')
		var formData = form.serialize()+'&sourceType=Parent';
		save_content_analysis(formData, tr)
	});

	function save_content_analysis(formData, tr){
		$.ajax({
		    url: domain + 'Tito_controller/save_content_analysis',
		    type: 'POST',
		    data: formData,
		    // contentType: false,
		    // processData: false,
		    beforeSend: function(){
		       	$('#loadingModal').modal();
		    },
		    success: function(data, textStatus, jqXHR)
		    {
		    	$('#loadingModal').modal('hide');
		    	console.log(data)
		    	
		    	var obj = JSON.parse(data);
		    	if(obj.error== false){
		    		if(parseInt(obj.message) > 0){
		    			tr.find('.ParentID').val(obj.message)
			    	}
			    	tr.find('.form-control').removeClass('edited')
			    	$('.errorDiv').html('Data saved')
		    	}else{
		    		$('.errorDiv').html('<p class="errorMsg">'+obj.message+'</p>')
		    	}
		    },
		    error: function (jqXHR, textStatus, errorThrown)
		    {
		    	$('#loadingModal').modal('hide');
		    	$('.errorDiv').html(jqXHR.responseText)
		 		
		    }
		});
		$('.errorinput').removeClass('errorinput');
	}
})