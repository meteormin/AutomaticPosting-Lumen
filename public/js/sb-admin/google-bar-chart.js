function drawBarChart(element_id,json_data, json_options, json_columns) {
    let barData = google.visualization.arrayToDataTable(json_data);
    let barView = new google.visualization.DataView(barData);

    barView.setColumns(json_columns);

    drawable = new google.visualization.BarChart(document.getElementById(element_id));

    setTimeout(drawNow, 300, drawable, barView, json_options);
}

function drawNow(drawable, data, options) {
    drawable.draw(data, options);
}
