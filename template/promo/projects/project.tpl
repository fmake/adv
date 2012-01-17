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
	<a href="{action_url}" class="f12">Все проекты</a> > {projectSeo['url']}
	<div id="tabs">			
		<a href="#tab0" class="item active" >Контент</a>
		<a href="#tab1" class="item" >Еще что то</a>
	</div>
	<div id="main-container" class="tab-content" style="display:block;">
		
	</div>
	<div id="main-container" class="tab-content">
		
	</div>
[[endblock]]