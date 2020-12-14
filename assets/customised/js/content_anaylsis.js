$(function(){

	

	$(document).on('click', '.savepsource-btn', function(e){
		e.preventDefault();
		$('.errorDiv').html('')
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
		$('.errorDiv').html('')
		$(this).closest('tr').find('.editablediv').text('')
		$(this).closest('tr').find('.form-control').removeClass('errorinput')
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
				errorDiv="Please complete all required fields";
			}
		})

		$('.subsection').each(function(){
			var id = $(this).attr('data-id');
			if(id=='0'){
				error=true;
				errorDiv="Please save or delete newly added subsection";
			}
		})

		if(status=='Pending'){
			formData.append('Remark', '')
			x=0;
		}else{
			if( $('#Remark').text() ==''){
				$('#Remark').addClass('errorinput')
				error=true;
				errorDiv="Please add remark";
			}
			else{
				formData.append('Remark', $('#Remark').text())
			}
		}
		
		if($( ".edited" ).length) {
			$(".edited").addClass('errorinput')
			error=true;
			errorDiv="Please save all the changes made";
		}

		if(error){
			alert(errorDiv)
		}else{
			// console.log(status)
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
		    	var obj = JSON.parse(data);
		    	if(obj.error== false){
		    		if(ParentID=='0'){
		    			tr.attr("data-id", obj.message);
		    			tr.find('.form-control').removeClass('edited')
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