[[ extends  TEMPLATE_PATH ~ "base/main_all_content.tpl" ]] 
[[ import TEMPLATE_PATH ~"macro/search_system_url.tpl" as urlMacro ]]

[[block content]]
<script src="/js/amcharts.js" type="text/javascript"></script>
<script type="text/javascript">
<!--
[[raw]]

var chart;

            var chartData = [{
                country: "USA",
                visits: 4025,
                color: "#FF0F00"
            }, {
                country: "China",
                visits: 1882,
                color: "#FF6600"
            }, {
                country: "Japan",
                visits: 1809,
                color: "#FF9E01"
            }, {
                country: "Germany",
                visits: 1322,
                color: "#FCD202"
            }, {
                country: "UK",
                visits: 1122,
                color: "#F8FF01"
            }, {
                country: "France",
                visits: 1114,
                color: "#B0DE09"
            }, {
                country: "India",
                visits: 984,
                color: "#04D215"
            }, {
                country: "Spain",
                visits: 711,
                color: "#0D8ECF"
            }, {
                country: "Netherlands",
                visits: 665,
                color: "#0D52D1"
            }, {
                country: "Russia",
                visits: 580,
                color: "#2A0CD0"
            }, {
                country: "South Korea",
                visits: 443,
                color: "#8A0CCF"
            }, {
                country: "Canada",
                visits: 441,
                color: "#CD0D74"
            }, {
                country: "Brazil",
                visits: 395,
                color: "#754DEB"
            }, {
                country: "Italy",
                visits: 386,
                color: "#DDDDDD"
            }, {
                country: "Australia",
                visits: 384,
                color: "#999999"
            }, {
                country: "Taiwan",
                visits: 338,
                color: "#333333"
            }, {
                country: "Poland",
                visits: 5328,
                color: "#000000"
            }];


            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.categoryField = "country";
                // the following two lines makes chart 3D
                chart.depth3D = 20;
                chart.angle = 30;

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.labelRotation = 90;
                categoryAxis.dashLength = 5;
                categoryAxis.gridPosition = "start";

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.title = "Visitors";
                valueAxis.dashLength = 5;
                chart.addValueAxis(valueAxis);

                // GRAPH            
                var graph = new AmCharts.AmGraph();
                graph.valueField = "visits";
                graph.colorField = "color";
                graph.balloonText = "[[category]]: [[value]]";
                graph.type = "column";
                graph.lineAlpha = 0;
                graph.fillAlphas = 1;
                chart.addGraph(graph);

                // WRITE
                chart.write("chartdiv");
            });

//-->
[[endraw]]
</script>

<a href="{action_url}" class="f12">Все проекты</a> > {projectSeo['url']}
[[include "promo/projects/tabs.tpl"]]
<div id="main-container" class="tab-content" style="display:block;">
	<div id="chartdiv" style="width: 640px; height: 400px;"></div>
</div>
			
<div id="main-container" class="tab-content">
</div>
[[endblock]]