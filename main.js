var map;
ymaps.ready(function () {
    map = new ymaps.Map("map", {
        center: [56.829352, 60.651455],
        zoom: 13
    });
    loadJSON(function (data) {
        setBalloon(JSON.parse(data));
    });
});

function loadJSON(callback) {
    var xobj = new XMLHttpRequest();
    xobj.overrideMimeType("application/json");
    xobj.open('GET', 'emergency_all.json', true);
    // Replace 'my_data' with the path to your file
    xobj.onreadystatechange = function () {
        if (xobj.readyState === 4 && xobj.status === 200) {
            // Required use of an anonymous callback
            // as .open() will NOT return a value but simply returns undefined in asynchronous mode
            callback(xobj.responseText);
        }
    };
    xobj.send(null);
}

function init() {
    loadJSON(function (response) {
        // Parse JSON string into object
        var actual_JSON = JSON.parse(response);
    });
}

function setBalloon(data) {
    data.forEach(function (item) {
        var color;
        var pos = item.pos.split(' ');
        pos = [pos[1], pos[0]];
        var placemark = new ymaps.Placemark(pos, {
                hintContent: item.name,
                balloonContent: '<div><b>'+item.name+'</b></div><div>'+item.attr+'</div>'
            },
            {
                iconColor: item.type === 'business' ? '#329ae8' : '#9a27c5'
            }
        );
        map.geoObjects.add(placemark)
    })
}