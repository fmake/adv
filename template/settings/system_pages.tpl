[[ extends  TEMPLATE_PATH ~ "base/main.tpl" ]] 


[[block left]]
	{parent()}
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
					<col width="10px" />
				[[ for role in roles ]]
					<col width="10px" />
				[[endfor]]
				[[ for fild in filds ]]
					<col [[if fild['col'] ]]width="{fild['col']}"[[endif]] /> 
				[[endfor]]
			</colgroup>
			<thead>
				<tr>
					<td colspan="{df('sizeof',roles)+1}" style="padding:0 10px;" align="center">
						Доступ
					</td>
					[[ for fild in filds ]]
						<td rowspan="2">{fild['name']}</td>
					[[endfor]]
				</tr>
				<tr>
					<td ><em title="{role['role']}">Все</em></td>
					[[ for role in roles ]]
						<td ><em title="{role['role']}">{df('mb_substr',role['role'],0,2)}</em></td>
					[[endfor]]					
				</tr>
			</thead>
			<tbody>
				[[ for item in items ]]
					<tr [[if loop.index is odd]]class="odd"[[endif]]>
					
						<td>
							<img id="checkbox-load-{item[itemObj.idField]}" class="show-check show-check-pages" src="/images/load-checkbox.gif" />
							<input title="Разрешить доступ 'ВСЕМ ПОЛЬЗОВАТЕЛЯМ' к странице '{item['caption']}'" type="checkbox" onclick="chekedOtherRole('checkbox-{item[itemObj.idField]}');return false;"/>
						</td>
						[[ for role in roles ]]
							<td class="checkbox-{item[itemObj.idField]} checkbox-role"><input type="checkbox" title="Разрешить доступ '{role['role']}' к странице '{item['caption']}'" value="{item[itemObj.idField]}-{role[roleObj.idField]}" [[if checkRoles[item[itemObj.idField]][role[roleObj.idField]] ]]checked="checked"[[endif]]/></td>
						[[endfor]]		

						[[ for key,fild in filds ]]
							[[ if key != 'actions' ]]
								<td style="padding-left:{(item.level)*30}px;">
									<a href="{action_url}?action=edit&id={item[itemObj.idField]}" class="link-icon f12" >{item[key]}</a>
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