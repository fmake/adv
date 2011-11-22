[[ extends  TEMPLATE_PATH ~ "projects/clients.tpl" ]] 

[[block content]]

	<div id="main-container">
		<h1>{modul.caption}</h1>
		{modul.text|raw}
		<form acton="/{request.parents}/{request.modul}" method="GET">	
			<input type="hidden" name="action" value="new" />
			<button class="green"><div><div>Добавить</div></div></button>
		</form>
		[[ for itemUser in items ]]
			<table class="edit-table">
				<colgroup>
					[[ for fild in filds ]]
						<col [[if fild['col'] ]]width="{fild['col']}"[[endif]] /> 
					[[endfor]]
				</colgroup>
				<tr [[if loop.index is odd]]class="odd"[[endif]]>
					<td><a href="#" class="groupHeadUser" onclick="$('#table-user-{itemUser['id_user']}').toggle();return false;">{itemUser['name']}</a></td>
					<td align="right">{itemUser['max_seo_pay']}</td>
					<td></td>
					<td></td>
				</tr>
			</table>	
			<div style="padding-left:30px;">
			<table class="edit-table table-user" style="display:none;" id="table-user-{itemUser['id_user']}">
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
					[[ for item in itemUser['projects'] ]]
						<tr [[if loop.index is odd]]class="odd"[[endif]] id="site_tr{item[itemObj.idField]}">
							
							[[ for key,fild in filds ]]
								[[ if key != 'actions' ]]
									<td [[if fild['align'] ]]align="{fild['align']}"[[endif]]>
										[[ if loop.first ]]
											<a name="site{item[itemObj.idField]}" ></a>
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
		[[endfor]]
	</div>
[[endblock]]