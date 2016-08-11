var chartJsColorIndex = 0;
var chartJsColors = [
    {color: "#ffbb00", highlight: "#ffbb11"},
    {color: "#3cba54", highlight: "#008744"},
    {color: "#d62d20", highlight: "#db3236"},
    {color: "#4885ed", highlight: "#0057e7"},
    {color: "#00ffff", highlight: "#00ffff"},
    {color: "#bdb76b", highlight: "#bdb76b"},
    {color: "#f5f5dc", highlight: "#f5f5dc"},
    {color: "#000000", highlight: "#000000"},
    {color: "#0000ff", highlight: "#0000ff"},
    {color: "#f0ffff", highlight: "#f0ffff"},
    {color: "#a52a2a", highlight: "#a52a2a"},
    {color: "#00ffff", highlight: "#00ffff"},
    {color: "#00008b", highlight: "#00008b"},
    {color: "#008b8b", highlight: "#008b8b"},
    {color: "#a9a9a9", highlight: "#a9a9a9"},
    {color: "#006400", highlight: "#006400"},
    {color: "#8b008b", highlight: "#8b008b"},
    {color: "#556b2f", highlight: "#556b2f"},
    {color: "#ff8c00", highlight: "#ff8c00"},
    {color: "#9932cc", highlight: "#9932cc"},
    {color: "#8b0000", highlight: "#8b0000"},
    {color: "#e9967a", highlight: "#e9967a"},
    {color: "#9400d3", highlight: "#9400d3"},
    {color: "#ff00ff", highlight: "#ff00ff"},
    {color: "#ffd700", highlight: "#ffd700"},
    {color: "#008000", highlight: "#008000"},
    {color: "#4b0082", highlight: "#4b0082"},
    {color: "#f0e68c", highlight: "#f0e68c"},
    {color: "#add8e6", highlight: "#add8e6"},
    {color: "#e0ffff", highlight: "#e0ffff"},
    {color: "#90ee90", highlight: "#90ee90"},
    {color: "#d3d3d3", highlight: "#d3d3d3"},
    {color: "#ffb6c1", highlight: "#ffb6c1"},
    {color: "#ffffe0", highlight: "#ffffe0"},
    {color: "#00ff00", highlight: "#00ff00"},
    {color: "#ff00ff", highlight: "#ff00ff"},
    {color: "#800000", highlight: "#800000"},
    {color: "#000080", highlight: "#000080"},
    {color: "#808000", highlight: "#808000"},
    {color: "#ffa500", highlight: "#ffa500"},
    {color: "#ffc0cb", highlight: "#ffc0cb"},
    {color: "#800080", highlight: "#800080"},
    {color: "#800080", highlight: "#800080"},
    {color: "#ff0000", highlight: "#ff0000"},
    {color: "#c0c0c0", highlight: "#c0c0c0"},
    {color: "#ffffff", highlight: "#ffffff"},
    {color: "#ffff00", highlight: "#ffff00"}
];

function nextChartJsColor() {
    if (chartJsColorIndex >= chartJsColors.length) {
        chartJsColorIndex = 0;
    }
    return chartJsColors[chartJsColorIndex++];
}

function applyChartColors(list, labelContainer) {
    chartJsColorIndex = 0;
    var color;
    var dotCircle;
    for (var i=0; i<list.length; i++) {
        color = nextChartJsColor();
        list[i].color = color.color;
        list[i].highlight = color.highlight;

        dotCircle = $(labelContainer + ' .chart-label .chart-dot-circle').get(i);
        $(dotCircle).css('background-color', color.color);
    }
    return list;
}

