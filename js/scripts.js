/*!
    * Start Bootstrap - SB Admin v6.0.0 (https://startbootstrap.com/templates/sb-admin)
    * Copyright 2013-2020 Start Bootstrap
    * Licensed under MIT (https://github.com/BlackrockDigital/startbootstrap-sb-admin/blob/master/LICENSE)
    */
(function($) {
    "use strict";

		// Add active state to sidbar nav links
		var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
			
		$("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function() {
			var current_path = window.location.pathname.split('/').pop();
			current_path = current_path.split('.').shift();
			
			var link_path = this.href.split('/').pop();
			link_path = link_path.split('.').shift();
			
			if (link_path === current_path.substring(0, link_path.length) && $(this).attr('href') != '#') {				
				$(this).addClass("active");
			}
		});

		// Toggle the side navigation
		$("#sidebarToggle").on("click", function(e) {
			e.preventDefault();
			$("body").toggleClass("sb-sidenav-toggled");
		});
})(jQuery);

function populateModal(type, id, file, message, item){
	var modalHTML = '<div class="modal fade" id="confirm-'+type+'-'+id+'" role="dialog">';
	modalHTML += '<div class="modal-dialog modal-dialog-centered">';
	modalHTML += '<form action="'+file+'" method="POST">';
	modalHTML += '<div class="modal-content">';
	modalHTML += '<div class="modal-header">';
	modalHTML += '<h4 class="modal-title">Confirm</h4>';
	modalHTML += '<button type="button" class="close" data-dismiss="modal">&times;</button>';
	modalHTML += '</div>';
	modalHTML += '<div class="modal-body">';
	if(type == 'approve'){
		modalHTML += '<input type="hidden" name="approve_id" id="approve_id" value="'+id+'">';
		modalHTML += '<input type="hidden" name="update_approve" id="update_approve" value="2">';
	}else if(type == 'reject'){
		modalHTML += '<input type="hidden" name="reject_id" id="reject_id" value="'+id+'">';
		modalHTML += '<input type="hidden" name="update_reject" id="update_reject" value="1">';
	}else if(type == 'filter'){
		modalHTML += '<input type="hidden" name="score_id" id="score_id" value="'+id+'">';
	}else{
		modalHTML += '<input type="hidden" name="del_id" id="del_id" value="'+id+'">';
	}
	modalHTML += '<p>'+message+'</p>';
	modalHTML += '<p class="text-center"><strong>'+item+'</strong></p>';
	modalHTML += '</div>';
	modalHTML += '<div class="modal-footer">';
	modalHTML += '<button type="submit" class="btn btn-primary pull-left">Confirm</button>';
	modalHTML += '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>';
	modalHTML += '</div>';
	modalHTML += '</div>';
	modalHTML += '</form>';
	modalHTML += '</div>';
	modalHTML += '</div>';

	return modalHTML;
}

function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function millisecondsToTime(milli) {
	var milliseconds = milli % 1000;
	var seconds = Math.floor((milli / 1000) % 60);
	var minutes = Math.floor((milli / (60 * 1000)) % 60);
	
	if(seconds<10){
		seconds = '0'+seconds;  
	}
	
	if(minutes<10){
		minutes = '0'+minutes;  
	}

	if(milliseconds > 0){
		milliseconds = '.'+milliseconds;
	}else{
		milliseconds = '';
	}
	
	return minutes+':'+seconds+milliseconds;
}