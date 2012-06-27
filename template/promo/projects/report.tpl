[[ extends  TEMPLATE_PATH ~ "base/main_all_content.tpl" ]] 
[[ import TEMPLATE_PATH ~"macro/search_system_url.tpl" as urlMacro ]]

[[block content]]
<script src="/js/amcharts.js" type="text/javascript"></script>
<script type="text/javascript">
<!--
[[raw]]

			var chart;

            var chartData = [
[[endraw]]
			[[for item in pr]]
			{'{'}
                count: "{item.count}",
                pr: {item.pr},
                color: "#FF0F0{loop.index}"
			{'},'}
			[[endfor]]
			
[[raw]]
			]

            AmCharts.ready(function () {
            // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.categoryField = "count";
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
                valueAxis.title = "PR";
                valueAxis.dashLength = 5;
                chart.addValueAxis(valueAxis);

                // GRAPH            
                var graph = new AmCharts.AmGraph();
                graph.valueField = "pr";
                graph.colorField = "color";
                graph.balloonText = "[[category]]: [[value]]";
                graph.type = "column";
                graph.lineAlpha = 0;
                graph.fillAlphas = 1;
                chart.addGraph(graph);

                // WRITE
                chart.write("chartdiv");

            });

			var chart_tyc;

            var chartData_tyc = [
[[endraw]]
			[[for item in tyc]]
			{'{'}
                count: "{item.count}",
                cy: {item.cy},
                color: "#FF0F0{loop.index}"
			{'},'}
			[[endfor]]
			
[[raw]]
			]
			
			AmCharts.ready(function () {
				chart_tyc = new AmCharts.AmSerialChart();
                chart_tyc.dataProvider = chartData_tyc;
                chart_tyc.categoryField = "count";
                // the following two lines makes chart 3D
                chart_tyc.depth3D = 20;
                chart_tyc.angle = 30;

                // AXES
                // category
                var categoryAxis_tyc = chart_tyc.categoryAxis;
                categoryAxis_tyc.labelRotation = 90;
                categoryAxis_tyc.dashLength = 5;
                categoryAxis_tyc.gridPosition = "start";

                // value
                var valueAxis_tyc = new AmCharts.ValueAxis();
                valueAxis_tyc.title = "ТИЦ";
                valueAxis_tyc.dashLength = 5;
                chart_tyc.addValueAxis(valueAxis_tyc);

                // GRAPH            
                var graph_tyc = new AmCharts.AmGraph();
                graph_tyc.valueField = "cy";
                graph_tyc.colorField = "color";
                graph_tyc.balloonText = "[[category]]: [[value]]";
                graph_tyc.type = "column";
                graph_tyc.lineAlpha = 0;
                graph_tyc.fillAlphas = 1;
                chart_tyc.addGraph(graph_tyc);
                // WRITE
                chart_tyc.write("chart_tycdiv");
			});
			
//-->
[[endraw]]
</script>

<a href="{action_url}" class="f12">Все проекты</a> > {projectSeo['url']}
[[include "promo/projects/tabs.tpl"]]
<div id="main-container" class="tab-content" style="display:block;">
	
	<form method="get" id="action_form_optimizer" style="padding: 20px 30px;">
		<select name="id_user" onchange="$('#action_form_optimizer').submit();">
			[[ for optimizer in optimiziers ]]
				<option  [[if optimizator.id_user == optimizer.id_user]]selected[[endif]] value="{optimizer.id_user}">{optimizer.name}</option>
			[[endfor]]
		</select>
		<select name="id_project" onchange="$('#action_form_optimizer').submit();">
			[[ for current_project in current_projects ]]
			<option [[if request.id_project == current_project.id_project]]selected[[endif]] value="{current_project.id_project}">{current_project.url}</option>
			[[endfor]]
		</select>
		<br/>
		[[if not current_report]]
		<input type="submit" name="" onclick="$('#hid_field').val('make_order');$('#action_form_optimizer').submit();return false;" value="Создать отчет" style="margin-top:20px" />
		[[if reports]]
		<br/>
		<p>Ранее созданные отчеты:</p>
		[[ for report in reports ]]
		<p><a href="report?id_user={request.id_user}&id_project={request.id_project}&id_report={report.id_project_seo_report}">Отчет {report.date|date("d.m.Y")}</a></p>
		[[endfor]]
		[[endif]]
		[[else]]
		<p>Отчет создается... (дата начала { current_report[0]['date']|date("d.m.Y") })</p>
		[[endif]]
	</form>
	[[if pr and tyc]]
	<table>
		<tr>
			<td>
				<div id="chart_tycdiv" style="width: 640px; height: 400px;"></div>
			</td>
			<td>
				<div id="chartdiv" style="width: 640px; height: 400px;"></div>
			</td>
		</tr>
	</table>
	[[endif]]
</div>
			
<div id="main-container" class="tab-content">
</div>
[[endblock]]