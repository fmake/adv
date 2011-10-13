[[ extends  TEMPLATE_PATH ~ "base/main_all_content.tpl" ]] 


[[block left]]
	{parent()}
[[endblock]]

[[block content]]
	<div id="tabs">			
		<a href="#tab0" class="item active" >Основные</a>
		<a href="#tab1" class="item" >Оповещения системы</a>
		<a href="#tab2" class="item" >Написать жалобу</a>
	</div>
	<div id="main-container" class="tab-content" style="display:block;">
		<h1>Личные данные</h1>
		{modul.text|raw}
		{form|raw}
	</div>
	<div id="main-container" class="tab-content">
		<h1>Оповещения системой</h1>
		{systemForm|raw}
	</div>
	<div id="main-container" class="tab-content">
		{helpForm|raw}
	</div>
[[endblock]]