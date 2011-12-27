[[ extends  TEMPLATE_PATH ~ "base/main.tpl" ]] 

[[block left]]
	<h4>Клиенты</h4>
	<ul>
		<li><a [[if request.getFilter('active') == 1]]class="active"[[endif]] href="{action_url}?{request.writeFilter('active')}&filter[active]=1">Активные</a></li>
		<li><a [[if request.getFilter('active') == 0]]class="active"[[endif]] href="{action_url}?{request.writeFilter('active')}&filter[active]=0">Архив</a></li>
	</ul>
	<h4>Услуга</h4>
	<ul>
		<li><a [[if not request.getFilter('is_seo') and not request.getFilter('is_context')]]class="active"[[endif]] href="{action_url}?{request.writeFilter('is_seo','is_context')}">Все</a></li>
		<li><a [[if request.getFilter('is_seo') == 1]]class="active"[[endif]] href="{action_url}?{request.writeFilter('is_seo','is_context')}&filter[is_seo]=1">Продвижение</a></li>
		<li><a [[if request.getFilter('is_context') == 1]]class="active"[[endif]] href="{action_url}?{request.writeFilter('is_seo','is_context')}&filter[is_context]=1">Контекст</a></li>
	</ul>
	<h4>Группировка</h4>
	<ul>
		<li><a [[if request.getFilter('groupby') == 0]]class="active"[[endif]] href="{action_url}?{request.writeFilter('groupby')}">По названиям</a></li>
		<li><a [[if request.getFilter('groupby') == ID_OPTIMISATOR]]class="active"[[endif]] href="{action_url}?{request.writeFilter('groupby')}&filter[groupby]={ID_OPTIMISATOR}">По оптимизаторам</a></li>
		<li><a [[if request.getFilter('groupby') == ID_AKKAUNT]]class="active"[[endif]] href="{action_url}?{request.writeFilter('groupby')}&filter[groupby]={ID_AKKAUNT}">По менеджерам</a></li>
	</ul>
	<h4>Поиск клиента</h4>
	<input type="text" name="project" class="project-search" style="width:180px" id="project" />
	[[raw]]
	<script>
	function checkSiteAutocomplite(id,user){
		$(".edit-table tbody tr").removeClass("check-autocomplite");
		$(".edit-table tbody tr#site_tr"+id).addClass("check-autocomplite");
		
		if(user){
			$(".table-user").hide();
			$("#table-user-"+user).show();
		}
		
		window.location = "#site"+id;
	}
	
	$(function() {
		$( "#project" ).autocomplete({
	[[endraw]]
			source: "{action_url}?action=getsite&{request.writeFilter('')|raw}",
	[[raw]]		
			autoFocus: true,
			minLength: 2,
			select: function( event, ui ) {
				checkSiteAutocomplite(ui.item.id,ui.item.user);
			}
		});
	});
	</script>
	[[endraw]]
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
[[endblock]]