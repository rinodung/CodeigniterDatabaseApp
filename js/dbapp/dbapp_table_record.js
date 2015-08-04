// IIFE - Immediately Invoked Function Expression
(function($, window, document) {

	// The $ is now locally scoped 

   	// Listen for the jQuery ready event on the document
   	$(function() {

   		// The DOM is ready!

   	});
   	
   	
   	//view record set
   	$('#zeTable').on("click", "a.crudView", function(e){
   	
   		temp = $(this).attr('id').split("_");
   		   		
   		recordID = temp[1];
   		
   		_rowIndex = recordID;
   		
   		//save the row element for later
   		_theRow = $(this).closest('tr');
   		
   		//set the heading
   		$('#recordViewModal .modal-header h4').text(_theTable+", record "+recordID);
   		
   		$.ajax({
   			type: "GET",
   			dataType: "json",
   		  	url: _BASE_URL+"/db/getRecord/"+_theDB+"/"+_theTable+"/"+_tablePrimaryKey+"/"+recordID+"/viewrecord"
   		}).done(function(response){

   			if(response.response_code == 2) {
   			
   				$('#recordViewModal_tab1 > .alert-error').each(function(){ $(this).remove() })
   					
   				$('#recordViewModal_tab1').prepend($(response.message));
   				
   				return false;
   			
   			}
   			
   			//empty out the first tab
   			$('#recordViewModal_tab1 > *').each(function(){
   			
   				$(this).remove();
   			
   			});
   			
   			//update the view
   			$('#recordViewModal_tab1').append($(response.record));
   			
   			
   		})
   	
   	})
   	
   	
   	//load a record set
   	$('#zeTable').on("click", "a.crudEdit", function(e){
   	
   		temp = $(this).attr('id').split("_");
   		   				
   		recordID = temp[1];
		   		
   		_rowIndex = recordID;
   		
   		//save the row element for later
   		_theRow = $(this).closest('tr');
   				
   		//set the heading
   		$('#recordModal .modal-header h4').text(_theTable+", record "+recordID);
   		
   		$.ajax({
   			type: "GET",
   			dataType: "json",
   		  	url: _BASE_URL+"/db/getRecord/"+_theDB+"/"+_theTable+"/"+_tablePrimaryKey+"/"+recordID
   		}).done(function(response){
   		
   			if(response.response_code == 2) {
   			
   				$('#recordModal_tab1 > .alert-error').each(function(){ $(this).remove() })
   					
   				$('#recordModal_tab1').prepend($(response.message));
   				
   				return false;
   			
   			}
   			
   			$('#recordModal_tab1 > *').each(function(){
   			
   				$(this).remove();
   			
   			});
   			
   			//setup the flat ui checkboxes
   			$('#recordModal_tab1').append($(response.record));
   			
   			//sift through all items and activate redactor where HTML is present
   			$('#recordDetails > .panel').each(function(){
   			   			
   				if(/<[a-z][\s\S]*>/i.test( $(this).find('textarea').val() )) {
   				   				
   					//data contains HTML
   					$(this).find('textarea').redactor({
   						paragraphy: false,
   						imageUpload: _BASE_URL+'/redactorUpload/upImage',
   						fileUpload: _BASE_URL+'/redactorUpload/upFile',
   						buttons: ['html', 'formatting', 'bold', 'italic',
   						'unorderedlist', 'orderedlist',
   						'image', 'video', 'file', 'link', 'alignment', 'horizontalrule']
   					});
   					
   					$(this).find('input[type="checkbox"]').prop('checked', true)
   				
   				}
   			
   			})
   			
   			$('#recordDetails').find(':checkbox').checkbox();
   			
   			//setup the chosen select boxes
   			$('#recordModal_tab1 select').chosen({width: '100%'});
   			
   			//auto-resize for text areas
   			$('#recordModal_tab1 textarea').autosize();
   			
   			//setup possible datepicker
   			// jQuery UI Datepicker
   			var datepickerSelector = $('#recordModal_tab1').find('.date');

   			$(datepickerSelector).datepicker({
   				showOtherMonths: true,
   			  	selectOtherMonths: true,
   			  	dateFormat: "yy-mm-dd",
   			  	yearRange: '-1:+1'
   			}).prev('.btn').on('click', function (e) {
   			  e && e.preventDefault();
   			  $(datepickerSelector).focus();
   			});
   					
   			//ajax form for update record
   			$('#recordForm').ajaxForm(function(responseText) {
   			
   				$('#recordModal_save').removeClass('disabled').text('Update record');
   				
   				$('#recordModal_tab1 > .alert-error').each(function(){ $(this).remove() })
   			
   				response = jQuery.parseJSON(responseText);
   			
   				if(responseText.response_code == 2) {
   				
   					$('#recordModal_tab1 > .alert-error').each(function(){ $(this).remove() })
   						
   					$('#recordModal_tab1').prepend($(response.message));
   					
   					return false;
   				
   				} 
   			
   				window.location.hash = '#recordModal_tab1';
   				   				
   				$('#recordModal_tab1').prepend($(response.message));
   				
   				//setup the chosen select boxes
   				$('#recordModal_tab1 select').chosen({width: '100%'});
   				
   				//auto-resize for text areas
   				$('#recordModal_tab1 textarea').autosize();
   				   			
   				//setup possible datepicker
   				// jQuery UI Datepicker
   				var datepickerSelector = $('#recordModal_tab1').find('.date');
   				
   				$(datepickerSelector).datepicker({
   					showOtherMonths: true,
   				   	selectOtherMonths: true,
   				  	dateFormat: "yy-mm-dd",
   				   	yearRange: '-1:+1'
   				}).prev('.btn').on('click', function (e) {
   					e && e.preventDefault();
   				   $(datepickerSelector).focus();
   				});
   				
   				//message self destruct
   				window.setTimeout(function() { $("#recordModal_tab1 > .alert-success").fadeOut(1000, function(){$(this).remove()}); }, 3000);
   				
   				
   				//update the record in the table
   				zeTable.fnReloadAjax();
   				
   				doTableLink();
   				
   				//update view with revisions
   				$('#recordRevisions').remove();
   				$('#recordModal_tab2').append($(response.revisions)).find("input:checkbox").checkbox();
   				
   				//update nr of revisions in tab
   				$('#recordModal_revisionsTotal').text( $('#recordRevisions .panel').size() );
   				
   			});
   			
   		})
   		
   		//load record revisions
   		$.ajax({
   			type: "GET",
   			dataType: "json",
   		  	url: _BASE_URL+"/revisions/loadRecordRevisions/"+_theDB+"/"+_theTable+"/"+_tablePrimaryKey+"/"+recordID
   		}).done(function(response){
   		
   			if(response.response_code == 2) {
   			
   				$('#recordModal_tab2 > .alert-error').each(function(){ $(this).remove() })
   					
   				$('#recordModal_tab2').prepend($(response.message));
   				
   				return false;
   			
   			}
   			
   			//out with the old
   			$('#recordRevisions').remove();
   						
   			//in with the new
   			$('#recordModal_tab2').append($(response.revisions)).find(":checkbox").checkbox();
   			
   			$('#recordRevisions').find('.tt').tooltip()
   			
   			$('#recordRevisions').on("load", ".toggle-all", function(){
   				var ch = $(this).find(':checkbox').prop('checked');
   				$(this).closest('.table').find('tbody :checkbox').checkbox(!ch ? 'check' : 'uncheck');
   			})
   			
   			//update the number of revisions
   			$('#recordModal_revisionsTotal').text($('#recordRevisions .panel').size());
   			
   			//uncheck all checkboxes and disable save button when collapsed
   			$('#recordRevisions .panel').on("hidden.bs.collapse", function(){
   			
   				$(this).find('label.checkbox').removeClass("checked");
   				$(this).find('input[type=checkbox]').attr("checked", false);
   			
   				$(this).find('.restoreRevisionButton').addClass('disabled');
   			
   			})
   			
   		})
   		
   		
   		//load the record notes
   		//load record revisions
   		$.ajax({
   			type: "GET",
   			dataType: "json",
   		  	url: _BASE_URL+"/recordnotes/getRecordNotes/"+_theDB+"/"+_theTable+"/"+_tablePrimaryKey+"/"+recordID
   		}).done(function(response){
   		
   			if(response.response_code == 2) {
   			
   				$('#recordModal_tab3 > .alert-error').each(function(){ $(this).remove() })
   					
   				$('#recordModal_tab3').prepend($(response.message));
   				
   				return false;
   				   			
   			}
   			
   			//add notes to the view
   			
   			$('#recordNotes > *').each(function(){ $(this).remove() });
   			
   			$('#recordNotes').append($(response.notes));
   			
   			
   			//update the number notes as well
   			$('#recordModal_notesTotal').text( $('#recordNotes .alert').size() );
   			
   		})
   	
   	});
   	
   	
   	var recordRevisionsTab = $('#recordModal_tab2');
   		
   		//enable/disable restore revisions button
   		recordRevisionsTab.on("change", ".revisionPartCheckbox", function(){
   		
   			//check if at least one of the checkboxes is checked
   			if($(this).closest('table').find('input[type=checkbox]:checked').length) {
   			
   				//enable save revision button
   				$(this).closest('.panel-body').find('.restoreRevisionButton').removeClass('disabled');
   			
   			} else {
   				
   				//disable save revision button
   				$(this).closest('.panel-body').find('.restoreRevisionButton').addClass('disabled');
   			
   			}
   		
   		})
   		
   		var _restoreRevisionButton;
   		
   		//restore record revisions button
   		recordRevisionsTab.on("click", ".restoreRevisionButton", function(){
   		
   			//disable button
   			$(this).addClass('disabled').text('Restoring selected fields ...');
   			
   			//save button for later
   			_restoreRevisionButton = $(this);
   		
   			if(confirm("Restoring this record revision will result in the current value being overwritten. Would you like to continue?")) {
   					
   				cellRevisions = new Array();
   				
   				$('#recordModal_tab2').find('input[type=checkbox]:checked').each(function(){
   				
   					cellRevisions.push($(this).val());
   				
   				})
   				
   				//send to the server
   				$.ajax({
   					type: "POST",
   					dataType: "json",
   				  	url: _BASE_URL+"/revisions/restoreRecordRevision/"+_theDB,
   				  	data: { revisions: cellRevisions, _token: _TOKEN}
   				}).done(function(response){
   				
   					_restoreRevisionButton.removeClass('disabled').text('Restore selected fields ...');
   				
   					if(response.response_code == 2) {
   					
   						$('#recordModal_tab2 > .alert-error').each(function(){ $(this).remove() })
   							
   						$('#recordModal_tab2').prepend($(response.message));
   						
   						return false;
   						   			
   					}
   								
   					$('#recordModal_tab2').prepend(response.message);
   					
   					//message self destruct
   					window.setTimeout(function() { $("#recordModal_tab2 > .alert").fadeOut(1000, function(){$(this).remove()}); }, 3000);
   					
   					window.location.hash = '#recordModal_tab2';
   					
   					//update table row
   					
   					counter = 1;
   					
   					$.each(response.record, function(key, value) {
   					
   						if(counter > 1) {
   					   	
   					   		_theRow.find('td:eq('+(counter)+') div').text(value.val);
   					   	
   					   	}
   					   	
   					   	counter++;
   					   	
   					});
   					
   					//update revisions
   					$('#recordModal_tab2 #recordRevisions').remove();
   					$('#recordModal_tab2').append($(response.revisions)).find("input:checkbox").checkbox();
   					
   					//update nr of revisions in tab
   					$('#recordModal_revisionsTotal').text( $('#recordRevisions .panel').size() );
   					
   					
   					//update the record form
   					$('#recordModal_tab1 #recordForm').remove();
   					$('#recordModal_tab1').append($(response.recordForm)).find("input:checkbox").checkbox();
   				
   				});
   			
   			}
   		
   		});
   		
   		
   		//delete recordRevision button
   		
   		var _theDeletedRecordRevision;
   		
   		recordRevisionsTab.on("click", ".deleteRecordRevision", function(){
   		
   			_theDeletedRecordRevision = $(this).closest('.panel');
   		
   			if(confirm("Are you sure you want delete this entire record revision?")) {
   		
   				//send to the server
   				$.ajax({
   					type: "POST",
   					dataType: "json",
   			  		url: _BASE_URL+"/revisions/deleteRecordRevision/"+_theDB+"/"+_theTable+"/"+_tablePrimaryKey+"/"+_rowIndex,
   			  		data: { timestamp: $(this).attr('id'), _token: _TOKEN}
   				}).done(function(response){
   				
   					if(response.response_code == 2) {
   					
   						$('#recordModal_tab2 > .alert-error').each(function(){ $(this).remove() })
   							
   						$('#recordModal_tab2').prepend($(response.message));
   						
   						return false;
   					
   					}
   			
   					$('#recordModal_tab2').prepend(response.success_message);
   				
   					//auto destruct the success message
   					window.setTimeout(function() { $("#recordModal_tab2 > .alert").fadeOut(1000, function(){$(this).remove()}); }, 3000);
   				
   					window.location.hash = '#recordModal_tab2';
   					
   					//update the nr of revisions in the tab
   					$('#recordModal_revisionsTotal').text( $('#recordRevisions .panel').size() );
   			
   					//delete the revision fromm the DMO/modal
   					_theDeletedRecordRevision.fadeOut(1000, function(){
   					
   						$(this).remove()
   						//update the nr of revisions in the tab
   						$('#recordModal_revisionsTotal').text( $('#recordRevisions .panel').size() );
   						
   						//fix up the numbering
   						$('#recordRevisions .panel').each(function(i){
   						
   							$(this).find('.panel-title a span:first').text(i+1);
   						
   						})
   						
   					});
   					
   				});
   			
   			}
   		
   		})
   		
   		
   	$('#recordModal_save').click(function(){
   	
   		//disable button
   		$(this).addClass('disabled').text('Updating record ...');
   		
   		$('form#recordForm').submit();
   	
   	});
   	
   	
   	//new record note
   	$('#recordModal_addnote').on("click", function(){
   	
   		//disable button
   		$(this).addClass('disabled').text('Adding new note ...');
   	
   		if( $('#recordModal_newnote').redactor('get') != '' ) {
   		
   			$.ajax({
   				type: "POST",
   				dataType: "json",
   				data: {note: $('#recordModal_newnote').redactor('get'), _token: _TOKEN},
   			  	url: _BASE_URL+"/recordnotes/newNote/"+_theDB+"/"+_theTable+"/"+_tablePrimaryKey+"/"+_rowIndex
   			}).done(function(response){
   			
   				//re-enable the button
   				$('#recordModal_addnote').removeClass('disabled').text('Add new note');
   			
   				if(response.response_code == 2) {
   				
   					$('#recordModal_tab3 > .alert-error').each(function(){ $(this).remove() })
   						
   					$('#recordModal_tab3').prepend($(response.message));
   					
   					return false;
   				
   				}
   				
   				//add notes to the view
   				
   				$('#recordNotes > *').each(function(){ $(this).remove() });
   				
   				$('#recordNotes').append($(response.notes));
   				
   				
   				//update the number notes as well
   				$('#recordModal_notesTotal').text( $('#recordNotes .alert').size() );
   				
   				
   				//display success message
   				$('#recordModal_tab3').prepend( $(response.success_message) );
   				
   				window.location.hash = '#recordModal_tab3';
   				
   				window.setTimeout(function() { $("#recordModal_tab3 .alert-success").fadeOut(1000, function(){$(this).remove()}); }, 3000);
   			
   			})
   			
   		} else {
   		
   			alert('Please make sure you enter a new note.')
   		
   		}
   	
   	});
   	
   	
   	//edit record note
   	$('#recordNotes').on("click", ".noteEdit", function(){
   	
   		//initialize textarea
   		$(this).closest('.alert').find('.noteContent').redactor();
   		
   		//show/hide buttons
   		$(this).closest('.details').hide();
   		$(this).closest('.details').next().show();
   	
   	})
   	
   	
   	var _recordModal_savenote;
   	
   	//update record note
   	$('#recordNotes').on("click", ".recordModal_savenote", function(){
   	
   		if( $(this).closest('.alert').find('.noteContent').redactor('get') != '' ) {
   		
   			//disable button
   			$(this).addClass('disabled').text('Saving note ...');
   			
   			//save button for later
   			_recordModal_savenote = $(this);
   		
   			theID = $(this).attr('id');
   			
   			temp = theID.split("_");
   			
   			noteID = temp[1];
   			
   			$.ajax({
   				type: "POST",
   				dataType: "json",
   				data: {note: $(this).closest('.alert').find('.noteContent').redactor('get'), _token: _TOKEN},
   			  	url: _BASE_URL+"/recordnotes/updateNote/"+_theDB+"/"+_theTable+"/"+_tablePrimaryKey+"/"+_rowIndex+"/"+noteID
   			}).done(function(response){
   			
   				//re-enable button
   				_recordModal_savenote.removeClass('disabled').text('Save note');
   			
   				if(response.response_code == 2) {
   				
   					$('#recordModal_tab3 > .alert-error').each(function(){ $(this).remove() })
   						
   					$('#recordModal_tab3').prepend($(response.message));
   					
   					return false;
   				
   				}
   				
   				//add notes to the view
   				
   				$('#recordNotes > *').each(function(){ $(this).remove() });
   				
   				$('#recordNotes').append($(response.notes));
   				
   				
   				//update the number notes as well
   				$('#recordModal_notesTotal').text( $('#recordNotes .alert').size() );
   				
   				
   				//display success message
   				$('#recordModal_tab3').prepend( $(response.success_message) );
   				
   				window.location.hash = '#recordModal_tab3';
   				
   				window.setTimeout(function() { $("#recordModal_tab3 .alert-success").fadeOut(1000, function(){$(this).remove()}); }, 3000);
   			
   			})
   		
   		} else {
   		
   			alert('Please make sure the note field is not empty.')
   		
   		}
   	
   	});
   	
   	
   	//cancel update record note
   	
   	$('#recordNotes').on("click", ".recordModal_canceleditnote", function(){
   	
   		//disable textarea
   		$(this).closest('.alert').find('.noteContent').redactor('destroy');
   		
   		$('#note_'+$(this).attr('rel')).redactor('destroy');
   		
   		$(this).closest('.row').hide();
   		
   		$(this).closest('.row').prev().fadeIn();
   	
   	});
   	
   	var _deleteRecordNote;
   	
   	//delete record note
   	$('#recordNotes').on("click", ".deleteRecordNote", function(){
   	
   		if( confirm("Deleting this note can not be un-done. Are you sure you want to continue?") ) {
   		
   			//disable button
   			$(this).addClass('disabled').text('Deleting ...');
   			
   			//save button for later
   			_deleteRecordNote = $(this);
   		
   			theID = $(this).attr('id');
   			
   			temp = theID.split("_");
   			
   			noteID = temp[1];
   			
   			$.ajax({
   				type: "POST",
   				dataType: "json",
   				data: {_token: _TOKEN},
   			  	url: _BASE_URL+"/recordNotes/deleteNote/"+_theDB+"/"+_theTable+"/"+_tablePrimaryKey+"/"+_rowIndex+"/"+noteID
   			}).done(function(response){
   			
   				//re-enable button
   				_deleteRecordNote.removeClass('disabled').text('Delete');
   		
   				if(response.response_code == 2) {
   				
   					alert(response.errro);
   					
   					return false;
   				
   				}
   				
   				//update the view
   				$('#recordNotes > *').each(function(){ $(this).remove() });
   				
   				$('#recordNotes').append($(response.notes));
   				
   				
   				//update the number notes as well
   				$('#recordModal_notesTotal').text( $('#recordNotes .alert').size() );
   					
   				
   				//display success message
   				$('#recordModal_tab3').prepend( $(response.success_message) );
   				
   				window.location.hash = '#recordModal_tab3';
   				
   				window.setTimeout(function() { $("#recordModal_tab3 .alert-success").fadeOut(1000, function(){$(this).remove()}); }, 3000);
   			
   			})
   			
   		}
   			
   		return false;
   	
   	})
   	
   	
   	//record modal event
   	$('#recordModal').on('show.bs.modal', function (e) {
   		
   		//show first tab when modal opens
   		$(this).find('.nav-tabs a:first').tab('show');
   		
   		$('#recordModal .modal-footer > *:not(#recordModal_close)').hide();
   		
   		//first tab's open, show the correct button
   		$('#recordModal .modal-footer > label, #recordModal .modal-footer #recordModal_save').show();
   		
   		
   		
   	});
   	
   	//record modal tab events
   	$('#recordModal .nav-tabs a').on('show.bs.tab', function (e) {
   	
   		//default hide all except close button
   		$('#recordModal .modal-footer > *:not(#recordModal_close)').hide();
   	
   		if($(e.target).parent().index() == 0) {
   		
   			$('#recordModal .modal-footer > label, #recordModal .modal-footer #recordModal_save').show();
   		
   		}
   		
   		if($(e.target).parent().index() == 2) {
   		
   			$('#recordModal .modal-footer #recordModal_addnote').show();
   		
   		}
   		
   	});
   	
   	
 }(window.jQuery, window, document));
 // The global jQuery object is passed as a parameter