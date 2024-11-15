
/* --------------------------------------------
Google Map Initialization
-------------------------------------------- */
window.onload = MapLoadScript;

function GmapInit() {
    const Gmap = $('.map-canvas');
    Gmap.each(function() {
        const $this = $(this);
        let lat = parseFloat($this.data('lat')) || 0;
        let lng = parseFloat($this.data('lng')) || 0;
        let zoom = parseFloat($this.data('zoom')) || 20;
        const scrollwheel = $this.data('scrollwheel') !== undefined ? $this.data('scrollwheel') : false;
        const zoomcontrol = $this.data('zoomcontrol') !== undefined ? $this.data('zoomcontrol') : true;
        const mapType = getMapType($this.data('type'));
        const title = $this.data('title') || '';
        const contentString = $this.data('content') ? `<div class="map-data"><h6>${title}</h6><div class="map-content">${$this.data('content')}</div></div>` : '';
        const themeIconPath = $this.data('icon-path') || 'images/icons/map-marker.png';

        if (navigator.userAgent.match(/iPad|iPhone|Android/i)) {
            draggable = false;
        }

        const mapOptions = {
            zoom: zoom,
            scrollwheel: scrollwheel,
            zoomControl: zoomcontrol,
            draggable: true,
            center: new google.maps.LatLng(lat, lng),
            mapTypeId: mapType
        };

        const map = new google.maps.Map($this[0], mapOptions);
        const marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat, lng),
            map: map,
            icon: themeIconPath,
            title: title
        });

        if (contentString) {
            const infowindow = new google.maps.InfoWindow({
                content: contentString
            });
            marker.addListener('click', function() {
                infowindow.open(map, marker);
            });
        }
    });
}

function getMapType(type) {
    switch (type) {
        case 'satellite':
            return google.maps.MapTypeId.SATELLITE;
        case 'hybrid':
            return google.maps.MapTypeId.HYBRID;
        case 'terrain':
            return google.maps.MapTypeId.TERRAIN;
        default:
            return google.maps.MapTypeId.ROADMAP;
    }
}

	
function MapLoadScript() {
	var script = document.createElement('script');
	script.type = 'text/javascript';
	GmapInit();
	document.body.appendChild(script);
}
