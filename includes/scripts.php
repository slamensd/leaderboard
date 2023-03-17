<?php if(basename($_SERVER['PHP_SELF']) == 'scoreboard_edit.php' || basename($_SERVER['PHP_SELF']) == 'scoreboard_add.php') { ?>
<script type="text/javascript">
$(document).ready(function(){
   $("#scoreboard_form").validate({
       rules: {
            name: {
                required: true,
                minlength: 3
            },
            email: {
                required: true,
                minlength: 3
            },
            score: {
				required: true,
                number: true
            },
        }
    });
});
</script>
<?php } ?>

<?php if(basename($_SERVER['PHP_SELF']) == 'filter_users_edit.php' || basename($_SERVER['PHP_SELF']) == 'filter_users_add.php') { ?>
<script type="text/javascript">
$(document).ready(function(){
   $("#filter_users_form").validate({
       rules: {
            email: {
                required: true,
                minlength: 3
            }
        }
    });
});
</script>
<?php } ?>

<?php if(basename($_SERVER['PHP_SELF']) == 'filter_scores_edit.php' || basename($_SERVER['PHP_SELF']) == 'filter_scores_add.php') { ?>
<script type="text/javascript">
$(document).ready(function(){
   $("#filter_scores_form").validate({
       rules: {
        score_min: {
                required: true,
                number: true
            },
            score_max: {
				required: true,
                number: true
            },
        }
    });
});
</script>
<?php } ?>

<?php if(basename($_SERVER['PHP_SELF']) == 'admin_users_add.php') { ?>
<script type="text/javascript">
$(document).ready(function(){
   $("#admin_users_form").validate({
	   errorClass:'input-group error',
       rules: {
            user_name: {
                required: true,
                minlength: 3
            },
            passwd: {
                required: true,
                minlength: 3
            }  
        }
    });
});
</script>
<?php } ?>

<?php if(basename($_SERVER['PHP_SELF']) == 'admin_users_edit.php') { ?>
<script type="text/javascript">
$(document).ready(function(){
   $("#admin_users_form").validate({
	    errorClass:'input-group error',
       rules: {
            user_name: {
                required: true,
                minlength: 3
            } 
        }
    });
});
</script>
<?php } ?>

