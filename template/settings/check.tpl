[[ extends  TEMPLATE_PATH ~ "base/main.tpl" ]] 


[[block left]]
	{parent()}
[[endblock]]

[[block content]]
	<div id="tabs">			
		<a href="#tab0" class="item active" >Проверка позиций</a>
		<a href="#tab1" class="item" >Подсчет премий</a>
	</div>
	<div id="main-container" class="tab-content" style="display:block;">
		{posForm|raw}
		<a class="f14" href="/cron/cron.php?key={cronKey}&action=check_positions" target="_blank">Проверить оставшиеся запросы</a><br />
		<a class="f14" href="/cron/cron.php?key={cronKey}&action=check_positions&checkIfExist=true" target="_blank">Проверить все запросы заново</a>
	</div>
	<div id="main-container" class="tab-content">
		{payForm|raw}
		<a class="f14" href="/cron/cron.php?key={cronKey}&action=check_money" target="_blank">Подсчитать премии компании по проектам</a><br />
	</div>
[[endblock]]