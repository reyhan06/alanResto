<!DOCTYPE html>
<html>
<head>
	<title>Cart</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<center>
		<h5>Cetak Cart</h4>
	</center>

	<table class='table table-bordered'>
		<thead>
			<tr>
                <th>#</th>
				<th>Gambar</th>
				<th>Nama</th>
				<th>Qty</th>
				<th>Harga</th>
			</tr>
		</thead>
		<tbody>
			@foreach(json_decode($cart) as $c)
			<tr>
				<td>{{$c[0]}}</td>
				<td><img src="{{ asset('storage/'.$c[2]) }}" width='80px' height='80px' style='object-fit: cover;'> </td>
                <td>{{$c[3]}}</td>
				<td>{{$c[1]}}</td>
				<td>{{$c[4]}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>

</body>
</html>
