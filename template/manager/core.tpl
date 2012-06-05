[[ extends "base/main.tpl" ]]

[[ block content ]]

<link rel="stylesheet" href="/styles/tablesorter/style.css" type="text/css" id="" media="print, projection, screen" />

	<div id="main-container">
		<h1>{modul.caption}</h1>
		<script type="text/javascript" src="/js/jquery.tablesorter.js"></script>
		[[raw]] 
		<script type="text/javascript" >
		checkedIds = new Array();
		startId = 0;
		
		function inArray(id){
		/*	for(var i = 0; i <checkedIds.length;i++){
				if(id == checkedIds[i])
					return true;
			}
		*/
			if(1 == checkedIds[id])
				return true;
			return false;
		}
		// если при клике не надо добавлять строку
		addGlobal = true;
		
		
		function init(){
			
			
			var table = $("#ans");
			
			$(".tablesorter tr").click(function(){
				if(!addGlobal){ 
					addGlobal = true;
				}else{
				
					if(!inArray($(this).attr("id"))){
						
							table.html(table.html()+"<tr  OnClick='if(!addGlobal){addGlobal = true;}else{rem(this);}' id='tmp"+$(this).attr("id")+"' rel='"+$(this).attr("id")+"' >"+this.innerHTML+"<input type='hidden' name='query[]' value='"+$(this).find("td").eq(0).text()+"' </tr>");
							$(this).addClass("checkrow");
							checkedIds[$(this).attr("id")] = 1;
		
					}else{
						$("#tmp"+$(this).attr("id")).remove();
						$(this).removeClass("checkrow");
						checkedIds[$(this).attr("id")] = 0;
					}
				}
			});
					
		
		}
		
		$(document).ready(function(){ 
			$(".tablesorter").tablesorter();
			init();
		
				// Dialog			
			$('#dialog_words').dialog({
				autoOpen: false,
				width: 500,
				minHeight: 40
			});

		
		}); 
		function rem(obj){
		
			$("#"+$(obj).attr('rel')).removeClass("checkrow");
			checkedIds[$(obj).attr('rel')] = 0;
			$(obj).remove();
		}
		
		function copyTable(){
			CopiedTxt = $("#ans").text();
			CopiedTxt.set;
			CopiedTxt.execCommand("Copy");
		}
		
		function hideShow(){
			$('#show_words').hide(globalWindowHide);
			$('#show_words_text').html('');
		}
		
		function getTopForContent(){
			top = (getBodyScrollTop()-200);
			if(top < 0)
				top = 0;
			return top;
		}
		
		function showWords(word){
			$('#show_words_text').html('');
			xajax_getwordStat(word,startId,'show_words_text',10,0);
			$('#dialog_words').dialog('open');
		}
		
		function showWordsCapture(word,key,value,proxy){
			countSize = parseInt( $('#contwords').val() );
			what =  parseInt( $("#what" ).val());
			xajax_getwordStatCapture(key,value,proxy,word,startId,countSize,what);
		}
		
		function showWordsSubmit(){
		
			str = ($("#wordsconteiner").val());
			countSize = parseInt( $('#contwords').val() );
			what =  parseInt( $("#what" ).val());
			var arr = str.split("\n");
			for(var i = 0;i<arr.length;i++){
				xajax_getwordStat(arr[i],startId+i*countSize,'additional',countSize,what);
			}
			return false;
		}

	

		</script> 
		[[endraw]] 
		
		
		
				<!-- ui-dialog -->
		<div id="dialog_words" title="Данные по вхождению слов" >
				<div id="show_words_text" >
						
				</div>
		</div>

		
		<table width="100%">
		<tr><td id="additional" width="100%">
		
		
		[[set id = startId ? startId : 0]]
		[[ include TEMPLATE_PATH ~ "manager/core_inner.tpl"]]
		<script>
			nextId = {id};
			//alert(nextId);
		</script>
		
		
		</td><td style="width:400px;">
		<form action="core_exactness" method="POST" >
		<input type="hidden" name="action" value="add_word_query" />
			<table id="ans" style="width:370px;"  >
				<thead>
					<tr>
						<th  >Что спросили</th>
						<th >Количество&nbsp;&nbsp;&nbsp;&nbsp;</th>
					</tr>
				</thead>
			</table>
			<input type="submit" value="Точная проверка" >  
			</form>
			</td></tr>
		</table>
		
		</td>
		</tr>
		</table>
		
			<br />
			
		<form method="post">
			<input type="hidden" name="action" value="add_word" />
			
			<table width="400">
				<tr><td>
					Количество <select name="size" id="contwords" >
								<option>50</option>
								<option>100</option>
								<option>200</option>
								<option>500</option>
								<option>1000</option>
								</select>
								<input type="checkbox" id="what" name="what" value="1" id="what" [[if request.what]]checked[[endif]] /> <label for="what" style="cursor:pointer;" > <b>- Что еще искали люди</b></label>
				</td></tr>
					<tr><td>
					
				</td></tr>
				<tr><td>
					<textarea name="word" id="wordsconteiner"  rows="9" align="left" style="width:400px;">[[if capture]]{request.word}[[endif]]</textarea>
				</td></tr>
				<tr><td align="left">
				{capture}
				<input type="submit" name="subm"  value="Получить отчет" [[if request.action == 'add_word' ]]onclick="showWordsSubmit();return false;"[[endif]] />
				</td></tr>
			</table>
			
		</form>
		
	</div>
[[ endblock ]]
