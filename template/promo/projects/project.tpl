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


$(document).ready(function(){ 
	
	defaultColspan = ($(".position-colspan").eq(0).attr("colspan"));
	$(".view-update").click(showNextPosition);
	
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
						<a class="update-date" href="javascript: void(0);" title="12%">{d|date('d.m')}</a> 
					</td>
				[[endfor]]
				<td colspan="2">
					<a href="">0% 14.12</a>
					<a href="">2.35 сек</a>
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
				<table class="url-diagnostic">
				<tr>
					<td >
						<ul>
							<li><input type="checkbox" class="url_checkbox" id="chechbox_{url['id_project_url']}_title"/><label for="chechbox_{url['id_project_url']}_title">Точное вхождение ключевиков в тайтл</label> <span id="date_title_{url['id_project_url']}"></span></li>
							<li><input type="checkbox" class="url_checkbox" id="chechbox_{url['id_project_url']}_title" /><label>Наличие неточных вхождений</label> <span id="date_title_{url['id_project_url']}"></span></li>
							<li><input type="checkbox" class="url_checkbox" id="chechbox_{url['id_project_url']}_title" /><label>Наличие заголовков</label> <span id="date_title_{url['id_project_url']}"></span></li>
							<li><input type="checkbox" class="url_checkbox" id="chechbox_{url['id_project_url']}_title" /><label>Наличие метатегов</label> <span id="date_title_{url['id_project_url']}"></span></li>
						</ul>
					</td>
					<td>
						<ul>
							<li><input type="checkbox" class="url_checkbox" id="chechbox_{url['id_project_url']}_title"/><label for="chechbox_{url['id_project_url']}_title">Пересечение тегов a и H</label> <span id="date_title_{url['id_project_url']}"></span></li>
							<li><input type="checkbox" class="url_checkbox" id="chechbox_{url['id_project_url']}_title" /><label>Количество заголовков h1</label> <span id="date_title_{url['id_project_url']}"></span></li>
							<li><input type="checkbox" class="url_checkbox" id="chechbox_{url['id_project_url']}_title" /><label>Наличие списков</label> <span id="date_title_{url['id_project_url']}"></span></li>
							<li><input type="checkbox" class="url_checkbox" id="chechbox_{url['id_project_url']}_title" /><label>Наличие мусора в коде</label> <span id="date_title_{url['id_project_url']}"></span></li>
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
						<a href="" class="f14">сбросить данные</a>	
					</td>
				</tr>
			</table>	
		[[endfor]]
		
	</div>
	<div id="main-container" class="tab-content">
		
	</div>
[[endblock]]