<?php if(basename($_SERVER['PHP_SELF']) == 'scoreboard.php') { ?>
<script type = "text/javascript" >
    $(document).ready(function() {
        $('#dpTable').on('change', function() {
            if(this.value != ''){
                $.ajax({
                    type: "POST",
                    url: 'table_session.php',
                    data: 'tableIndex='+this.value,
                    success: function (data) {
                        var uri = window.location.href.toString();
                        if (uri.indexOf("?") > 0) {
                            var clean_uri = uri.substring(0, uri.indexOf("?"));
                            window.history.replaceState({}, document.title, clean_uri);
                        }
                        location.reload();
                    }
                });
            }
        });

        $('#dataTable').dataTable({
			"order": [[ 5, "desc" ]],
            "bProcessing": true,
            "serverSide": true,
            "ajax": {
                url: "scoreboard_response.php",
                type: "POST",
                error: function() {
                    $("#post_list_processing").css("display", "none");
                }
            },
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "Show all"]
            ],
            "dom": 'Blfrtip',
            "buttons": [{
                    "extend": 'csv',
                    "text": 'CSV',
                    "className": 'btn btn-secondary btn-sm',
                    exportOptions: {
                        columns: ':not(.notexport)'
                    }
                },
                {
                    "extend": 'excel',
                    "text": 'EXCEL',
                    "className": 'btn btn-secondary btn-sm',
                    exportOptions: {
                        columns: ':not(.notexport)'
                    }
                },
                {
                    "extend": 'pdf',
                    "text": 'PDF',
                    "className": 'btn btn-secondary btn-sm',
                    exportOptions: {
                        columns: ':not(.notexport)'
                    }
                },
                {
                    "extend": 'print',
                    "text": 'PRINT',
                    "className": 'btn btn-secondary btn-sm',
                    exportOptions: {
                        columns: ':not(.notexport)'
                    }
                }
            ],
            columns: [{ data: null, sortable:false, render: function ( data, type, row ) {
					return '<input type="checkbox" id="score-'+data.id+'" name="score-'+data.id+'" class="checkbox" value="'+data.id+'">';
				} },
                {
                    data: "id"
                },
                {
                    data: "name"
                },
                {
                    data: "email"
                },
				{
                    data: "type"
                },
				{
                    data: null,
                    render: function(data, type, row) {
                        <?php if($table_scoreboards[$_SESSION['table_index']]['score'] == 'point'){ ?>
                            return addCommas(data.score);
                        <?php }else{ ?>
                            return millisecondsToTime(data.score);
                        <?php } ?>
                    }
                },
                {
                    data: null,
                    sortable:false,
                    render: function(data, type, row) {
                        var goodSpanHTML = '<h5 style="display:inline;"><span class="badge badge-success"><?php echo $lang['option-valid']; ?></span></h5>';
                        var userSpanHTML = '';
                        var scoreSpanHTML = '';
                        
                        if(data.filter_user != ''){
                            goodSpanHTML = '';
                            userSpanHTML = '<h5 style="display:inline;"><span class="badge badge-danger"><?php echo $lang['option-spam']; ?></span></h5> ';
                        }

                        if(data.filter_score != ''){
                            goodSpanHTML = '';
                            <?php if($table_scoreboards[$_SESSION['table_index']]['score'] == 'point'){ ?>
                                scoreSpanHTML = '<h5 style="display:inline;"><span class="badge badge-danger">Range ('+addCommas(data.filter_score_min)+' - '+addCommas(data.filter_score_max)+')</span></h5>';
                            <?php }else{ ?>
                                scoreSpanHTML = '<h5 style="display:inline;"><span class="badge badge-danger">Range ('+millisecondsToTime(data.filter_score_min)+' - '+millisecondsToTime(data.filter_score_max)+')</span></h5>';
                            <?php } ?>
                        }

                        return goodSpanHTML+userSpanHTML+scoreSpanHTML;
                    }
                },
                {
                    data: "date"
                }, <?php if ($_SESSION['admin_type'] == 'super') { ?>
					  {
                        data: null,
                        sortable: false,
                        render: function(data, type, row) {
                            var editButtonHTML = '<a class="btn btn-primary btn-sm" href="scoreboard_edit.php?score_id=' + data.id + '&operation=edit"><span class="fa fa-edit fa-fw"></span> <?php echo $lang['button-edit']; ?></a> ';
                            var removeButtonHTML = '<a class="btn btn-danger btn-sm" href="" data-toggle="modal" data-target="#confirm-delete-' + data.id + '"><span class="fa fa-trash-alt fa-fw"></span> <?php echo $lang['button-remove']; ?></a>';
                            var removePopHTML = populateModal('delete', data.id, 'scoreboard_delete.php', '<?php echo $lang['modal-delete-score']; ?>', data.email);
                            var filterButtonHTML = ' <a class="btn btn-danger btn-sm" href="" data-toggle="modal" data-target="#confirm-filter-' + data.id + '"><span class="fa fa-filter fa-fw"></span> <?php echo $lang['button-spam']; ?></a>';
                            var filterPopHTML = populateModal('filter', data.id, 'scoreboard_filter.php', '<?php echo $lang['modal-add-filter-user']; ?>', data.email);

                            return editButtonHTML + removeButtonHTML + removePopHTML + filterButtonHTML + filterPopHTML;
                        }
                    }<?php } ?>
            ],
		   initComplete: function () {			   
			    this.api().columns([5]).every( function () {
					var column = this;
					var select = $('<select class="form-control form-control-sm" style="width:150px;"><option value=""><?php echo $lang['option-all-time']; ?></option></select>')
					.appendTo( $(column.header()).empty() )
					.on( 'change', function () {
						var val = $.fn.dataTable.util.escapeRegex(
							$(this).val()
						);
						column.search( val ? val : '', true, false ).draw();
					});

					select.append( '<option value="daily"><?php echo $lang['option-daily']; ?></option>' )
					select.append( '<option value="weekly"><?php echo $lang['option-weekly']; ?></option>' )
					select.append( '<option value="monthly"><?php echo $lang['option-monthly']; ?></option>' )
				});
            }
        });

        $('#check_all_top, #check_all_bottom').click(function () {
            if ($(this).is(":checked")){
				$( ".checkbox" ).prop( "checked", true);
			}else{
				$( ".checkbox" ).prop( "checked", false);
			}
        });
		
		$('#update-status').on('show.bs.modal', function (event) {
			var searchIDs = [];
			$('input[class="checkbox"]:checked').each(function() {
			   searchIDs.push(this.value); 
			});
			
			$('#update-status-confirm').hide();
			$('#update-status-error').hide();
			
			$('#batch_id').val(searchIDs);
			$('#update_status').val($('#update_order').val());
			if(searchIDs.length > 0){
				$('#update-status-confirm').show();
			}else{
				$('#update-status-error').show();	
			}
		});
    });
</script>
<?php } ?>

