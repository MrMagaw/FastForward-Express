@extends ('layouts.tables')

@section ('variables')

<?php
	$columns = ['ID', 'Parent ID', 'Name', 'Address','Contact'];
	$variables = ['account_id', 'id', 'name', 'address','contact_name'];
	$contents = (new \app\Http\Controllers\AccountController)->getData(['start_date'=>'2013-01-01 00:00:00']);
	if ($contents['success']){
		$contents = $contents['data'];
	}
?>

@endsection

@section ('script')

<script type='text/javascript'>

	function childRow(details) {
		var data = JSON.parse(details);

		var thisCust = 'editCust' + data.number;

		return "<table style='width:80%;'>" +
					"<tr>" +
						"<td>" +
							"<button class='edit-button' onclick=" + "edit('." + thisCust + "')" + "><i class='fa fa-edit'></i></button>" +
							"<button class='delete-button'><a href=''><i class='fa fa-trash'></i></a></button>" +
							"<button class='save-button hidden " + thisCust + "'><a href=''><i class='fa fa-save'></i></a></button>" +
						"</td>" +
					"</tr>" +
					"<tr>" +
						"<td>" + "<label>Customer #  " + data.id + "</label>" + "</td>" +
						"<td>" + "<label>Full Name<br>" + "<input class'=" + thisCust + "' readonly value=" + data.company_name + " />" + "</td>" +
						"<td></td>" +
						"<td></td>" +
					"</tr>" +
					"<tr>" +
						"<td colspan='100%'>" + "<label>Address:  </label>" + "<input style='width:100%' class='" + thisCust + "' readonly value=" + data.address + " />" + "</td>" +
					"</tr>" +
					"<tr>" +
						"<td>" + "<label>Primary Contact</label>" + "</td>" +
						"<td>" + "<label>Name: " + "<br>" + "<input class='" + thisCust + "' readonly value=" + data.contact_name + " />" + "</td>" +
						"<td>" + "<label>Phone: " + "<br>" + "<input class='" + thisCust + "' readonly value=" + data.phone_nums + " />" + "</td>" +
						"<td>" + "<label>Email: " + "<br>" + "<input class='" + thisCust + "' readonly value=" + data.email + " />" + "</td>" +
 					"</tr>" +
					"<tr>" +
						"<td>" + "<label>Rate Type</label>" + "<br>" + "<select class='" + thisCust + "' readonly value=" + data.rate_type_id + " />" + "</td>" +
						"<td>" + "<label>Invoice Interval</label>" +"<br>" + "<select class='" + thisCust +"' readonly value=" + data.invoice_interval_id + "/>" + "</td>" +
						"<td></td>" +
						"<td></td>" +
					"</tr>" +
				"</table>"
	}

</script>

@parent

@endsection

@section ('navBar')
<ul class='nav nav-pills nav-stacked'>
	<li class="navButton"><a href="">New Customer</a></li>
	<li class="navButton"><a href="">Edit Customer</a></li>
</ul>
@endsection
