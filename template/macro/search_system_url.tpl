[[ macro getUrl(query,id_search_system) ]]
   	[[if id_search_system > 0]]
		http://yandex.ru/yandsearch?text={query}&lr=213
	[[elseif id_search_system == -1]]
		http://www.google.ru/search?hl=ru&newwindow=1&biw=1600&bih=720&output=search&sclient=psy-ab&q={query}&btnG=
	[[endif]]
[[ endmacro ]]


