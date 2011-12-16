[[ extends  TEMPLATE_PATH ~ "base/main.tpl" ]] 


[[block left]]
	<h2>Фильтрация</h2>
	<h4>Пользователи</h4>
	<ul>
		<li><a [[if request.getFilter('active') == 1]]class="active"[[endif]] href="{action_url}?{request.writeFilter('active')}&filter[active]=1">Активные</a></li>
		<li><a [[if request.getFilter('active') == 0]]class="active"[[endif]] href="{action_url}?{request.writeFilter('active')}&filter[active]=0">Архив</a></li>
	</ul>
	<h4>По роли</h4>
	<ul>
		<li><a [[if request.getFilter('role') == 0]]class="active"[[endif]] href="{action_url}?{request.writeFilter('role')}">Все</a></li>
		[[ for role in rols]]
			<li><a [[if request.getFilter('role') == role['id_modul_role'] ]]class="active"[[endif]] href="{action_url}?{request.writeFilter('role')}&filter[role]={role['id_modul_role']}">{role['role']}</a></li>
		[[endfor]]
	</ul>
	<br /><hr /> 
	{parent()}
[[endblock]]

[[block content]]
	
	<div id="main-container">
		<h1>{modul.caption}</h1>
		<h1>{modul.text|raw}</h1>
		<form acton="/{request.parents}/{request.modul}" method="GET">	
			<input type="hidden" name="action" value="new" />
			<button class="green"><div><div>Добавить</div></div></button>
		</form>
		<table class="edit-table">
			<colgroup>
				[[ for fild in filds ]]
					<col [[if fild['col'] ]]width="{fild['col']}"[[endif]] /> 
				[[endfor]]
			</colgroup>
			<thead>
				<tr>
					[[ for fild in filds ]]
						<td>{fild['name']}</td>
					[[endfor]]
				</tr>
			</thead>
			<tbody>
				[[ for item in items ]]
					<tr [[if loop.index is odd]]class="odd"[[endif]]>
						
						[[ for key,fild in filds ]]
							[[ if key != 'actions' ]]
								<td>
									[[ if loop.first ]]
										<a href="{action_url}?action=edit&id={item[itemObj.idField]}" class="link-icon f12" >{item[key]}</a>
									[[else]]
										{item[key]}
									[[endif]]
								</td>
							[[endif]]
						[[endfor]]
						<td>
							[[ include TEMPLATE_PATH ~ "actions/actions.tpl" ]]
						</td>
					</tr>
				[[ endfor ]]
			</tbody>	
		</table>
	</div>
[[endblock]]