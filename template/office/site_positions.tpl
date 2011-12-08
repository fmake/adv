[[ extends "base/main_all_content.tpl" ]]

[[ block content ]]
	<div id="main-container">
		<h1>{modul.caption}</h1>
		{modul.text|raw}
	<form method="GET">
		<select name="id_project" onchange="this.form.submit()">	
			[[ for pr in projectsSeo ]]
				<option value="{pr['id_project']}" [[if request.id_project ==pr['id_project'] ]]selected[[endif]]>{pr['url']}</option>
			[[endfor]]
		</select>
		<select onchange="this.form.submit()" name="area">
			<option value="week" [[if request.area == 'week' ]]selected[[endif]]>За 7 дней</option>
			<option value="month" [[if request.area == 'month' ]]selected[[endif]]>За текущий месяц</option>
			<option value="lastmonth" [[if request.area == 'lastmonth' ]]selected[[endif]]>За прошлый месяц</option>
			<option value="2lastmonth" [[if request.area == '2lastmonth' ]]selected[[endif]]>2 месяца назад</option>
			<option value="3lastmonth" [[if request.area == '3lastmonth' ]]selected[[endif]]>3 месяца назад</option>
		</select>
	</form>
	[[ for searh in project['search_systems'] ]]
		<table>
			<tr>
				<td>
					<table class="userquerys">
						<tr>
							<td>
								[[set search_system = searh['id_seo_search_system']]]
								[[ include TEMPLATE_PATH ~ "office/searchsystemcasename.tpl"]]
								 Москва
							</td>
						</tr>
						[[ for query in searh['querys'] ]]
							<tr>
								<td>
									<div>{query['query']}</div>
								</td>
							</tr>
						[[endfor]]	
					</table>
				</td>
				<td>
					<table  class="userquerys-pos">
					<tr>
					[[ for day in daysView ]]
						<td>
							{df('date','d.m',day)}
						</td>
					[[endfor]]
					</tr>
					[[ for query in searh['querys'] ]]
						<tr>
							[[ for day in daysView ]]
								<td>
									{query['pos'][day]['pos']|default(0)}
								</td>
							[[ endfor]]	
						</tr>
					[[endfor]]
					</table>
				</td>
				<td>
				</td>
			</tr>		
		</table>
		
	[[endfor]]

</div>
[[ endblock ]]