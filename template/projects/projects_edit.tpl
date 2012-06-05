
[[ extends "base/main.tpl" ]]

[[ block content ]]
[[ include TEMPLATE_PATH ~ "projects/project_query_patern.tpl"]]

<style>
	[[ raw ]]
		.edit-GroupTbl
			{border-top: 3px solid #52ACD1; background: #eee;margin-top: 20px;}
		.edit-GroupTbl-bot
			{margin-left:20px;}
		#date
			{width:260px;}
		.dop-params
			{display:none;}	
	[[endraw]]
</style>	


<script language="javascript" type="text/javascript" src="/js/scripts_projectedit.js"></script>
[[raw]]
<script>
	$(function() {
		$( "#date" ).datepicker({
			showOn: "both",
			buttonImage: "/images/calendar.gif",
			dateFormat: "dd.mm.yy",
			changeMonth: true,
			changeYear: true,
			showButtonPanel: true,
			//defaultDate: "3.11.2011",
			//buttonImageOnly: true
		});
	});
</script>
[[endraw]]


	<div id="main-container">
		{form|raw}
		<form style="margin:0px;" action="{action_url}" method="POST" name="editformquery" id="editformquery" enctype="multipart/form-data">
		<input type="hidden" value="true" name="editformSubmitIndicator">
		<table cellspacing="0" cellpadding="2" border="0" class="edit-Table edit-GroupTbl edit-GroupTbl-bot">
			<tr><td class="edit-GroupTitleCell">Запросы и бюджет</td></tr>
			<tr><td align="left">
				<table cellspacing="0" cellpadding="2" border="0">
				<tbody><tr>
				<td width="150">
				<span class="edit-Title">Бюджет SAPE</span></td>
				<td width="300">
				<input type="text" maxlength="36" size="16" value="{item['sape_money']}" name="sape_money"></td>
				</tr>
				<tr>
				<td>&nbsp;</td><td width="300">
				<span class="edit-Comment">Только цифрами</span>
				</td>
				</tr>
				</tbody></table>
			</td></tr>
			<tr><td align="left">
				<table cellspacing="0" cellpadding="2" border="0">
					<tr>
						<td width="150">
						<span class="edit-Title">Абонемент</span></td>
						<td width="300">
						<input type="text" maxlength="36" size="16" value="{item['abonement']   ? item['abonement']  : 0 }" name="abonement" id="abonement" onkeyup="maxPrice();" ></td>
					</tr>
					<tr>
						<td>&nbsp;</td><td width="300">
						<span class="edit-Comment">Только цифрами</span>
						</td>
					</tr>
				</table>
			</td></tr>
			<tr><td align="left">
				<table cellspacing="0" cellpadding="2" border="0">
				<tr>
				<td width="150">
					<span class="edit-Title">Максимальная премия</span></td>
				<td width="300">
					<b id="max-sum-site">0</b> рублей
				</td>
				</tr>
				</table>
			</td></tr>
			<tr>
				<td colspan="2"><table cellspacing="0" cellpadding="2" border="0" align="left">
					<tbody><tr>
						<td><a href="javascript: void(0);" onclick="$('.dop-params').toggle();" class="dop-params-link">Дополнительные параметры</a></td>
					</tr>
					</table>
				</td>
			</tr>
			<tr class="dop-params" >
				<td colspan="2">
					<table cellspacing="0" cellpadding="2" border="0" align="left">
					<tbody><tr>
						<td>
							<input title="Премия будет рассчитываться по порядку поисковых систем, перетащите их в нужном порядке" type="checkbox" value="1" name="consecutive_calculation" id="posl-ras" [[if item.consecutive_calculation]]checked[[endif]]>
						</td>
						<td>
							<label title="Премия будет рассчитываться по порядку поисковых систем, перетащите их в нужном порядке" for="posl-ras">последовательный расчет</label>
						</td>
					</tr>
					<tr>
						<td>
							<input title="Отметьте, если клиент платит только абонемент" type="checkbox" value="1" name="only_abonement" id="only-abonement" [[if item.only_abonement]]checked[[endif]]>
						</td>
						<td>
							<label title="Отметьте, если клиент платит только абонемент" for="only-abonement">только абонемент</label>
						</td>
					</tr>
					</tbody></table>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<h2>Поисковые системы</h2>
					<div class="search-systems">
						[[ for ssys in item['searchsystems']]]
							[[if ssys['used'] ]] 
								<div class="search-system" ><a href="javascript: void(0);" rel="{ssys['id_seo_search_system']}" >{ssys['name']}</a><input type="hidden" name="searchorder[]" value="{ssys['id_seo_search_system']}" /></div>
							[[endif]]
						[[endfor]]
							<div class="search-system-add"><a href="javascript: void(0);" id="system-search-link"><img src="/images/green-plus.png" class="f_l"/> Добавить систему</a></div>
					</div>
					[[ for ssys in item['searchsystems']]]
						[[ if ssys['child'] ]]
							<div class="regions" id="region_{ssys['id_seo_search_system']}" >
								[[for ssch in ssys['child']]]
									[[if ssch['used'] ]]
										<div class="region"><a href="javascript: void(0);" rel="{ssch['id_seo_search_system']}" >{ssch['name']}</a><input type="hidden" name="regionorder[{ssys['id_seo_search_system']}][]" value="{ssch['id_seo_search_system']}" /></div>
									[[endif]]
								[[endfor]]
								<div class="region-add"><a href="javascript: void(0);" id="region-link" class="new-region"><img src="/images/green-plus.png" class="f_l"/> Добавить регион</a></div>
							</div>
						[[endif]]
					[[endfor]]
					
					
					
					<!-- ui-dialog -->
					<div id="dialog_system_search" title="Добавление поисковой системы" style="display:none;">
						<p>
							<select id="search_system_select" >
								[[ for ssys in ssystems]]
									[[if not ssys['used'] ]]
										<option value="{ssys['id_seo_search_system']}">{ssys['name']}</option>
									[[endif]]
								[[endfor]]
								
							</select>
							<input type="button" id="system_search_calculation_button" value="добавить" onclick="addSearchSystem();return false;"/>
							
						</p>
					</div>
					
					<!-- ui-dialog -->
					<div id="dialog" title="Добавление региона" style="display:none;">
						<p>
							<select id="consecutive_calculation_select" >
								[[ for ssys in ssystems]]
											[[for ssch in ssys['child']]]
												[[if not ssch['used'] ]]
													<option value="{ssch['id_seo_search_system']}">{ssch['name']}</option>
												[[endif]]
											[[endfor]]
								[[endfor]]
								
							</select>
							<input type="button" id="consecutive_calculation_boton" value="добавить" onclick="addConsecutive();return false;"/>
							<p>&nbsp;</p>
							<p><a href="javascript: void(0);" onclick="$('#add-new-region').toggle();" id="region-link" class="new-region"><img src="/images/green-plus.png" class="f_l mr5"/> Добавить новый регион</a></p>
							<p>&nbsp;</p>
							<p id="add-new-region" style="display:none;">
								<input title="название" type="text" name="region_caption" id="region_caption_new"/> <input title="lr" type="text" name="region_lr" style="width:30px" id="region_lr_new" /> <input onclick="addConsecutiveNew();return false;" type="button" value="добавить" />
							</p>
						</p>
					</div>
				
					
					<div id="querys-tables">
					
					</div>
					
					
					<script>
						dataQuery= {'{}'};
						[[ set first = 0]]
						[[ for searchsystem,sd in data]]
							dataQuery[{searchsystem}] = {'{}'};
							[[ for region,ssd in sd]]
								dataQuery[{searchsystem}][{region}] = {'{}'};
								dataQuery[{searchsystem}][{region}]['querys'] = {'{}'};
								dataQuery[{searchsystem}][{region}]['place'] = {'{}'};
								dataQuery[{searchsystem}][{region}]['price'] = {'{}'};
								
								[[ for i,query in ssd['querys'] ]]
									dataQuery[{searchsystem}][{region}]['querys'][{i}] = {'{}'};
									dataQuery[{searchsystem}][{region}]['querys'][{i}]['query'] = '{query['query']}';
									dataQuery[{searchsystem}][{region}]['querys'][{i}]['id'] = {query['id_seo_query']};
								[[endfor]]
								
								[[ for i,place in ssd['place'] ]]
									dataQuery[{searchsystem}][{region}]['place'][{i}] = {'{}'};
									dataQuery[{searchsystem}][{region}]['place'][{i}]['from'] = '{place['from']}';
									dataQuery[{searchsystem}][{region}]['place'][{i}]['to'] = {place['to']};
									dataQuery[{searchsystem}][{region}]['place'][{i}]['id'] = {place['id_exs']};
								[[endfor]]
								
								[[ for q,price in ssd['price'] ]]
									dataQuery[{searchsystem}][{region}]['price'][{q}] = {'{}'};
									[[ for e,pr in price ]]
										[[ if pr['price'] ]]
											dataQuery[{searchsystem}][{region}]['price'][{q}][{e}] = {pr['price']};
										[[else]]
											dataQuery[{searchsystem}][{region}]['price'][{q}][{e}] = 0;
										[[endif]]
									[[endfor]]
								[[endfor]]
								
								/*инициализируем первую поисковую сиситему будто пользователь нажал на нее*/
								[[if not first ]]
									initTableData({searchsystem},{region},{df('sizeof',ssd['querys'])},{df('sizeof',ssd['place'])});
									$('.search-system A[rel={searchsystem}]').addClass('active');
									$("#region_{searchsystem}").show();
									$("#region_{searchsystem} .region A[rel={region}]").addClass('active');
									searchId = {searchsystem};
									[[ set first = 1]]
								[[else]]
									initTableData({searchsystem},{region},{df('sizeof',ssd['querys'])},{df('sizeof',ssd['place'])},false);	
								[[endif]]
								
								/*подсчитываем цены по столбцам*/
								[[ for i,place in ssd['place'] ]]
									maxMonthPrice({searchsystem},{region},{i});
								[[endfor]]
							[[endfor]]
						[[endfor]]
					</script>
					<br /><br />
				</td>
			</tr>
			<tr><td align="right" colspan="2" >

				<select name="subaction" >
					<option>Групповое действие</option>
					<option value="delete">Удалить</option>
				</select>
				<input type="submit" class="edit-SubmitButton" onclick="if (!_fp_validateEditform()) return false; else addFormContent();" value="   применить  " name="submit">
				<br /><br />
				</td>
			</tr>
		</table>
		</form>
	
		
	</div>
[[ endblock ]]
