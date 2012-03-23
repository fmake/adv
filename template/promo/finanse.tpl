[[ extends  TEMPLATE_PATH ~ "base/main.tpl" ]] 


[[block left]]
	[[ if user.role == ID_ADMINISTRATOR]]
	<h2>Фильтрация</h2>

	<h4>Оптимизаторы</h4>
	<ul>
		<li><a [[if request.getFilter('userrole') == 0]]class="active"[[endif]] href="{action_url}?{request.writeFilter('id_user','userrole')}">Все</a></li>
		[[ for usr in promos]]
			<li><a [[if request.getFilter('id_user') == usr['id_user'] ]]class="active"[[endif]] href="{action_url}?{request.writeFilter('id_user')}&filter[id_user]={usr['id_user']}">{usr['name']}</a></li>
		[[endfor]]
	</ul>
	<h4>Аккаунт Менеджеры</h4>
	<ul>
		<li><a [[if request.getFilter('userrole') == ID_AKKAUNT and request.getFilter('id_user') == 0]]class="active"[[endif]] href="{action_url}?{request.writeFilter('id_user','userrole')}&filter[userrole]={ID_AKKAUNT}">Все</a></li>
		[[ for usr in accaunt]]
			<li><a [[if request.getFilter('id_user') == usr['id_user'] ]]class="active"[[endif]] href="{action_url}?{request.writeFilter('id_user')}&filter[id_user]={usr['id_user']}">{usr['name']}</a></li>
		[[endfor]]
	</ul>
	<h4>Пользователи</h4>
	<ul>
		<li><a [[if request.getFilter('active') == 1]]class="active"[[endif]] href="{action_url}?{request.writeFilter('active')}&filter[active]=1">Активные</a></li>
		<li><a [[if request.getFilter('active') == 0]]class="active"[[endif]] href="{action_url}?{request.writeFilter('active')}&filter[active]=0">Архив</a></li>
	</ul>
	
	<br /><hr /> 
	[[endif]]
	{parent()}
[[endblock]]

[[block content]]
	
	<div id="main-container">
	
		<div class="message">
			Отработано за {monthDays[1]['name']} {finalSum['cur_money']} руб., прогноз {finalSum['prognose_money']} руб.
		</div>

		[[ for m in monthDays]]
			[[ if loop.index == 1]]
				<a href="{action_url}?{request.writeFilter()}&month={request.month-(2-loop.index)}" class="f14" style="padding: 0 10px;"><< {m.name}</a>
			[[ elseif loop.index == 3]]
				<a href="{action_url}?{request.writeFilter()}&month={request.month-(2-loop.index)}" class="f14" style="padding: 0 10px;">{m.name} >></a>
			[[else]]
				<span class="f14" style="padding: 0 10px;">{m.name}</span>	
			[[endif]]
		[[endfor]]
		<table class="edit-table" style="width: 600px;">
			<colgroup>
				<col>
				<col width="15%">
				<col width="15%">
				<col width="15%">
			</colgroup>
			<thead>
				<tr>
					<td></td>
					<td class="al-r">max</td>
					<td class="al-r">факт</td>
					<td class="al-r" style="padding-right: 15px;">прогноз</td>
				</tr>
			</thead>
			[[ for pr in userProjects]]
				<tr  [[if loop.index is odd]]class="odd"[[endif]]>
					<td>{pr['url']}</td>
					<td class="al-r">{pr['max_money']}</td>
					<td class="al-r">{pr['cur_money']}</td>
					<td class="al-r" style="padding-right: 15px;">{pr['prognose_money']}</td>
				</tr>
			[[endfor]]
			<tfoot>
				<tr >
					<td></td>
					<td class="al-r">{finalSum['max_money']}</td>
					<td class="al-r">{finalSum['cur_money']}</td>
					<td class="al-r" style="padding-right: 15px;">{finalSum['prognose_money']}</td>
				</tr>
			</tfoot>
		</table>
		
	</div>
[[endblock]]