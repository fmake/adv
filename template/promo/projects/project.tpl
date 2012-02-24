[[ extends  TEMPLATE_PATH ~ "base/main.tpl" ]] 


[[block left]]
	<h2>Страницы</h2>
	<ul>
		<li><a href="{action_url}?id_project={request.id_project}" [[if not request.id_project_url]]class="active"[[endif]]>Все</a></li>
	  [[ for url in projectUrls ]]
		<li><a href="{action_url}?id_project={request.id_project}&id_project_url={url['id_project_url']}" [[if request.id_project_url==url['id_project_url']]]class="active"[[endif]]>{url['name']?url['name']:url['url']}</a></li>
	[[endfor]]
	</ul>

	
[[endblock]]

[[block content]]

	<script type="text/javascript">
<!--
colspanPlus = {updateCount - viewCount + nonUpdateCount - 1};
[[raw]]
function checkGroup(obj,cl){
	if($(obj).attr("checked") != undefined ){
		$("."+cl).attr("checked", "checked"); 
	}else{
		$("."+cl).attr("checked", false);
	}
}

function showNextPosition(obj){

	current = parseInt($(".position-colspan").eq(0).attr("colspan"));
	if(current == defaultColspan){
		$(".position-colspan").attr("colspan",current + colspanPlus);
		$(".hidden-td").show();
		($(".view-update").html("<< скрыть"));
	}else{
		$(".position-colspan").attr("colspan",current - colspanPlus);
		$(".hidden-td").hide();
		($(".view-update").html("еще >>"));
	}
	return false;
}


function setParamUrl(id_param,id_url,value){
	$('#date_title_'+id_url+'_'+id_param +' i').html('');
	$('#date_title_'+id_url+'_'+id_param + ' .show-check').show();
	xajax_setParamUrl(id_param,id_url,value,true);
}

function endSetValue(id_param,id_url,date,value){
	$('#date_title_'+id_url+'_'+id_param +' i').html(date);
	$('#date_title_'+id_url+'_'+id_param +' .val').html(value);
	$('#date_title_'+id_url+'_'+id_param + ' .show-check').hide();
}

function defaultAll(id) {
	$(id+ ' input[type=checkbox]:checked').attr("checked", false).click().attr("checked", false);
}


$('#system-search-link').click(function(){
	$('#dialog_system_search').dialog('open');
	return false;
});

