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
								<td [[if fild['align'] ]]align="{fild['align']}"[[endif]]>
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