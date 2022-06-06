var map = {
	settings: {
		mapId: 'map',
		coordinates : {
			'lat':parseFloat( cmfMap.coordinates.lat ),
			'lng': parseFloat( cmfMap.coordinates.lng )
		},
		zoom: parseInt( cmfMap.zoom ),
		mapIconUrl: '/wp-content/themes/comfy/dist/img/map-icon.svg',
		styles: [
			{
				"elementType": "geometry",
				"stylers": [
					{
						"color": "#f5f5f5"
				}
				]
		},
			{
				"elementType": "labels.icon",
				"stylers": [
					{
						"visibility": "off"
				}
				]
		},
			{
				"elementType": "labels.text.fill",
				"stylers": [
					{
						"color": "#616161"
				}
				]
		},
			{
				"elementType": "labels.text.stroke",
				"stylers": [
					{
						"color": "#f5f5f5"
				}
				]
		},
			{
				"featureType": "administrative.land_parcel",
				"elementType": "labels.text.fill",
				"stylers": [
					{
						"color": "#bdbdbd"
				}
				]
		},
			{
				"featureType": "poi",
				"elementType": "geometry",
				"stylers": [
					{
						"color": "#eeeeee"
				}
				]
		},
			{
				"featureType": "poi",
				"elementType": "labels.text.fill",
				"stylers": [
					{
						"color": "#757575"
				}
				]
		},
			{
				"featureType": "poi.park",
				"elementType": "geometry",
				"stylers": [
					{
						"color": "#e5e5e5"
				}
				]
		},
			{
				"featureType": "poi.park",
				"elementType": "labels.text.fill",
				"stylers": [
					{
						"color": "#9e9e9e"
				}
				]
		},
			{
				"featureType": "road",
				"elementType": "geometry",
				"stylers": [
					{
						"color": "#ffffff"
				}
				]
		},
			{
				"featureType": "road.arterial",
				"elementType": "labels.text.fill",
				"stylers": [
					{
						"color": "#757575"
				}
				]
		},
			{
				"featureType": "road.highway",
				"elementType": "geometry",
				"stylers": [
					{
						"color": "#dadada"
				}
				]
		},
			{
				"featureType": "road.highway",
				"elementType": "labels.text.fill",
				"stylers": [
					{
						"color": "#616161"
				}
				]
		},
			{
				"featureType": "road.local",
				"elementType": "labels.text.fill",
				"stylers": [
					{
						"color": "#9e9e9e"
				}
				]
		},
			{
				"featureType": "transit.line",
				"elementType": "geometry",
				"stylers": [
					{
						"color": "#e5e5e5"
				}
				]
		},
			{
				"featureType": "transit.station",
				"elementType": "geometry",
				"stylers": [
					{
						"color": "#eeeeee"
				}
				]
		},
			{
				"featureType": "water",
				"elementType": "geometry",
				"stylers": [
					{
						"color": "#c9c9c9"
				}
				]
		},
			{
				"featureType": "water",
				"elementType": "labels.text.fill",
				"stylers": [
					{
						"color": "#9e9e9e"
				}
				]
		}
		],
	},
	init: function () {
		if (this.settings.coordinates.lat && this.settings.coordinates.lng && this.settings.zoom) {
			window.addEventListener( "load", this.mapInit.bind( this ) );
		}
	},
	mapInit: function () {
		var coordinates = new google.maps.LatLng( this.settings.coordinates ),
			map         = new google.maps.Map(
				document.getElementById( this.settings.mapId ),
				{
					center: coordinates,
					zoom: this.settings.zoom,
					disableDefaultUI: true,
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					styles: this.settings.styles
				}
			);
			new google.maps.Marker(
				{
					position: coordinates,
					map: map,
					icon: this.settings.mapIconUrl
				}
			);
	},
};
map.init();
