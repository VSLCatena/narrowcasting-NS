var debug = false;

if (debug) {
	document.getElementById("debug").style.display = "flex";

	function addDebug() {
		document.getElementById("debugText").innerHTML += JSON.stringify(arguments) + "<br />";
	}

	function hookDebugging(func) {
		return function() {
			// func.apply(null, arguments);
			addDebug(arguments);
		}
	}

	/* Comment out any messages you don't want to display */
	// console.debug = hookDebugging(console.debug);
	console.info = hookDebugging(console.info);
	console.log = hookDebugging(console.log);
	console.warn = hookDebugging(console.warn);
	console.error = hookDebugging(console.error);
	
	window.addEventListener('error', function(e) { addDebug(e); });
	window.addEventListener('unhandledrejection', function(e) { addDebug(e); });
}

$(window).ready(function() {
	$("#clock").html(moment().format("HH:mm"));

	// The only thing we need to do manually is how the table looks.
	$("#departures")
		.removeClass("table-dark table-light")
		.addClass(night ? 'table-dark' : 'table-light');
	


	
	//get NS-data departures
	var params = {
		dateTime: moment().format(),
		maxJourneys: '25',
		lang: 'nl',
		uicCode: '8400390'
	};

	$.ajax({
		type: "GET",
		url: "https://gateway.apiportal.ns.nl/reisinformatie-api/api/v2/departures?" + $.param(params),
		headers: {
			"accept": "application/json",
			"Access-Control-Allow-Origin":"http://narrowcasting-ns.vslcatena.lan"
		},
		beforeSend: function(xhrObj){
			xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key",apikey);
		}
	})
	.done(function(data) {
		// Hide the loading screen, and show the actual content
		$("#loading").hide();
		$('.container').show();

		console.log("AJAX departure call succesful");
		console.debug(data.payload.departures);

		// Create a moment of 20 minutes from now
		var twentyMinutesFromNow = moment().add(20, 'minutes');

		for (var index = 0, itemsAdded = 0; index < data.payload.departures.length; index++) {
			var departure = data.payload.departures[index];

			// Some convenience variables
			var planned = moment(departure.plannedDateTime);
			var actual = moment(departure.actualDateTime);

			// It is about 20 minutes to walk, so we skip all those that can't be reached
			if(actual.isBefore(twentyMinutesFromNow)) continue;
			
			// The time formatted
			var time = actual.format('HH:mm');
			// If the the planned departure time is different from the actual time, we show the difference
			if (planned.diff(actual) != 0) {
				time = '<del>'+planned.format("HH:mm")+'</del> <span class="text-danger">'+time+'</span>';
			}
			
			// When should we start walking from Catena?
			var walk  = moment(departure.actualDateTime).subtract(20,"minutes").format("HH:mm");

			// Here we create our table row
			var newRowData = "<tr>" +
                "<td>" + time + "</td>" +
			    "<td>" + departure.direction + "</td>" +
				"<td>" + departure.plannedTrack + "</td>" +
				"<td>" + departure.product.categoryCode + "</td>" +
				"<td>" + walk + "</td>" +
				"</tr>";
			
			// And add it to the table
			$('tbody').append(newRowData);

			// If we have 8 items we stop
			if (++itemsAdded >= 8) break;
		}
	
		// Some random code because it's fun
		// There is a 20% chance we randomly start changing the font to comic sans
		if(Math.floor(Math.random()*10) <= 2){
			console.log("fontparty")

			var $classtd = $('.table td');
			(function activate() {
				// Grab a random TD and add the fontparty class
				$classtd.removeClass('fontparty')
					.eq([Math.floor(Math.random()*$classtd.length)])
					.addClass('fontparty');
				
				// And do it again in a minute
				setTimeout(activate, 60000);
			})();
		}
	})
	.fail(function(xhr) {
		console.log("Departures error: " + xhr.responseText);
		console.info(xhr);
	});
		

		


	//get NS-data disruptions
	$.ajax({
		type: "GET",
		url: "https://gateway.apiportal.ns.nl/reisinformatie-api/api/v2/disruptions/station/8400390",
		headers: {
			"accept": "application/json",
			"Access-Control-Allow-Origin":"http://narrowcasting-ns.vslcatena.lan"
		},
		beforeSend: function(xhrObj){
			xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key",apikey);
		},
	})
	.done(function(data) {
		console.log("Succesfully got NS disruptions");
		console.debug(data);

		// If the payload is empty we hide our disruptions element
		if (data.payload.length <= 0) {
			$("#delays-holder").hide();
			return;
		}

		// Go over each disruption and append it to the delays item
    	for (var i = 0; i < data.payload.length; i++) {
			var item = data.payload[i];
			item = '<ul>' +
					'<li><b>' + item.titel + '</b></li>' +
					'<li class="li-nobullet">' + item.verstoring.oorzaak + '</li>' + 
					'<li class="li-nobullet">' + item.verstoring.verwachting + '</li>' +
				'</ul>';

			$("#delays").append(item);
		}
		
		
	})
	.fail(function(xhr) {
		console.log("Disruptions error: " + xhr.responseText);
		console.info(xhr);
	});
	
	

		
	 //Randomize array element order in-place.
	 //Using Durstenfeld shuffle algorithm.
	 function shuffleArray(array) {
		for (var i = array.length - 1; i > 0; i--) {
			var j = Math.floor(Math.random() * (i + 1));
			var temp = array[i];
			array[i] = array[j];
			array[j] = temp;
		}
		return array;
	}
	
	// Load news data (10% chance of loading humor data)
	var loadHumorInstead = Math.floor(Math.random() * 10) < 1;
	var feed = "feed.php?url=" + (loadHumorInstead ? 2 : 1);
	$.get(feed)
	.then(function (data) {
		console.log("News success");
		console.debug(data);
		
		var newsarray = [];
		$(data).find("item")
			.each(function () { // For each item we grab the title and push it to newsArray
				newsarray.push($(this).find("title").text());
			});

		// Randomize the news
		newsarray = shuffleArray(newsarray);
		// And add it to the feed, separated by |
		$("#feed").html(newsarray.join("  |  "));
	})
	.fail(function(xhr) {
		console.log("News error: " + xhr.responseText);
		console.info(xhr);
	});

});

