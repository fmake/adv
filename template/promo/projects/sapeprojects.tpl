[[ extends  TEMPLATE_PATH ~ "base/main_all_content.tpl" ]] 
[[ import TEMPLATE_PATH ~"macro/search_system_url.tpl" as urlMacro ]]

[[block content]]

<script type="text/javascript">
<!--
colspanPlus = {updateCount - viewCount + nonUpdateCount - 1};
[[raw]]
function addFormParam(name,value){
	$("<input/>").attr({
						type: "hidden",
						name: name
						}).val(value) 
									.appendTo("#action_form");
}

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
                if($("#group-action-add").val() != '' && $("#group-action-add-page-name").val() != ''){
                        addFormParam("group_param[url]",$("#group-action-add").val());
                        addFormParam("group_param[name]",$("#group-action-add-page-name").val()); 
    }else{
                        alert('Введите имя или адрес страницы');
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

function changeNameUrl(id){
    curObj = $('#edit_block_'+id);
    var href = $("#a_"+id).attr("href");
    var href_text = $("#a_"+id).html();
    curObj.html( ("<input type='text' id='input_"+id+"' value='"+href_text+"' />") );
    $('#input_'+id).focus().select().blur(function () {
    var name = ($(this).val());
    curObj.html('<a id="a_'+id+'" href="'+href+'" target="_blank" class="url">'+name+'</a>');
    xajax_setName(id, name);
}); 
}

function selectChange(action){
action = parseInt (action);
switch (action) {
   case 1:
           $("#group-select").css("display","inline");
           $("#group-action-add").css("display","none");
           $("#group-action-add-page-name").css("display","none");
           $("p.group-action-add-title").css("display","none");
          //alert(querysStr);
          break;
        case 2:
                $("#group-action-add").css("display","inline");
                $("#group-action-add-page-name").css("display","inline");
                $("p.group-action-add-title").css("display","block");
                $("#group-select").css("display","none");
                //alert(querysStr);
                break;
        case 3:
			
   default:
                $("#group-select").css("display","none");
                $("#group-action-add").css("display","none");
                $("#group-action-add-page-name").css("display","none");
                $("p.group-action-add-title").css("display","none");
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
[[include "promo/projects/tabs.tpl"]]
<div id="main-container" class="tab-content" style="display:block;">
	<form method="get" id="action_form_optimizer" style="padding: 20px 30px;">
		<input id="hid_field" type="hidden" name="action" value="change_optimizer" />
		<select name="id_user" onchange="$('#action_form_optimizer').submit();">
			[[ for optimizer in optimiziers ]]
				<option  [[if optimizator.id_user == optimizer.id_user]]selected[[endif]] value="{optimizer.id_user}">{optimizer.name}</option>
			[[endfor]]
		</select>
		<select name="id_project" onchange="$('#action_form_optimizer').submit();">
			[[ for current_project in current_projects ]]
			<option [[if request.id_project == current_project.id_project]]selected[[endif]] value="{current_project.id_project}">{current_project.url}</option>
			[[endfor]]
		</select>
		<br/>
		<input type="submit" name="" onclick="$('#hid_field').val('add_project_to_sape');$('#action_form_optimizer').submit();return false;" value="Добавить проект в sape" />
	</form>
			
	    [[for url in projectUrls]]
    [[if not request.id_project_url or request.id_project_url == url['id_project_url']]]

    <table class="project">
        <tr>
            <td class="query">
                    <a id="a_{url['id_project_url']}" href="{url.url}" target="_blank" class="url">{url.name ? url.name : url.url }</a>
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
            <!--td colspan="2">
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
            </td-->
        </tr>
        [[for query in url['query']]]
        <tr>
            <td>
                <div class="long_link_box">							
                    <div class="long_link">
                        <a href="{urlMacro.getUrl(query['query'],query['id_seo_search_system'])}" target="_blank" class="f14" title="{query['query']}">{query['query']}</a>															
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
                <!--a href="javascript: void(0);" class="view-update">еще >></a-->	
            </td>
            <td colspan="2">
            </td>
        </tr>
    </table>
    [[ if url['id_project_url'] != -1]]
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
    <p class="group-action-add-title">Имя: <input type="text" id="group-action-add-page-name" page_name="" /></p>
    <p class="group-action-add-title">URL: <input type="text" id="group-action-add" name="" /></p>
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
