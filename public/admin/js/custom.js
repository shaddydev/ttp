    // AJAX call for autocomplete 
$(document).ready(function(){
	$("#search-box").keyup(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
		$.ajax({
		type: "POST",
		url: APP_URL+"/admin/agent/suggest",
		data:'keyword='+$(this).val(),
		beforeSend: function(){
			$("#search-box").css("background","#FFF url(public_url(admin/img/LoaderIcon.gif)) no-repeat 165px");
		},
		success: function(data){
			$("#suggesstion-box").show();
			$("#suggesstion-box").html(data);
			$("#search-box").css("background","#FFF");
		}
		});
	});
	// fecth paid amount detail by agent and distributor by transation by on wallet transaction page
	$('.transdetail').click(function(){
			var transaction = $(this).data('ref');
			if(transaction != '')
			{
				$.ajax({
							type:"GET",
							url : APP_URL+"/admin/made-payment-detail/"+transaction,
							context:this,
							
							success: function(data){
								
								var parsedata = JSON.parse(data);
								//console.log(parsedata.paymentuser.user_details.agentname);
								var response = '<div class="row">';
								response +='<div class="col-md-4">Agent</div>';
								response +='<div class="col-md-7">';
								response += '<h5 class="modal-title">'+parsedata.paymentuser.user_details.agentname+'</h5>';
								response += '</div>';
								response += '</div>';
								response += '<div class="row">';
								response +='<div class="col-md-4">Amount</div>';
								response +='<div class="col-md-7">';
								response += '<h5 class="modal-title">'+parsedata.amount+'</h5>';
								response += '</div>';
								response += '</div>';
								response += '<div class="row">';
								response += '<div class="col-md-4">payment Mode</div>';
								response += '<div class="col-md-7">';
								response += '<h5 class="modal-title">'+parsedata.payment_mode+'</h5>';
								response += '</div>';
								response += '</div>';
								response += '<div class="row">';
								response += '<div class="col-md-4">Transaction ID</div>';
								response += '<div class="col-md-7">';
								response += '<h5 class="modal-title">'+parsedata.transaction_id+'</h5>';
								response += '</div>';
								response += '</div>';
								response += '<div class="row">';
								response += '<div class="col-md-4">Transaction Date</div>';
								response += '<div class="col-md-7">';
								response +=  '<h5 class="modal-title">'+parsedata.transaction_date+'</h5>';
								response += '</div>';
								response += '</div>';
								response += '<div class="row">';
								response += '<div class="col-md-4">Remark</div>';
								response += '<div class="col-md-7">';
								response += '<h5 class="modal-title">'+parsedata.remarks+'</h5>';
								response += '</div>';
								response += '</div>';
								$('#responsedata').html(response);
								$('#detailModal').show();
								$('#dismiss').click(function(){
								$('#detailModal').hide();
								})
							}
				})
			}
	});
});
//To select country name

$(document).on("click",".agent",function() {
   var val = $(this).text();
   $("#search-box").val(val);
   $("#suggesstion-box").hide();
});
function selectCountry(val) {
$("#search-box").val(val);
$("#suggesstion-box").hide();
}

