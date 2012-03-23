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
	checkboxClick();
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

// параметр запроса
function setParamQuery(id_param,id_query,value) {
	//alert(id_param+' '+id_query+' '+value);
	$('#query_check_'+id_query+'_'+id_param +' i').html('');
	$('#query_check_'+id_query+'_'+id_param + ' .show-check').show();
	xajax_setParamQuery(id_param,id_query,value,true);
}

function endSetQueryValue(id_param,id_query,date,value){
	$('#query_check_'+id_query+'_'+id_param +' i').html(date);
	$('#query_check_'+id_query+'_'+id_param + ' .show-check').hide();
}

// параметр урла
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


//сбросить все
function defaultAll(id) {
	$(id+ ' input[type=checkbox]:checked').attr("checked", false).click().attr("checked", false);
}


querysCheckbox = [];

function addFormParam(name,value){
	//$("#main_form");
	
	//alert(name + " = "+ value);
	$("<input/>")
		.attr({
			type: "hidden",
			name: name
		}).val(value) 
		.appendTo("#action_form");
}

function submitAction(action){
	action = parseInt ($("#group-action").val());
	$("#action_form").html(''); 
	switch (action) {
	   case 1:
			for ( var i = 0; i < querysCheckbox.length; i++) {
			   addFormParam("group_param[querys][]",querysCheckbox[i]);
			}
		   	
			addFormParam("group_param[url]",$("#group-select").val());
			addFormParam("action_group",action);
			break;
		case 2:
			
			for ( var i = 0; i < querysCheckbox.length; i++) {
			   addFormParam("group_param[querys][]",querysCheckbox[i]);
			}
			if($("#group-action-add").val() != ''){
				addFormParam("group_param[url]",$("#group-action-add").val());
			}else{
				alert('Введите адрес страницы');
				return;
			}
			addFormParam("action_group",action);
			break;
	   default:
			hideAction();
			return;
		  break;
	}
	$("#action_form").submit(); 

}


function deleteUrl(id_url){
	$("#action_form").html('');
	addFormParam("action","deleteurl");
	addFormParam("id_url",id_url);
	$("#action_form").submit(); 
}

function selectChange(action){
	action = parseInt (action);
	switch (action) {
	   case 1:
		   $("#group-select").css("display","inline");
			$("#group-action-add").css("display","none");
		  
		  //alert(querysStr);
		  break;
		case 2:
			$("#group-action-add").css("display","inline");
			  $("#group-select").css("display","none");
			//alert(querysStr);
			break;
		case 3:
			
	   default:
			$("#group-select").css("display","none");
			$("#group-action-add").css("display","none");
		  break;
	}

}
// скрыть 
function hideAction() {
	$("#group-checkbox-form-1").css('display','none');
}

// клик на секбокс запроса
function checkboxClick(){
	count = 0;
	querysCheckbox = [];
	 $(".query-checkbox").each(function(){
		if($(this).attr("checked")){
			count++;
			//querysStr += ( $(this).val() ) + ",";
			querysCheckbox.push($(this).val());
		}
	 });

	if(count){
		$("#group-checkbox-form-1").css('display','block');
		//$("#group-checkbox-form-1").dropShadow( {color: '#c3c3c3',top:-3, blur: 3} );
		$("#query-count").html(count);
	}else{
		hideAction();
	}

}



