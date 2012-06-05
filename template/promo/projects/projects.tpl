[[ extends  TEMPLATE_PATH ~ "base/main.tpl" ]] 


[[block left]]
<h2>Проекты</h2>
<ul>
    <li><a [[if not request.getFilter('status')]]class="active"[[endif]] href="{action_url}?{request.writeFilter('status')}">Все</a></li>
    <li><a [[if request.getFilter('status') == 'newproject']]class="active"[[endif]] href="{action_url}?{request.writeFilter('status')}&filter[status]=newproject" >Новые</a></li>
    <li><a [[if request.getFilter('status') == 'important']]class="active"[[endif]] href="{action_url}?{request.writeFilter('status')}&filter[status]=important">Приоритетные</a></li>
    <li><a [[if request.getFilter('status') == 'archive']]class="active"[[endif]] href="{action_url}?{request.writeFilter('status')}&filter[status]=archive">Архив</a></li>
</ul>
[[ if user.role == ID_ADMINISTRATOR]]
<br />
<h4>Оптимизаторы</h4>
<ul>
    <li><a [[if request.getFilter('id_user') == 0]]class="active"[[endif]] href="{action_url}?{request.writeFilter('id_user','userrole')}">Все</a></li>
    [[ for usr in promos]]
    <li><a [[if request.getFilter('id_user') == usr['id_user'] ]]class="active"[[endif]] href="{action_url}?{request.writeFilter('id_user')}&filter[id_user]={usr['id_user']}">{usr['name']}</a></li>
    [[endfor]]
</ul>
<br /><hr /> 
[[endif]]
{parent()}
[[endblock]]

[[block content]]

<div id="main-container">
    <script type="text/javascript" src="/js/jquery.tablesorter.js"></script>
    [[ raw ]]
    <script type="text/javascript" >

    function importantProject(project,obj){
            if($(obj).hasClass("star")){
			
                     $(obj).stop().fadeTo("slow", 0, function() { 
                                    $(obj).removeClass("star").addClass("star-hide");
        }).fadeTo("slow", 1);
                     $(obj).find("img").attr("title","Сделать избранным");
                    xajax_importantProject(project,0);
                    //$("#group_caption").append( $("#"+captionId) );
            }else if($(obj).hasClass("star-hide")){
                     $(obj).stop().fadeTo("slow", 0, function() { 
                             $(obj).removeClass("star-hide").addClass("star");
        }).fadeTo("slow", 1);
                     $(obj).find("img").attr("title","Убрать из избранного");
                    xajax_importantProject(project,1);
                    //$("#group_caption").prepend( $("#"+captionId) );
            }
		
    }
	
    function get_data(node){
            var str = node.innerHTML;
            return (jQuery.trim($(node).text()));
        }
	
    $(document).ready(function(){ 
            $(".promo-table").tablesorter({
                            textExtraction: get_data,
                            selectorHeaders: "thead tr td",
                            cssAsc: 'asc',
                            cssDesc: 'desc',
                            cssHeader: 'sortable',
                            sortList: [[1,0]],
                    headers: {0: { sorter: false},3: {sorter: false},5: {sorter: false }}
            });
			
});  
    </script>
    [[endraw]]
    <div class="message">
        <img border="0" alt="Апдейты поисковых систем" src="/cron/update.php?key=55ef35a83bb24ac9b4d959a1f1239aea">
        <span style="padding: 0 30px;font-size:22px;">{todayPercent}% [[if todayPercent - yesterdayPercent > 0]](+{todayPercent - yesterdayPercent})[[elseif (todayPercent - yesterdayPercent) < 0]]({todayPercent - yesterdayPercent})[[endif]]</span>
        <span style="padding: 0 30px;" class="f14">{monthPay} [[if monthPay - yesterdayMonthPay > 0]](+{monthPay - yesterdayMonthPay})[[elseif monthPay - yesterdayMonthPay < 0]]({monthPay - yesterdayMonthPay})[[endif]] руб.</span>
        <span style="padding: 0 30px;" class="f14">{surpricepay} руб.</span>
        <span style="padding: 0 30px;font-size:22px;">{monthPay + surpricepay} руб.</span>
    </div>


    <table class="edit-table promo-table" style="width: 900px;">
        <colgroup>
            <col width="25%">
            <col width="15%">
            <col width="10%">
            <col width="10%">
            <col>
            <col>
            <col>
            <col>
        </colgroup>
        <thead>
            <tr>
                <td>Проекты</td>
                <td class="al-r" colspan="2">Результат</td>
                <td class="al-c">L</td>
                <td class="al-c" >Позиции</td>
                <td class="al-c">Премия</td>
                <td class="al-r" style="padding-right: 15px;">Уведомления</td>
            </tr>
        </thead>
        <tbody>
            [[ for pr in userProjects]]
            <tr >
                <td>

                    <span class="important [[if pr['important']]]star[[else]]star-hide[[endif]]" onclick="importantProject({pr['id_project']},this)" ><img title="сделать избранным" src="/images/spacer.gif" /></span>
                    <a href="{action_url}?id_project={pr['id_project']}">{pr['url']}</a></td>
                <td class="al-r">{pr['seo_percent']}%</td>
                <td class="changes">
                    [[if pr['seo_percent'] - pr['seo_percent_yesterday'] > 0 ]]
                    <img width="14" height="16" border="0" alt="Повышение позиций на {pr['seo_percent'] - pr['seo_percent_yesterday']}" src="/images/up.gif"><span>{pr['seo_percent'] - pr['seo_percent_yesterday']}%</span>
                    [[elseif pr['seo_percent'] - pr['seo_percent_yesterday'] < 0]]
                    <img width="14" height="16" border="0" alt="Понижение позиций на {pr['seo_percent'] - pr['seo_percent_yesterday']}" src="/images/down.gif"><span>{pr['seo_percent'] - pr['seo_percent_yesterday']}%</span>
                    [[endif]]

                </td>
                <td class="al-r"><span title="из {pr['sape_money']} руб.">{pr['sape_percent']}%</span></td>
                <td class="al-r">{pr['change']['today']}
                    [[if pr['change']['today'] != pr['change']['yesterday'] ]] 
                        ([[if (pr['change']['yesterday']-pr['change']['today']) > 0]]+[[endif]]{pr['change']['yesterday']-pr['change']['today']}) 
                    [[endif]]</td>
                <td class="al-r">{pr['seo_pay']}</td>
                <td  style="padding-right: 15px;">
                    <img alt="WM_ID" title="WM_ID" src="/images/errors/3.gif">
                    <img alt="Liveinternet" title="Liveinternet" src="/images/errors/1.gif">
                </td>
            </tr>
            [[endfor]]
        </tbody>
    </table>

</div>
[[endblock]]