<?php if(basename($_SERVER['PHP_SELF']) == 'filter_users.php') { ?>
<script type = "text/javascript" >
    $(document).ready(function() {
        $('#dataTable').dataTable({
			"order": [[ 1, "desc" ]],
            "bProcessing": true,
            "serverSide": true,
            "ajax": {
                url: "filter_users_response.php",
                type: "POST",
                error: function() {
                    $("#post_list_processing").css("display", "none");
                }
            },
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "Show all"]
            ],
            "dom": 'Blfrtip',
            "buttons": [{
                    "extend": 'csv',
                    "text": 'CSV',
                    "className": 'btn btn-secondary btn-sm',
                    exportOptions: {
                        columns: ':not(.notexport)'
                    }
                },
                {
                    "extend": 'excel',
                    "text": 'EXCEL',
                    "className": 'btn btn-secondary btn-sm',
                    exportOptions: {
                        columns: ':not(.notexport)'
                    }
                },
                {
                    "extend": 'pdf',
                    "text": 'PDF',
                    "className": 'btn btn-secondary btn-sm',
                    exportOptions: {
                        columns: ':not(.notexport)'
                    }
                },
                {
                    "extend": 'print',
                    "text": 'PRINT',
                    "className": 'btn btn-secondary btn-sm',
                    exportOptions: {
                        columns: ':not(.notexport)'
                    }
                }
            ],
            columns: [{ data: null, sortable:false, render: function ( data, type, row ) {
					return '<input type="checkbox" id="user-'+data.id+'" name="user-'+data.id+'" class="checkbox" value="'+data.id+'">';
				} },
                {
                    data: "id"
                },
                {
                    data: "game"
                },
                {
                    data: "type"
                },
                {
                    data: "email"
                },
				{
                    data: null,
                    render: function(data, type, row) {
                        return data.status == 1 ? 'Active' : 'In-active';
                    }
                },
				{
                    data: "date"
                }, <?php if ($_SESSION['admin_type'] == 'super') { ?>
					  {
                        data: null,
                        sortable: false,
                        render: function(data, type, row) {
                            var editButtonHTML = '<a class="btn btn-primary btn-sm" href="filter_users_edit.php?user_id=' + data.id + '&operation=edit"><span class="fa fa-edit fa-fw"></span> <?php echo $lang['button-edit']; ?></a> ';
                            var removeButtonHTML = '<a class="btn btn-danger btn-sm" href="" data-toggle="modal" data-target="#confirm-delete-' + data.id + '"><span class="fa fa-trash-alt fa-fw"></span> <?php echo $lang['button-remove']; ?></a>';
                            var removePopHTML = populateModal('delete', data.id, 'filter_users_delete.php', '<?php echo $lang['modal-delete-filter']; ?>', data.email);

                            return editButtonHTML + removeButtonHTML + removePopHTML;
                        }
                    }<?php } ?>
            ]
        });

        $('#check_all_top, #check_all_bottom').click(function () {
            if ($(this).is(":checked")){
				$( ".checkbox" ).prop( "checked", true);
			}else{
				$( ".checkbox" ).prop( "checked", false);
			}
        });

        $('#update-status').on('show.bs.modal', function (event) {
			var searchIDs = [];
			$('input[class="checkbox"]:checked').each(function() {
			   searchIDs.push(this.value); 
			});
			
			$('#update-status-confirm').hide();
			$('#update-status-error').hide();
			
			$('#batch_id').val(searchIDs);
			$('#update_status').val($('#update_order').val());
			if(searchIDs.length > 0){
				$('#update-status-confirm').show();
			}else{
				$('#update-status-error').show();	
			}
		});
    });
</script>
<?php } ?>

