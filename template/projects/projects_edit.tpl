
[[ extends "base/main.tpl" ]]

[[ block content ]]
[[ include TEMPLATE_PATH ~ "projects/project_query_patern.tpl"]]
<link type="text/css" href="/styles/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
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

<script language="javascript" type="text/javascript" src="/js/jquery-ui-1.8.16.custom.min.js"></script>
<script language="javascript" type="text/javascript" src="/js/jquery.ui.datepicker-ru.js"></script>
[[raw]]
<script>
	$(function() {
		$( "#date" ).datepicker(
			{
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
		
		<table cellspacing="0" cellpadding="2" border="0" class="edit-Table edit-GroupTbl edit-GroupTbl-bot">
			<tr><td class="edit-GroupTitleCell">Запросы и бюджет</td></tr>
			<tr><td align="left">
				<table cellspacing="0" cellpadding="2" border="0">
				<tbody><tr>
				<td width="150">
				<span class="edit-Title">Бюджет SAPE</span></td>
				<td width="300">
				<input type="text" maxlength="36" size="16" value="" name="sape_bud"></td>
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
						<input type="text" maxlength="36" size="16" value="" name="abonement"></td>
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
					<b>35 400</b> рублей
				</td>
				</tr>
				</table>
			</td></tr>
			<tr>
				<td colspan="2"><table cellspacing="0" cellpadding="2" border="0" align="left">
					<tbody><tr>
						<td><a href="javascript: void(0);" onclick="$('.dop-params').toggle();">Дополнительные параметры</a></td>
					</tr>
					</table>
				</td>
			</tr>
			<tr class="dop-params" >
				<td colspan="2">
					<table cellspacing="0" cellpadding="2" border="0" align="left">
					<tbody><tr>
						<td>
							<input type="checkbox" value="1"  name="inmenu" id="posl-ras">
						</td>
						<td>
							<label for="posl-ras">последовательный расчет</label>
						</td>
					</tr>
					</tbody></table>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<h2>Поисковые системы</h2>
					<div class="search-systems">
						<div class="search-system" >
							<a href="javascript: void(0);" rel="1" >Яндекс</a></div><div class="search-system" >
							<a href="javascript: void(0);" rel="2">Google</a>
						</div>
					</div>
					<div class="regions" id="region_1" >
						<div class="region"><a href="javascript: void(0);" rel="2" >Москва</a></div>
						<div class="region"><a href="javascript: void(0);" rel="3" >Санкт-Петербург</a></div>
						<div class="region"><a href="javascript: void(0);" rel="4" >Иваново</a></div>
						<div class="region"><a href="javascript: void(0);" class="new-region"><img src="/images/green-plus.png" class="f_l"/> Добавить регион</a></div>
					</div>
					
					<div id="querys-tables">
					
					</div>
					
					[[raw]]
					<script>
						//initTableData(3,2);
						//initTableData(2,1);
						
					</script>
					[[endraw]]
					<br /><br />
				</td>
			</tr>
			
		</table>
		

		
	</div>
[[ endblock ]]