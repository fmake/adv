<div id="exs-pattern" style="display:none;">
	<table><tr class="tr-pattern">
		<td align="center">
		   <input value="\$id_val\" type="hidden" name="data[\$search_system_id\][\$search_system_region_id\][place][\$exs_num\][id]" class="query">
		 с <input value="\$from_val\" title="Правило для позиции сайта с" type="text" name="data[\$search_system_id\][\$search_system_region_id\][place][\$exs_num\][from]" class="exs"> по <input value="\$to_val\" title="Правило для позиции сайта по" type="text"  name="data[\$search_system_id\][\$search_system_region_id\][place][\$exs_num\][to]" class="exs">           
		</td>
	</tr>
	</table>
</div>

<div id="price-pattern" style="display:none;">
		<table><tr class="tr-pattern">
			<td align="right">
			 <input title="цена запроса по правилу" value="\$price_val\" class="price exs-\$exs_num\" onkeyup="maxMonthPrice(\$search_system_id\,\$search_system_region_id\,\$exs_num\)" type="text" name="data[\$search_system_id\][\$search_system_region_id\][price][\$row_num\][\$exs_num\]" >           
			</td>
		</tr>
		</table>
</div>

<div id="query-pattern" style="display:none;">
		<table><tr class="query-tr">
			<td><input class="checkbox_\$search_system_id\_\$search_system_region_id\" title="отметить для группового действия" type="checkbox" name="data[\$search_system_id\][\$search_system_region_id\][action][\$row_num\]" /></td>
			<td>
				<input value="\$id_val\" type="hidden" name="data[\$search_system_id\][\$search_system_region_id\][querys][\$row_num\][id]" class="query">
				<input value="\$query_val\" title="запрос" type="text" name="data[\$search_system_id\][\$search_system_region_id\][querys][\$row_num\][query]" class="query">
			</td>
			<td></td>
		</tr>
		</table>
</div>


<div id="table-query-pattern" style="display:none;">
	<table class="querys" id="querys_\$search_system_id\_\$search_system_region_id\">
		<tr class="first-tr">
			<td><input type="checkbox" onclick="chekAllItems(\$search_system_id\,\$search_system_region_id\);return false;" /></td>
			<td>
				Поисковые фразы
			</td>
			<td><a href="javascript: void(0);" onclick="addCol(\$search_system_id\,\$search_system_region_id\);" title="Добавить еще правило"><img src="/images/green-plus.png" class="f_l"/></a></td>
		</tr>
		<tr class="last-tr">
			<td></td>
			<td>
				<a href="javascript: void(0);" onclick="addRowNum(\$search_system_id\,\$search_system_region_id\,5);" title="Добавить еще 5 запросов" class="plus-query"><img src="/images/green-plus.png" class="f_l"/> Добавить еще 5 запросов</a>
				<p>&nbsp;</p>
				<a href="javascript: void(0);" class="new-region" onclick="$('#file_\$search_system_id\_\$search_system_region_id\').show();$(this).remove()">Загрузить из exel</a>
				<input type="file" name="file[\$search_system_id\][\$search_system_region_id\]" style="display:none;" id="file_\$search_system_id\_\$search_system_region_id\"/>
				<br/>
				<a href="/images/examplequerys.xls" target="_blank" >пример</a>
			</td>
			<td></td>
		</tr>
	</table>
</div>

<div id="region-pattern"  style="display:none;">
	<div class="region"><a href="javascript: void(0);" rel="\$region_id\" >\$region_name\</a><input type="hidden" name="regionorder[\$search_id\][]" value="\$region_id\" /></div>
</div>

<div id="search-system-pattern"  style="display:none;">
	<div class="search-system" ><a href="javascript: void(0);" rel="\$search_id\" >\$search_name\</a><input type="hidden" name="searchorder[]" value="\$search_id\" /></div>
</div>
