window.onload = function(){
	
     



	
	var clock = document.getElementById("clock");


	var format = 'HH:mm:ss'
	var dateTimeNow = moment().format(); //default  
	var time = moment(moment(),format); //custom
	var timePlusMin = moment().add(20, 'minutes')
	var timePlusMax = moment().add(80, 'minutes')
	var early = moment('06:00:00', format);
	var late = moment('22:00:00', format);

	night = true
	if (time.isBetween(early, late)) { night = false }
	
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
				xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key",apikey);
			},
			type: "GET",
			// Request body
			//data: "{body}",
		})
		.done(function(data) {
			//alert("success");
			console.log(data.payload.departures);
			clock.innerHTML = moment(dateTimeNow).format("HH:mm")
			i = 0;
			data.payload.departures.forEach(function loop(value,key) {
					if(loop.stop){ return; }
					//console.log(value,key);
					//console.log(moment(value.actualDateTime))
					if(moment(value.actualDateTime).isBefore(timePlusMin)) return;
					console.log(i);
					
					var newRowData = ""
					+"<td id='"+ i +"-time' class='dept-time'></td>"
					+"<td id='"+ i +"-dest' class='dept-dest'></td>"
					+"<td id='"+ i +"-track' class='dept-track'></td>"
					+"<td id='"+ i +"-extra' class='dept-extra'></td>"
					+"<td id='"+ i +"-walk' class='dept-walk'></td>"
					+"";
					$('#'+i).html(newRowData);
					
					$('tbody').append('<tr id="'+(i+1)+'"></tr>');
					
					
					var time = document.getElementById(i+"-time");
					var dest = document.getElementById(i+"-dest");
					var track = document.getElementById(i+"-track");
					var extra = document.getElementById(i+"-extra");
					var walk = document.getElementById(i+"-walk");
					
					var vertraging =  moment(value.actualDateTime).diff(moment(value.plannedDateTime),"minutes")
					
					if(vertraging >0) {$(time).css('color', 'red');}
					time.innerHTML = moment(value.actualDateTime).format("HH:mm") + " (" + vertraging + ")"
					dest.innerHTML = value.direction
					track.innerHTML = value.plannedTrack
					extra.innerHTML = value.product.categoryCode
					walk.innerHTML = moment(moment(value.actualDateTime).subtract(20,"minutes")).format("HH:mm")
					
					var reachPlusMax = moment(value.actualDateTime).isBefore(timePlusMax)
					//console.log(vertraging)
					i =  i + 1
					
					if(reachPlusMax = false || i > 8){ loop.stop = true; }
				
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
				xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key",apikey);
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
	var feed = "feed.php";
	newsarray = [];
	$.get(feed, function (data) {
		$(data).find("item").each(function () { // or "item" or whatever suits your feed
			var el = $(this);
			newsarray.push(el.find("title").text());

		});
	});
	var divfeed = document.getElementById("feed");
	divfeed.innerHTML = newsarray;
	console.log(newsarray);
}