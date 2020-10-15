<?php
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT"); // *
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html>
<head>
    <title>NS Vertrektijden Leiden Centraal</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" href="./styles/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<link rel="stylesheet" href="./styles/style.css">
</head>
<body>
	<!-- Begin debug field -->
	<div id="debug" class="debug-field position-fixed w-100 h-100">
		<div id="debugText" class="bg-color dynamic-color"></div>
	</div>
	<!-- End debug field -->
	<!-- Begin loading screen -->
	<div id="loading" class="text-center bg-color dynamic-color">
		<span class="spinner-border"></span>
    	<span id="loadingText" style="color: #FFF;">De trein met vertrektijden is iets vertraagd...</span>
	</div>
	<!-- End loading screen -->
	<div class="container">
		<!-- Begin header -->
		<div class="row pt-2">
			<div class="col-12 bg-color dynamic-color rounded-top py-2">
				<img src="./images/NS_logo.png" alt="NS Logo" height="35"></img>
				<span class="ml-5 h4">Vertrektijden vanaf Leiden Centraal</span>
			</div>
		</div>
		<div class="row">
			<!-- Begin clock -->
			<div class="col-12 clock-holder bg-darkblue rounded-bottom h3 p-1 pl-3">
				<i class="far fa-clock text-white"></i>			
				<span id="clock" class="text-white"></span>
			</div>
			<!-- End clock -->
		</div>
		<!-- End header -->
		<div class="row d-flex flex-row">
			<!-- Begin storingen -->
			<div class="col-3 mr-3">
				<div class="row">
					<div class="col-12 bg-nsyellow rounded-top text-center text-dark h5 p-2 mb-0">
						<i class="fas fa-exclamation-triangle mr-1"></i>
						NS Wijzigingen en storingen
					</div>
				</div>
				<div class="row">
					<div id="delays" class="col-12 bg-color dynamic-color rounded-bottom"></div>
				</div>
			</div>
			<!-- End storingen -->
			<!-- Begin departure times -->
			<div class="col px-0">
				<table id="departures" class="table table-striped table-light bg-color">
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
				<img id="buienradar" class="w-100" src="" />
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
    <script src="./scripts/functions.js"></script>
	<script type="text/javascript">

		var night = !moment().isBetween(moment('6', 'H'), moment('22', 'H'));

		var imageUrl = "buienradar.php?width=1700&height=350&bottomPart=40&textSize=25&bottomPadding=30&textPadding=15";
		if (night) {
			imageUrl += "&darkMode=1";
		}

		$("#buienradar").attr('src', imageUrl);
	</script>
</body>
</html>
