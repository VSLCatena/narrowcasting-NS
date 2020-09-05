<!DOCTYPE html>
<html>
<head>
    <title>NS Vertrektijden Leiden Centraal</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
</head>
<body>
	<!-- Begin loading screen -->
	<div id="loading" class="text-center bg-color dynamic-color">
		<span class="spinner-border"></span>
		De trein met vertrektijden is iets vertraagd...
	</div>
	<!-- End loading screen -->
	<div class="container">
		<!-- Begin header -->
		<div class="row pt-2">
			<div class="col-12 bg-color dynamic-color rounded-top py-2">
				<img src="NS_logo.png" alt="NS Logo" height="35"></img>
				<span class="ml-5 h4">Vertrektijden vanaf Leiden Centraal</span>
			</div>
			<!-- Begin clock -->
			<div class="col-12 clock-holder bg-darkblue rounded-bottom h3 p-1 pl-3">
				<i class="far fa-clock text-white"></i>			
				<span id="clock" class="text-white"></span>
			</div>
			<!-- End clock -->
		</div>
		<!-- End header -->
		<div class="row mt-2">
			<!-- Begin storingen -->
			<div id="delays-holder" class="col-3 mr-3">
				<div class="row">
					<div class="col-12 bg-nsyellow rounded-top text-center h5 p-2 mb-0">
						<i class="fas fa-exclamation-triangle mr-1"></i>
						NS Wijzigingen en storingen
					</div>
					<div id="delays" class="col-12 bg-color dynamic-color rounded-bottom"></div>
				</div>
			</div>
			<!-- End storingen -->
			<!-- Begin departure times -->
			<div class="col px-0">
				<table id="departures" class="table table-striped table-light">
					<thead class="bg-nsyellow text-dark h4">
						<tr>
							<th>Vertrek</th>
							<th>Bestemming</th>
							<th>Spoor</th>
							<th>Type</th>
							<th>Lopen</th>
						</tr>
					</thead>
					<tbody class="h5" id="dept_body">
						<tr><td colspan="5"></td></tr>
					</tbody>
				</table>
			</div>
			<!-- End departure times -->
		</div>
		<!-- Begin buienradar -->
		<div class="row mt-2">
			<div class="col bg-color rounded pt-3">
				<svg id="buienradar"></svg>
			</div>
		</div>
		<!-- End buienradar -->
		<!-- Begin newsfeed -->
		<footer class="row mt-2">
			<div class="col bg-color rounded dynamic-color" id="feedbase">
				<div id="feed"></div>
			</div>
		</footer>
		<!-- End newsfeed -->
	</div>

	<script src="./apikey.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="./functions.js"></script>
	<script src="./buienradar.js"></script>
</body>
</html>
