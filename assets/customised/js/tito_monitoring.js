var contentanalysiswindow;
var urlwindow;

function CloseChildWindows(){
	contentanalysiswindow.close()
	urlwindow.close();
}

var pathname = window.location.pathname;
var array = pathname.split('/');
var processId = array[array.length-1];
var timer;
function view_source_request(processId){
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

function checkChild() {
    if (contentanalysiswindow.closed) {
        urlwindow.close();  
        clearInterval(timer);
        view_source_request(processId)
    }else if (urlwindow.closed) {
        contentanalysiswindow.close();  
        clearInterval(timer);
        view_source_request(processId)
    }
}

$(function(){
	
	view_source_request(processId)

	$(document).on('click', '.allocate-btn', function(){
		var processId = $(this).attr('data-value');
		var user = 'YH4';
		$.post(domain + 'Tito_controller/allocate_source', {processId:processId, user:user}, function(result){
			console.log(result);
			view_source_request(processId)
		})
	});

	$(document).on('click', '.sourceTR', function(){
		var tr = $(this);
		var error = false;
		var status = $(this).attr('data-status');
		var ParentID = $(this).attr('data-parentid');
		var ReferenceID = $(this).attr('data-ReferenceID');
		var AllocationRefId = $(this).attr('data-AllocationRefId');
		var status = $(this).attr('data-status')
		var processname = $('#processidTxtx').val();

		if($(this).hasClass("Ongoing")){

		}else{
			if ($(".Ongoing")[0]){
			   error = true;
			}
		}

		if(error ==  false){
			$('.sourceTR').removeClass('selected');	
			$(this).toggleClass('selected');	

			
			if(processname=='CONTENT_ANALYSIS'){
				var w = window.screen.availWidth ;
		        var h = window.screen.availHeight / 3;
		        var h2 = window.screen.availHeight / 2;
		        h2 = h2 + 50;
		        

				$.ajax({
			        // url: domain + 'Tito_controller/view_tito_form',
			        url: domain + 'Tito_controller/get_url',
			        type: 'POST',
			        data: {ParentID:ParentID},
			        success: function(data, textStatus, jqXHR)
			        {
			        	if(contentanalysiswindow){
			        		contentanalysiswindow.close()
			        	}else if(urlwindow){
			        		urlwindow.close()
			        	}
			        	tr.removeClass('Allocated')
			        	tr.addClass('Ongoing')
			        	
			        	contentanalysiswindow = window.open(domain+"content_analysis?ParentID="+ParentID+"&AllocationRefId="+AllocationRefId+"&status="+status, "contentanalysiswindow", "width="+w+", height="+h+", left=0, top=0"); 
			        	h = h+50;
			        	urlwindow = window.open(data, "urlwindow", "width="+w+", height="+h2+", left=0, top="+h+"");
			        	timer = setInterval(checkChild, 500)
			        },
			        error: function (jqXHR, textStatus, errorThrown)
			        {
			     		console.log(jqXHR.responseText)
			        }
			    });
			}else{
				$.ajax({
			        url: domain + 'Tito_controller/view_tito_form',
			        type: 'POST',
			        data: {ParentID:ParentID, status:status, AllocationRefId:AllocationRefId, ReferenceID:ReferenceID},
			        success: function(data, textStatus, jqXHR)
			        {
			        	$('#titoModal').html(data);
			        	$('#titoModal').modal();
			        },
			        error: function (jqXHR, textStatus, errorThrown)
			        {
			     		console.log(jqXHR.responseText)
			        }
			    });
			}

			
		}else{
			alert('Ongoing TITO detected')
		}
	})

	function openWindow(url) {  
	   
	    if (typeof (winRef) == 'undefined' || winRef.closed) {
	        //create new, since none is open
	        winRef = window.open(url, "_blank");
	    }
	    else {
	        try {
	            winRef.document; //if this throws an exception then we have no access to the child window - probably domain change so we open a new window
	        }
	        catch (e) {
	            winRef = window.open(url, "_blank");
	        }

	        //IE doesn't allow focus, so I close it and open a new one
	        if (navigator.appName == 'Microsoft Internet Explorer') {
	            winRef.close();
	            winRef = window.open(url, "_blank");
	        }
	        else {
	            //give it focus for a better user experience
	            winRef.focus();
	        }
	    }
	}
	// $(document).on('click', '.sourceTR', function(){
	// 	$('.sourceTR').removeClass('selected');	
	// 	$(this).toggleClass('selected');	

	// 	var ParentID = $(this).attr('data-parentid');
	// 	var ReferenceID = $(this).attr('data-ReferenceID');
	// 	var AllocationRefId = $(this).attr('data-AllocationRefId');
	// 	var status = $(this).attr('data-status')
	// 	console.log(ParentID)
	// 	$.ajax({
	//         url: domain + 'Tito_controller/view_tito_form',
	//         type: 'POST',
	//         data: {ReferenceID : ReferenceID, ParentID:ParentID, AllocationRefId:AllocationRefId, status:status},
	//         success: function(data, textStatus, jqXHR)
	//         {
	//         	$('#titoModal').html(data)
	//             $('#titoModal').modal({
	// 	            backdrop: 'static',
	// 	            keyboard: false
	// 	        });
	//         },
	//         error: function (jqXHR, textStatus, errorThrown)
	//         {
	//      		console.log(jqXHR.responseText)
	//         }
	//     });
		
	// })

	$(document).on('click', '.taskdone-btn', function(){
		var x=0;
		var status = $(this).attr('data-value');
		var ParentID = $('#titoModal #ParentID').val()
		var ReferenceID = $('#titoModal #ReferenceID').val();
		var NewSourceID = $('#titoModal #NewSourceID').val();
		var SourceURL = $('#titoModal #SourceURL').text();
		var SourceName = $('#titoModal #SourceName').text();
		var processId = $('#titoModal #processId').val();
		var AllocationRefId = $('#titoModal #AllocationRefId').val();
		var SourceID = $('#titoModal #SourceID').text();
		

		var formData = new FormData();		
		formData.append('ParentID', ParentID)
		formData.append('AllocationRefId', AllocationRefId)
		formData.append('status', status)
		formData.append('ReferenceID', ReferenceID)
		formData.append('NewSourceID', NewSourceID)
		formData.append('SourceURL', SourceURL)
		formData.append('SourceName', SourceName)
		formData.append('status', status)
		formData.append('SourceID', SourceID)

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

		if(processId != '1'){
			if(status=='Done'){
				var Remark = $('#titoModal .Remarks').text();
				if(Remark==''){
					x++;
					$('#titoModal .Remarks').addClass('errorinput');
				}
				formData.append('Remark', Remark)

				if(processId =='2'){
					var AgentID = $('#titoModal #AgentID').text();
					if(AgentID==''){
						x++;
						$('#titoModal #AgentID').addClass('errorinput');
					}
					formData.append('AgentID', $('#titoModal #AgentID').text())
				}				
			}
			
		}
		// console.log(processId)

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

})

