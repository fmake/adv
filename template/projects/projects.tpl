[[ extends  TEMPLATE_PATH ~ "base/main.tpl" ]] 


[[block left]]
	<h4>Сайты</h4>
	<ul>
		<li><a href="{action_url}">Активные</a></li>
		<li><a href="{action_url}">Архив</a></li>
	</ul>
	<h4>Услуга</h4>
	<ul>
		<li><a href="{action_url}">Продвижение</a></li>
		<li><a href="{action_url}">Контекст</a></li>
	</ul>
	<h4>Группировка</h4>
	<ul>
		<li><a href="{action_url}">По названиям</a></li>
		<li><a href="{action_url}">По клиентам</a></li>
		<li><a href="{action_url}">По оптимизаторам</a></li>
		<li><a href="{action_url}">По менеджерам</a></li>
	</ul>
	<h4>Поиск сайта</h4>
	<input type="text" name="project" class="project-search" style="width:180px" />
[[endblock]]

[[block content]]

	<div id="main-container">
		<h1>{modul.caption}</h1>
		{modul.text|raw}
		<form acton="/{request.parents}/{request.modul}" method="GET">	
			<input type="hidden" name="action" value="new" />
			<button class="green"><div><div>Добавить</div></div></button>
		</form>
		qq
	</div>
[[endblock]]