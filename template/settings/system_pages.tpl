[[ extends  TEMPLATE_PATH ~ "base/main.tpl" ]] 

[[ macro input(name, value, type, size) ]]
    <input type="{ type|default('text') }" name="{ name }}" value="{ value|e }" size="{ size|default(20) }" />
[[ endmacro ]]

[[ import TEMPLATE_PATH ~ "macro/macro.tpl" as macros ]]

[[block left]]
	{parent()}
[[endblock]]

[[block content]]
	
	<div id="main-container" class="tab-content">
		<h1>{modul.caption}</h1>
		<h1>{modul.text|raw}</h1>
		<form acton="/{request.parents}/{request.modul}" method="GET">	
			<input type="hidden" name="action" value="new" />
			<button class="green"><div><div>Добавить</div></div></button>
		</form>
		<table class="edit-table">
			<colgroup>
				<col  /> 
				<col width="300px" />
				<col width="120px" />
			</colgroup>
			<thead>
				<tr>
					<td>
						Страница
					</td>
					<td>
						Доступы
					</td> 
					<td>
						Действие
					</td>
				</tr>
			</thead>
			<tbody>
				[[ for item in items ]]
					<tr [[if loop.index is odd]]class="odd"[[endif]]>
						<td style="padding-left:{(item.level)*30}px;">
							{item.caption}
						</td>
						<td>
							Over a year in the works, MODX: The Official Guide by Bob Ray is a 772 page reference for all things MODX. 
							in-house MODX Press and we're tremendously proud to put our name on it.
						</td>
						<td>
							<a href="/{request.parents}/{request.modul}?action=edit&id={item[itemObj.idField]}" class="link-icon" ><img src="/images/edit-icon.gif" alt="" /></a>
							<a href="/{request.parents}/{request.modul}?action=delete&id={item[itemObj.idField]}" class="link-icon" ><img src="/images/delete-icon.gif" alt="" /></a>
						</td>
					</tr>
				[[ endfor ]]
			</tbody>	
		
	</div>
[[endblock]]