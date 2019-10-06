<!DOCTYPE html>
<html>
<head>
    <title>NS Vertrektijden Leiden Centraal</title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<style type="text/css">
.li-nobullet {
	list-style: none;
}

.table td {
	padding: 0.25rem;
	
}
.fontparty {
	font-family:Comic Sans MS, cursive, sans-serif;
}

.rcorner {
  border-radius: 5px 5px 5px 5px ;
}
.rcorner-l {
  border-radius: 0px 5px 5px 0px;
}
.rcorner-r {
  border-radius: 5px 0px 0px 5px;
}
.rcorner-t {
  border-radius: 0px 0px 5px 5px;
}
.rcorner-b {
  border-radius: 5px 5px 0px 0px;
}

.background-day {
	background-image: url(background-day.jpg);
	background-size: cover;
	background-repeat:no-repeat;
}
.background-night {
	background-image: url(background-night.jpg);
	background-size: cover;
	background-repeat:no-repeat;
}  
.bg-darkblue {
	background-color: #000468!important
	
}

.bg-nsyellow {
	background-color: #f2c400!important
}
</style>
<body id="background" class="bg-dark">

<h2 id="loading" class="text-center bg-white">
	<span class="spinner-border"></span>
	De trein met vertrektijden is iets vertraagd...
</h2>

<div id="container" class="container h3" style="display:none; min-width:90%" >

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
				 <div id="table"  class="table-responsive rcorner" >
					<table id="departures" class="table table-striped table-light" >
						<thead class="bg-nsyellow">
						<tr>
							<th>Vertrek (vertraging)</th>
							<th>Bestemming</th>
							<th>Spoor</th>
							<th>Type</th>
						</tr>
						</thead>
						<tbody class="">
						<tr id="0">
							<td id="0-time" class="dept-time"></td>
							<td id="0-dest" class="dept-dest"></td>
							<td id="0-track" class="dept-track"></td>
							<td id="0-extra" class="dept-extra"></td>
						</tr>
						<tr id="1">
							<td id="1-time" class="dept-time"></td>
							<td id="1-dest" class="dept-dest"></td>
							<td id="1-track" class="dept-track"></td>
							<td id="1-extra" ></td>
						</tr>
						<tr id="2">
							<td id="2-time" class="dept-time"></td>
							<td id="2-dest" class="dept-dest"></td>
							<td id="2-track" class="dept-track"></td>
							<td id="2-extra" class="dept-extra"></td>
						</tr>
						<tr id="3">
							<td id="3-time" class="dept-time"></td>
							<td id="3-dest" class="dept-dest"></td>
							<td id="3-track" class="dept-track"></td>
							<td id="3-extra" class="dept-extra"></td>
						</tr>
						<tr id="4">
							<td id="4-time" class="dept-time"></td>
							<td id="4-dest" class="dept-dest"></td>
							<td id="4-track" class="dept-track"></td>
							<td id="4-extra" class="dept-extra"></td>
						</tr>
						<tr id="5">
							<td id="5-time" class="dept-time"></td>
							<td id="5-dest" class="dept-dest"></td>
							<td id="5-track" class="dept-track"></td>
							<td id="5-extra" class="dept-extra"></td>
						</tr>
						<tr id="6">
							<td id="6-time" class="dept-time"></td>
							<td id="6-dest" class="dept-dest"></td>
							<td id="6-track" class="dept-track"></td>
							<td id="6-extra" class="dept-extra"></td>
						</tr>
						<tr id="7">
							<td id="7-time" class="dept-time"></td>
							<td id="7-dest" class="dept-dest"></td>
							<td id="7-track" class="dept-track"></td>
							<td id="7-extra" class="dept-extra"></td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div id="buienradar">
	
	</div>
</div>

<script type="text/javascript">




dateTimeNow = moment().format(); 
var clock = document.getElementById("clock");


var format = 'HH:mm:ss'
var time = moment(moment(),format);
var early = moment('06:00:00', format);
var late = moment('22:00:00', format);

if (time.isBetween(early, late)) { night = false }
else { night = true}
console.log("Night:"+night)

