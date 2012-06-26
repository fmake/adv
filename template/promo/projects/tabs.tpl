<div id="tabs">			
    <a href="/promo/prmprojects?id_project={request.id_project}" class="item [[if request.modul == 'prmprojects']]active[[endif]]" >Контент</a>
    <a href="/promo/sapeprojects?id_project={request.id_project}" class="item [[if request.modul == 'sapeprojects']]active[[endif]]" >Ссылки</a>
	<a href="/promo/report?id_project={request.id_project}" class="item [[if request.modul == 'report']]active[[endif]]" >Отчет</a>
</div>