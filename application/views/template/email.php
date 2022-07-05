<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<style type="text/css">
		table {
			width: 100%;
		}
		table.bordered, table.bordered th, table.bordered td {
		  border: 1px solid grey;
		  padding: 5px 10px;
		}
		table {
			border-collapse: collapse;
		}

		table.dotted, table.dotted th, table.dotted td {
			border: 1px dotted grey;
			padding: 5px 10px;
		}

		.text-right {
			text-align: right;
		}
		.text-center {
			text-align: center;
		}

		.section {
			margin-bottom: 20px;
		}

		.bg-lightgray {
			background-color: #eee;
		}
	</style>
</head>
<body>
	<div class="section">
		<h1>Committee Meetings</h1>
		<table class="bordered">
			<thead class="bg-lightgray">
				<tr>
					<td class="text-center">Committee Meeging</td>
					<td class="text-center">Date</td>
					<td class="text-center">Hours</td>
					<td class="text-center">Miles</td>
					<td class="text-center">HoursPay</td>
					<td class="text-center">MileagePay</td>
					<td class="text-center">TotalPay</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>County Board</td>
					<td class="text-center">01/26/2022</td>
					<td class="text-right">12</td>
					<td class="text-right">12</td>
					<td class="text-right">110</td>
					<td class="text-right">6.3</td>
					<td class="text-right">116.3</td>
				</tr>
			</tbody>
			<tfoot class="bg-lightgray">
				<tr>
					<td colspan="6">Totals</td>
					<td class="text-right">116.3</td>
				</tr>
			</tfoot>
		</table>
	</div>
	<div class="section">
		<h1>Events</h1>
		<table class="bordered">
			<thead class="bg-lightgray">
				<tr>
					<td class="text-center">Event</td>
					<td class="text-center">Date</td>
					<td class="text-center">Breakfast</td>
					<td class="text-center">Lunch</td>
					<td class="text-center">Dinner</td>
					<td class="text-center">Other Amount</td>
					<td class="text-center">TotalPay</td>
				</tr>
			</thead>
			<tbody>


				
				<tr>
					<td>Event1</td>
					<td class="text-center">01/26/2022</td>
					<td class="text-center">Y</td>
					<td class="text-center">Y</td>
					<td class="text-center"></td>
					<td class="text-right">6.3</td>
					<td class="text-right">116.3</td>
				</tr>
			</tbody>
			<tfoot class="bg-lightgray">
				<tr>
					<td colspan="6">Totals</td>
					<td class="text-right">116.3</td>
				</tr>
			</tfoot>
		</table>
	</div>

	<hr>
	<div class="section">
		<table class="dotted">
			<tbody>
				<tr class="bg-lightgray">
					<td>Pay Period Total</td>
					<td>116.3</td>
				</tr>
				<tr>
					<td>Note</td>
					<td>This is a correction of a previously submitted formThis is a correction of a previously submitted formThis is a correction of a previously submitted formThis is a correction of a previously submitted form</td>
				</tr>
				<tr>
					<td>This is a correction of a previously submitted form</td>
					<td>Yes</td>
				</tr>
				<tr>
					<td>Initials</td>
					<td>ddf</td>
				</tr>
				<tr>
					<td>Date</td>
					<td>01/26/2022</td>
				</tr>
				<tr class="bg-lightgray">
					<td>Supervisor</td>
					<td>Al Adam</td>
				</tr>
			</tbody>
		</table>
	</div>

</body>
</html>