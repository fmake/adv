[[ extends  TEMPLATE_PATH ~ "base/main.tpl" ]] 


[[block left]]
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
								<td  style="padding-left:{(item.level)*30}px;" >
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