//get NS-data departures
    $(function() {
        var params = {
		dateTime:dateTimeNow,
		maxJourneys:'7',
		lang:'nl',
		uicCode:'8400390'
        };
		//console.log($.param(params))
        $.ajax({
            url: "https://gateway.apiportal.ns.nl/public-reisinformatie/api/v2/departures?" + $.param(params),
            //url: "https://gateway.apiportal.ns.nl/public-reisinformatie/api/v2/departures?dateTime=2019-09-07 22:02:00&maxJourneys=25&lang=nl&uicCode=8400390",
            beforeSend: function(xhrObj){
                // Request headers
                xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key","APIKEY");
            },
            type: "GET",
            // Request body
            //data: "{body}",
        })
        .done(function(data) {
            //alert("success");
			console.log(data.payload.departures);
			clock.innerHTML = moment(dateTimeNow).format("HH:mm")
			i = 0
			data.payload.departures.forEach(function loop(value,key) {
					if(loop.stop){ return; }
					//console.log(value,key);
					//console.log(moment(value.actualDateTime))
					if(moment(value.actualDateTime).isBefore(moment().add(15, 'minutes'))) return;
					
					var time = document.getElementById(i+"-time");
					var dest = document.getElementById(i+"-dest");
					var track = document.getElementById(i+"-track");
					var extra = document.getElementById(i+"-extra");
					
					var vertraging =  moment(value.actualDateTime).diff(moment(value.plannedDateTime),"minutes")
					
				
					if(vertraging >0) {$(time).css('color', 'red');}
					time.innerHTML = moment(value.actualDateTime).format("HH:mm") + " (" + vertraging + ")"
					dest.innerHTML = value.direction
					track.innerHTML = value.plannedTrack
					extra.innerHTML = value.product.categoryCode
					
					
					console.log(vertraging)
					i =  i + 1
					
					if(i==8){ loop.stop = true; }
				
			});
		
		//end of successful script
		//day/night script
		if(night){
			$("#background").removeClass('bg-dark').addClass('background-night');
			$("table").removeClass('table-light').addClass('table-dark');
			$("thead").removeClass('text-light').addClass('text-dark');
			}
		else {
			$("#background").removeClass('bg-dark').addClass('background-day');
			$("table").removeClass('table-dark').addClass('table-light');
			$("thead").removeClass('text-dark').addClass('text-light');
			}
			

		
		var $classtd = $('.table td');

		function activate() {
		$classtd.removeClass('fontparty')
         .eq([Math.floor(Math.random()*$classtd.length)])
         .addClass('fontparty');
		setTimeout(activate, 60000);
		}
		if(Math.floor(Math.random()*10) <=2){
			activate();
		}
		
		
		//end show the data
		$("#container").show();		
		$("#loading").hide();
		
		
        })
        .fail(function() {
            //alert("error");
			console.log("Error");
        });
		

		
    });


//get NS-data disruptions
    $(function() {
		//console.log($.param(params))
        $.ajax({
            url: "https://gateway.apiportal.ns.nl/public-reisinformatie/api/v2/disruptions/station/8400390",
            beforeSend: function(xhrObj){
                // Request headers
                xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key","APIKEY");
            },
            type: "GET",
            // Request body
            //data: "{body}",
        })
        .done(function(data) {
            //alert("success");
			console.log(data.payload);
			var delays = document.getElementById("delays");
			data.payload.forEach(function loop(value,key) {
								
				var ul = document.createElement('ul');
				delays.appendChild(ul)
			
				$("#delays ul:nth-last-child(1)").append('<li><b>'+value.titel+'</b></li><li class="li-nobullet">'+value.verstoring.oorzaak+'</li><li class="li-nobullet">'+value.verstoring.verwachting+'</li>');
				console.log(value.titel)
				console.log(value.verstoring.oorzaak)
				console.log(value.verstoring.verwachting)			
			})
			
			
        })
        .fail(function() {
            //alert("error");
			console.log("Error");
        });
		

		
    });
</script>
</body>
</html>
