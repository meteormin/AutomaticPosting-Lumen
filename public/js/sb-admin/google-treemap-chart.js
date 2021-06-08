function drawTreeMapChart(element_id, json_data, json_options) {
    let treeMapData = google.visualization.arrayToDataTable(json_data);
    drawable = new google.visualization.TreeMap(document.getElementById(element_id));

    setTimeout(drawNow, 300, drawable, treeMapData, json_options);
}

function drawNow(drawable, data, options) {
    drawable.draw(data, options);
}