$(document).ready(function(){ 
	
	defaultColspan = ($(".position-colspan").eq(0).attr("colspan"));
	$(".view-update").click(showNextPosition);
	//Dialog			
	$('.dialog_unique, .dialog_speed').dialog({
		autoOpen: false,
		width: 220,
		minHeight: 40
	});

	$(".query-checkbox").click(checkboxClick);
	
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
			[[if not request.id_project_url or request.id_project_url == url['id_project_url']]]
		
				<table class="project">
					<tr>
						<td class="query">
							<a href="javascript: void(0)" onclick="if(confirm('Удалить?'))deleteUrl({url['id_project_url']})" title="Удалить Урл" ><img style="margin: 4px 0 0 -28px;position:absolute;" src="/images/delete_doc.gif"></a>
							<input type="checkbox"  class="query-checkbox-group" onclick="checkGroup(this,'query-checkbox-group-{url['id_project_url']}')"/>
							<a href="{url.url}" target="_blank" class="url">{url.name ? url.name : url.url }</a>
						</td>
						<td>
						</td>
						[[ for d in updateDate]]
							[[if loop.last ]]
								<td></td>
							[[else]]
								<td [[if loop.index < (updateCount - viewCount + nonUpdateCount)]]class="hidden-td"[[endif]]>
									<a class="update-date" href="javascript: void(0);" title="{d.update}%">{df('date','d.m',d.date)}</a> 
								</td>
							[[endif]]
							
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
								<input type="checkbox" value="{query['id_seo_query']}" class="query-checkbox query-checkbox-group-{url['id_project_url']}">
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
								[[if loop.last ]]
									<td class="al-c" >
										<span>
											[[set pos = query['position'][loop.index0-1].pos]]

											[[if yesterdayCheck ]]
												[[set posCur = query['position'][loop.index0-2].pos]]
											[[else]]
												[[set posCur = p.pos]]						
											[[endif]]

											[[if (pos - posCur) > 0]]
												{posCur-pos}
											[[elseif (pos - posCur) < 0 and pos!=0]]
												+{posCur-pos}
											[[elseif (pos - posCur) < 0 and pos==0]]
												-{posCur}
											[[endif]]						
											</span>
									</td>
								[[else]]
									<td class="al-c [[if loop.index < (updateCount - viewCount + nonUpdateCount)]]hidden-td[[endif]]" >
										<span>{p.pos}</span>
									</td>
								[[endif]]
							[[endfor]]
							<td>/*<a onclick="javascript: get_analitic(54);return false;" href="javascript: //"><img border="0" src="/images/analitic.gif" alt="анализ текста"></a>*/</td>
							<td id="query_check_{query['id_seo_query']}_1" >/*<input type="checkbox" id="{query['id_seo_query']}" onclick="setParamQuery(1,{query['id_seo_query']},this.checked);" [[if query['params'][1]['value'] ]]checked="checked"[[endif]] /> <label for="{query['id_seo_query']}"><i>{ query['params'][1]['date'] | date('d.m')}</i></label> <img style="margin: 4px 0px 0 10px;" src="/images/load-checkbox.gif" class="show-check">*/</td>
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
							<input type="text" size="5" name="" width="100px" id="dialog_unique_value_{url['id_project_url']}" /><br /><br />
							<a href="http://www.content-watch.ru/" class="f14" target="_blank">content-watch.ru</a><br /><br />
							<input type="button" id="system_search_calculation_button" value="сохранить" onclick="setParamUrl(9,{url['id_project_url']},$('#dialog_unique_value_{url['id_project_url']}').val());$('#dialog_unique_{url['id_project_url']}').dialog('close');return false;"/>
							
						</p>
					</div>
					<!-- ui-dialog -->
					<div class="dialog_speed" id="dialog_speed_{url['id_project_url']}" title="Скорость загрузки" style="display:none;">
						<p align="center">
							<input type="text" size="5" name="" width="100px" id="dialog_speed_value_{url['id_project_url']}"/><br /><br />
							<a href="http://tools.pingdom.com/" class="f14" target="_blank">tools.pingdom.com</a><br /><br />
							<input type="button" value="сохранить" onclick=setParamUrl(10,{url['id_project_url']},$('#dialog_speed_value_{url['id_project_url']}').val());$('#dialog_speed_{url['id_project_url']}').dialog('close');return false;"/>
							
						</p>
					</div>
				[[endif]]
		[[endif]]	
		[[endfor]]
		
	</div>
	<div id="main-container" class="tab-content">
	</div>
[[endblock]]


[[ block bot ]]
<div id="group-checkbox-form-1" class="group-checkbox-form" >
	<div onclick="hideAction();" class="close-action"></div>
	<div class="caption-check">Выбрано запросов: <span id="query-count">0</span></div>
	<select onchange="selectChange(this.value);" id="group-action" class="select">
		<option value="0">Действие</option>
		<option value="1">Добавить запросы к странице</option>
		<option value="2">добавить запросы к новой странице</option>
	</select>
	<input type="text" id="group-action-add" name="">  
		<select id="group-select" class="select">
			[[for url in projectUrls]]
				[[ if url['id_project_url'] > 0]]
					<option value="{url['id_project_url']}">{url.name ? url.name : url.url }</option>
				[[endif]]
			[[endfor]]
		</select>
		<input type="submit" onclick="submitAction()" id="sumbit-group" value="Выполнить">  
</div>		
<form method="post" id="action_form">

</form>
[[ endblock ]]
