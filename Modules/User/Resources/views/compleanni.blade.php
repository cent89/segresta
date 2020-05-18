<?php
use Carbon\Carbon;
use Modules\User\Entities\User;
?>

<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Encode+Sans+Condensed:400,800" rel="stylesheet" type="text/css">
	<style>
	html, body, p, h1, h2, h3, td, th{
		font-family: 'Encode Sans Condensed' !important;
		font-weight: 400;
	}
	
	table, th, td {
		border: 1px solid black;
		padding: 5px;
	}

	table {
		border-collapse: collapse;
		width: 100%;
	}

	th{
		background-color: silver;
	}
	</style>
</head>
<body>
	<div style='text-align: center; width: 100%;'>
		<img src="{{ asset('assets/logo_new_orizzontale_b.png') }}" style="height: 100px">
	</div>
	<div style='text-align: center;'>
		<h2>Elenco compleanni di oggi, {{ Carbon::now()->format('d/m/Y') }}</h2>
	</div>

	<div style='text-align: left;'>
		<table>
			<tr>
				<th>Utente</th>
				<th>Cellulare</th>
				<th>Email</th>
			</tr>
			@foreach(User::where('nato_il', Carbon::now()->format('Y-m-d'))->get() as $user)
			<tr>
				<td>{{ $user->full_name }}</td>
				<td>{{ $user->cell_number }}</td>
				<td>{{ $user->email }}</td>
			</tr>
			@endforeach
		</table>
	</div>
</body>
</html>