$(document).ready(function(){ 
	
	defaultColspan = ($(".position-colspan").eq(0).attr("colspan"));
	$(".view-update").click(showNextPosition);
	//Dialog			
	$('.dialog_unique, .dialog_speed').dialog({
		autoOpen: false,
		width: 220,
		minHeight: 40
	});
	
});
//-->
</script>
[[endraw]]
	<a href="{action_url}" class="f12">Все проекты</a> > {projectSeo['url']}
	<div id="tabs">			
		<a href="#tab0" class="item active" >Контент</a>
		<a href="#tab1" class="item" >Еще что то</a>
	</div>
	<div id="main-container" class="tab-content" style="display:block;">
		
		
		[[for url in projectUrls]]
		<table class="project">
			<tr>
				<td class="query">
					<input type="checkbox"  class="query-checkbox" onclick="checkGroup(this,'query-checkbox-group-{url['id_project_url']}')"/>
					<a href="{url.url}" target="_blank" class="url">{url.name ? url.name : url.url }</a>
				</td>
				<td>
				</td>
				[[ for d in updateDate]]
					<td [[if loop.index < (updateCount - viewCount + nonUpdateCount)]]class="hidden-td"[[endif]]>
						<a class="update-date" href="javascript: void(0);" title="{d.update}%">{df('date','d.m',d.date)}</a> 
					</td>
				[[endfor]]
				<td colspan="2">
					[[ if url['id_project_url'] != -1]]
					<a style="margin-right:10px;" href="javascript: void(0)" onclick="$('#dialog_unique_{url['id_project_url']}').dialog('open');return false;" >
						[[for param in urlParams]]
							[[if not param.checkbox and param.name == 'unique']]
								<span id="date_title_{url['id_project_url']}_{param['id_projects_seo_url_param']}"><em class="val">{url['params'][param['id_projects_seo_url_param']]['value']}</em>% <i>{ url['params'][param['id_projects_seo_url_param']]['date'] | date('d.m')}</i></span>
							[[endif]]
						[[endfor]]
					</a>
					
					<a href="javascript: void(0)" onclick="$('#dialog_speed_{url['id_project_url']}').dialog('open');return false;">
						[[for param in urlParams]]
							[[if not param.checkbox and param.name == 'speed']]
								<span id="date_title_{url['id_project_url']}_{param['id_projects_seo_url_param']}"><em class="val">{url['params'][param['id_projects_seo_url_param']]['value']}</em> сек <i>{ url['params'][param['id_projects_seo_url_param']]['date'] | date('d.m')}</i></span>
							[[endif]]
						[[endfor]]
					 </a>
					 [[endif]]
				</td>
			</tr>
			[[for query in url['query']]]
				<tr>
					<td>
						<input type="checkbox"  class="query-checkbox query-checkbox-group-{url['id_project_url']}">
						<div class="long_link_box">
							
							<div class="long_link">
								<a href="" target="_blank" class="f14" title="{query['query']}">{query['query']}</a>															
							</div>
							<div class="long_link_hidder hidder_gray">&nbsp;</div>
						</div>
					</td>
					<td>
					</td>
					[[ for p in query['position']]]
						<td class="al-c [[if loop.index < (updateCount - viewCount + nonUpdateCount)]]hidden-td[[endif]]" >
							<span>{p.pos}</span>
						</td>
					[[endfor]]
					<td><a onclick="javascript: get_analitic(54);return false;" href="javascript: //"><img border="0" src="/images/analitic.gif" alt="анализ текста"></a></td>
					<td><input type="checkbox" id="{query['id_seo_query']}"/> <label for="{query['id_seo_query']}">норма 12.11</label></td>
				</tr>
			[[endfor]]
				<tr>
					<td>
						<a href="" target="_blank" class="f12"></a>
					</td>
					<td>
					</td>
					<td colspan="{viewCount}" class="al-r position-colspan">
						<a href="javascript: void(0);" class="view-update">еще >></a>	
					</td>
					<td colspan="2">
					</td>
				</tr>
				</table>
				[[ if url['id_project_url'] != -1]]
				<table class="url-diagnostic" id="url-diagnostic-{url['id_project_url']}">
				<tr>
					<td colspan="2">
						<ul>
							[[for param in urlParams]]
								[[if param.checkbox]]
									<li>
										<input type="checkbox" class="url_checkbox" id="chechbox_{url['id_project_url']}_{param['id_projects_seo_url_param']}_title" onclick="setParamUrl({param['id_projects_seo_url_param']},{url['id_project_url']},this.checked)" [[if url['params'][param['id_projects_seo_url_param']]['value'] ]]checked="checked" [[endif]]/>
										<label for="chechbox_{url['id_project_url']}_{param['id_projects_seo_url_param']}_title">{param['caption']}</label><span id="date_title_{url['id_project_url']}_{param['id_projects_seo_url_param']}">
											<i>[[if url['params'][param['id_projects_seo_url_param']] ]]{ url['params'][param['id_projects_seo_url_param']]['date'] | date('d.m.y')}[[endif]]</i>
											<img class="show-check" src="/images/load-checkbox.gif">
										</span>
									</li>
									[[if not loop.last and loop.index%4 == 0]]
										</ul>
										<ul>		
									[[endif]]
								[[endif]]	
							[[endfor]]
							
						</ul>

					</td>
					<td>
					</td>
				</tr>
				<tr>
					<td>
						<a href="" target="_blank" class="f12"></a>
					</td>
					<td>
					</td>
					<td class="al-c">
						<a href="javascript: void(0)" onclick="defaultAll('#url-diagnostic-{url['id_project_url']}')" class="f14">сбросить данные</a>	
					</td>
				</tr>
			</table>
			<!-- ui-dialog -->
			<div class="dialog_unique" id="dialog_unique_{url['id_project_url']}" title="Уникальность страницы" style="display:none;">
				<p align="center">
					<input type="text" size="5" name="" width="100px" id="dialog_unique_value_{url['id_project_url']}" /><br />
					<a href="http://www.content-watch.ru/" class="f14" target="_blank">content-watch.ru</a><br />
					<input type="button" id="system_search_calculation_button" value="сохранить" onclick="setParamUrl(9,{url['id_project_url']},$('#dialog_unique_value_{url['id_project_url']}').val());$('#dialog_unique_{url['id_project_url']}').dialog('close');return false;"/>
					
				</p>
			</div>
			<!-- ui-dialog -->
			<div class="dialog_speed" id="dialog_speed_{url['id_project_url']}" title="Скорость загрузки" style="display:none;">
				<p align="center">
					<input type="text" size="5" name="" width="100px" id="dialog_speed_value_{url['id_project_url']}"/><br />
					<a href="http://tools.pingdom.com/" class="f14" target="_blank">tools.pingdom.com</a><br />
					<input type="button" value="сохранить" onclick=setParamUrl(10,{url['id_project_url']},$('#dialog_speed_value_{url['id_project_url']}').val());$('#dialog_speed_{url['id_project_url']}').dialog('close');return false;"/>
					
				</p>
			</div>
		[[endif]]	
		[[endfor]]
		
	</div>
	<div id="main-container" class="tab-content">
		
	</div>
[[endblock]]