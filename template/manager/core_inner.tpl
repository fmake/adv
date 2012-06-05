[[set id = startId ? startId : 0]]

[[if report]]
	[[for start,rep in report ]] 
		[[if rep['capture']]]
			<span id="{rep['capture']['key']}">
			По запросу "{rep['query']}" капча <br />
			<img src="{rep['capture']['img']}" /><br />
			<input type="text" id="capture-{rep['capture']['key']}" /> <input type="submit" value="отправить" onclick="showWordsCapture('{rep['query']}','{rep['capture']['key']}',$('#capture-{rep['capture']['key']}').val(),'{rep['capture']['proxy']}');" /> <br />
			</span>
			{continue}
		[[endif]]
	
		[[if rep[0]['query_first'] and rep['capture'] ]]
			По запросу "{rep['query']}" 
			{continue}
		[[endif]]
		<table width="90%" ><tr><td >
			<b>{rep['query']}</b></td></tr>
		<tr><td>
		[[if rep[0]['query_first']]]
		<table  class="tablesorter" id="sorter">
			<thead>
				<tr>
					<th >{rep['query']}</th>
					<th style="width:150px;">Количество{'&nbsp;&nbsp;&nbsp;&nbsp;'}</th>
				</tr>
			</thead>
		<tbody>
		[[for i in range(0, count_word)]]
				[[set id = id + 1]]
				[[if rep[i]['query_first']]]
					<tr id="{id}">			
						<td>
							<a target="_blank" onclick="addGlobal=false;" href="http://yandex.ru/yandsearch?text={df('htmlspecialchars',rep[i]['query_first'])}&lr=213&stpar2;=%2Fh1%2Ftm2%2Fs2&stpar4;=%2Fs2&stpar1;=%2Fu0" >{rep[i]['query_first']}</a>
							<a href="javascript: void(0);" onclick="addGlobal=false;showWords('{rep[i]['query_first']}');return false;" ><img src="/images/application_form.png" title="подобрать по этому слову" alt="еще" /></a>
						</td>  
						<td>{rep[i]['count_first']}</td>
					</tr>
				[[endif]]
		[[endfor]]
		</tbody>
		</table>
		[[endif]]
[[if what]]
	[[if rep[0]['query_second'] ]]
		Искали вместе <b>{rep['query']}</b>
		
		<table class="tablesorter" id="sorter">
			<thead>
				<tr >
					<th>{rep['query']}</th>
					<th style="width:150px;" >Количество{'&nbsp;&nbsp;&nbsp;&nbsp;'}</th>
				</tr>
			</thead>
		[[for i in range(0, count_word)]]
				[[set id = id + 1]]
				[[if rep[i]['query_second']]]
					<tr id="{id}">
						<td>
							<a target="_blank" onclick="addGlobal=false;" href="http://yandex.ru/yandsearch?text={df('htmlspecialchars',rep[i]['query_second'])}&lr=213&stpar2;=%2Fh1%2Ftm2%2Fs2&stpar4;=%2Fs2&stpar1;=%2Fu0" >{rep[i]['query_second']}</a>
							<a href="javascript: void(0);" onclick="addGlobal=false;showWords('{rep[i]['query_second']}');return false;" ><img src="/images/application_form.png" title="подобрать по этому слову" alt="еще" /></a>
						
						</td>
						<td>{rep[i]['count_second']}
					</td>
					</tr>
				[[endif]]
		[[endfor]]
		</table>
		[[endif]]
			</td>
[[endif]]
	</table>
	[[endfor]]

[[endif]]

<script>
	startId = {id}{';'}
</script>
