<!DOCTYPE html>
<html>
<head>
    <title>NS Vertrektijden Leiden Centraal</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
   
    <script src="./apikey.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </head>

<body id="background" class="bg-dark">

	<div id="loading" class="text-center bg-white h2">
		<span class="spinner-border"></span>
		De trein met vertrektijden is iets vertraagd...
	</div>

	<div id="container" class="container h2" style="display:none; min-width:90%; max-height:80%;" >

		<div class="row bg-white rcorner">
			<div class="col-1"><img src="ns_logo.png" alt="NS Logo" height="24" style="padding:5px"></img></div>
			<div class="col-sm-2">Vertrektijden</div>
			<div class="col-sm-9">Leiden Centraal</div>
		</div>
		<div class="row bg-darkblue rcorner" style="display:none">
			<div class="col-2 h5 text-white ">Tijd</div>
			<div class="col-10 h5 text-white ">Plan uw reis</div>
		</div>
		<div class="row">&nbsp;</div>
		<div class="row">   
			<div class="col-sm-3">
				<div class="row bg-darkblue rcorner">
					<div class="col-4"><i class="far fa-clock text-white"></i></div>				
					<div class="col-8"><div id="clock" class="text-white"></div></div>
				</div>
				<div class="row">&nbsp;</div>
				<div class="row rcorner-b bg-nsyellow ">
					<div class="col-3 "><i class="fas fa-exclamation-triangle"></i></div>
					<div class="col-9 ">
						<div id="title_delays" class="small">NS Wijzigingen en storingen</div>
					</div>
				</div>
				<div class="row rcorner-t bg-white">
					<div class="col-12 " style="min-height:300px">
						<div id="delays" class=""></div>
					</div>
				</div>			
			</div>
			<div class="col-sm-8 offset-sm-1">
				<div class="row ">
					<div class="col-12 ">
						<div id="table"  class="table rcorner" >
							<table id="departures" class="table table-striped table-light" >
								<thead class="bg-nsyellow Otext-black">
								<tr>
									<th>Vertrek (vertraging)</th>
									<th>Bestemming</th>
									<th>Spoor</th>
									<th>Type</th>
									<th>Ga lopen om</th>
								</tr>
								</thead>
								<tbody id="dept_body" class="">
								<tr id="0">
									<td id="0-time" class="dept-time"></td>
									<td id="0-dest" class="dept-dest"></td>
									<td id="0-track" class="dept-track"></td>
									<td id="0-extra" class="dept-extra"></td>
									<td id="0-walk" class="dept-walk"></td>
								</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    <div class="">
		<canvas id="buienradar" width="453" height="120">
		
		</canvas>
	</div>
	<div class="row footer">
		<div class="col-12 bg-white">
			<div class="feed text-black" id="feed"></div>
		</div>
	</div>


</body>
	<script src="./functions.js"></script>
</html>