<?php if(basename($_SERVER['PHP_SELF']) == 'filter_scores.php') { ?>
<script type = "text/javascript" >
    $(document).ready(function() {
        $('#dataTable').dataTable({
			"order": [[ 1, "desc" ]],
            "bProcessing": true,
            "serverSide": true,
            "ajax": {
                url: "filter_scores_response.php",
                type: "POST",
                error: function() {
                    $("#post_list_processing").css("display", "none");
                }
            },
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "Show all"]
            ],
            "dom": 'Blfrtip',
            "buttons": [{
                    "extend": 'csv',
                    "text": 'CSV',
                    "className": 'btn btn-secondary btn-sm',
                    exportOptions: {
                        columns: ':not(.notexport)'
                    }
                },
                {
                    "extend": 'excel',
                    "text": 'EXCEL',
                    "className": 'btn btn-secondary btn-sm',
                    exportOptions: {
                        columns: ':not(.notexport)'
                    }
                },
                {
                    "extend": 'pdf',
                    "text": 'PDF',
                    "className": 'btn btn-secondary btn-sm',
                    exportOptions: {
                        columns: ':not(.notexport)'
                    }
                },
                {
                    "extend": 'print',
                    "text": 'PRINT',
                    "className": 'btn btn-secondary btn-sm',
                    exportOptions: {
                        columns: ':not(.notexport)'
                    }
                }
            ],
            columns: [{ data: null, sortable:false, render: function ( data, type, row ) {
					return '<input type="checkbox" id="user-'+data.id+'" name="user-'+data.id+'" class="checkbox" value="'+data.id+'">';
				} },
                {
                    data: "id"
                },
                {
                    data: "game"
                },
                {
                    data: "type"
                },
                {
                    data: "score_min"
                },
                {
                    data: "score_max"
                },
				{
                    data: null,
                    render: function(data, type, row) {
                        return data.status == 1 ? 'Active' : 'In-active';
                    }
                },
				{
                    data: "date"
                }, <?php if ($_SESSION['admin_type'] == 'super') { ?>
					  {
                        data: null,
                        sortable: false,
                        render: function(data, type, row) {
                            var editButtonHTML = '<a class="btn btn-primary btn-sm" href="filter_scores_edit.php?score_id=' + data.id + '&operation=edit"><span class="fa fa-edit fa-fw"></span> <?php echo $lang['button-edit']; ?></a> ';
                            var removeButtonHTML = '<a class="btn btn-danger btn-sm" href="" data-toggle="modal" data-target="#confirm-delete-' + data.id + '"><span class="fa fa-trash-alt fa-fw"></span> <?php echo $lang['button-remove']; ?></a>';
                            var removePopHTML = populateModal('delete', data.id, 'filter_scores_delete.php', '<?php echo $lang['modal-delete-filter']; ?>', data.email);

                            return editButtonHTML + removeButtonHTML + removePopHTML;
                        }
                    }<?php } ?>
            ]
        });

        $('#check_all_top, #check_all_bottom').click(function () {
            if ($(this).is(":checked")){
				$( ".checkbox" ).prop( "checked", true);
			}else{
				$( ".checkbox" ).prop( "checked", false);
			}
        });

        $('#update-status').on('show.bs.modal', function (event) {
			var searchIDs = [];
			$('input[class="checkbox"]:checked').each(function() {
			   searchIDs.push(this.value); 
			});
			
			$('#update-status-confirm').hide();
			$('#update-status-error').hide();
			
			$('#batch_id').val(searchIDs);
			$('#update_status').val($('#update_order').val());
			if(searchIDs.length > 0){
				$('#update-status-confirm').show();
			}else{
				$('#update-status-error').show();	
			}
		});
    });
</script>
<?php } ?>

<?php if(basename($_SERVER['PHP_SELF']) == 'admin_users.php' && $_SESSION['admin_type'] == 'super') { ?>
<script type="text/javascript">
	$(document).ready(function(){
	   $('#dataTable').dataTable({
			"bProcessing": true,
			"serverSide": true,
			"ajax":{
				url :"admin_response.php",
				type: "POST",
				error: function(){
				  $("#post_list_processing").css("display","none");
				}
			},
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "dom": 'Blfrtip',
            "buttons": [{
                    "extend": 'csv',
                    "text": 'CSV',
                    "className": 'btn btn-secondary btn-sm',
                    exportOptions: {
                        columns: ':not(.notexport)'
                    }
                },
                {
                    "extend": 'excel',
                    "text": 'EXCEL',
                    "className": 'btn btn-secondary btn-sm',
                    exportOptions: {
                        columns: ':not(.notexport)'
                    }
                },
                {
                    "extend": 'pdf',
                    "text": 'PDF',
                    "className": 'btn btn-secondary btn-sm',
                    exportOptions: {
                        columns: ':not(.notexport)'
                    }
                },
                {
                    "extend": 'print',
                    "text": 'PRINT',
                    "className": 'btn btn-secondary btn-sm',
                    exportOptions: {
                        columns: ':not(.notexport)'
                    }
                }
            ],
		   columns: [
				{ data: "id"},
				{ data: "user_name"},
				{ data: "admin_type"},
				<?php if ($_SESSION['admin_type'] == 'super'){ ?>
				{ data: null, sortable:false, render: function ( data, type, row ) {
					var editButtonHTML = '<a class="btn btn-primary btn-sm" href="admin_users_edit.php?admin_user_id='+data.id+'&operation=edit"><span class="fa fa-edit fa-fw"></span> <?php echo $lang['button-edit']; ?></a> ';
					var removeButtonHTML = '<a class="btn btn-danger btn-sm" href="" data-toggle="modal" data-target="#confirm-delete-'+data.id+'"><span class="fa fa-trash-alt fa-fw"></span> <?php echo $lang['button-remove']; ?></a>';
					var removePopHTML = populateModal('delete',data.id,'admin_users_delete.php','<?php echo $lang['modal-delete-admin']; ?>',data.user_name);

					return editButtonHTML+removeButtonHTML+removePopHTML;
				} }
			   <?php } ?>
			]
		});
	});
</script>
<?php } ?>