[[ include TEMPLATE_PATH ~ "blocks/header.tpl"]]

<body onload="showRegPopup();">
	<!-- PAGE -->
	<div id="page">
		<div class="p-inner">
			<div class="downback">
				<div class="centerback">
					<div id="head">
						[[if modul.index]]
							<span id="logo"></span>
						[[else]]
							<a href="/" title="На главную"><span id="logo"></span></a>
						[[endif]]
						<div id="phone">
							<div class="img"></div>
							<span><i>{configs.phone1}</i>
							</span>
						</div>
						<div id="skype">
							<span class="img"></span>
							<div>
								[[if configs.skype]]<i>Skype:<a href="skype:{configs.skype}?call" style="margin: 0 0 0 3px;">{configs.skype}</a></i>[[endif]]
								<p>
									<a href="mailto:{configs.email}">{configs.email}</a>
								</p>
							</div>
						</div>
						<span id="logreg">
							[[if user.id]]
								<a href="#" style="text-transform: none;" onclick="return false;">{userinfo.email}</a><br/><a href="/?action=logout">Выход</a>
							[[else]]
								<a href="#" id="buttonlogin" onclick="return false;">Вход</a> или <a id="buttonreg" href="#" onclick="return false;">регистрация</a>
							[[endif]]
						</span>

						<div class="menu">
							[[ include TEMPLATE_PATH ~ "blocks/menu.tpl"]]
						</div>
					</div>
					<div id="content">
						[[block content]]
						
						<p>Косметика компании Oriflame — это прекрасная возможность хорошо выглядеть, не тратя при этом лишних средств. Компания предлагает широчайший ассортимент средств по уходу за волосами и кожей для людей любого возраста. Натуральная шведская косметика великолепно сочетает в себе последние достижения науки с вековой мудростью природы. В состав кремов входят такие активные компоненты, как молоко, мёд, пчелиный воск и ланолин.</p>
						
						[[ include TEMPLATE_PATH ~ "blocks/leftblock.tpl"]]


						<div id="mid">
							{modul.text|raw}
							[[if catalog]]
							<h2>Наши каталоги:</h2>
							<table class="tableblocks">
								<tbody>
									<tr>
										[[for cat in catalog]]
										<td>
											<div class="block">
												<a href="/catalog-oriflame/{cat.id}/">
													<div style="background-image: url(/images/catalog/{cat.id}/mini{cat.image})" class="img">
														<div>&nbsp;</div>
													</div>
												</a>
												<div class="info">
													<a href="/catalog-oriflame/{cat.id}/"><span>{cat.caption}</span></a>
													<div>[[if cat.iscatalog]]<a href="/images/catalog/{cat.id}/catalog.pdf" class="link_download_pdf" target="_blank">(скачать каталог *.pdf)</a>[[else]]&nbsp;[[endif]]</div>
												</div>
											</div>
										</td>
										[[endfor]]
										</tr>
								</tbody>
							</table>
							[[endif]]
							[[if action]]
							<h2>Наши акции:</h2>
							<table class="tableblocks">
								<tbody>
									<tr>
										[[for cat in action]]
										<td>
											<div class="block">
												<a href="/akcii/{cat.redir}/{cat.id}/">
													<div style="background-image: url(/images/actions/{cat.id}/mini{cat.image})" class="img">
														<div>&nbsp;</div>
													</div>
												</a>
												<div class="info">
													<a href="/akcii/{cat.redir}/{cat.id}/"><span>{cat.caption}</span></a>
													<div>{cat.anotaciya|raw}</div>
												</div>
											</div>
										</td>
										[[endfor]]
									</tr>
								</tbody>
							</table>
							[[endif]]
						</div>
						<div class="clearing"></div>
						<div class="columns">
							{compile(configs.text_index_bottom,_context)}
						</div>
							{configs.main_text_floor|raw}
						[[endblock]]
						<div style="clear: both;"></div>
					</div>
					<div id="footer">
						<div id="f-inner">
							<div id="socialfoot">
								[[if configs.facebook]]<a href="{configs.facebook}" target="_blank" class="facebook">&nbsp;</a>[[endif]] 
								[[if configs.twitter]]<a href="{configs.twitter}" target="_blank" class="twitter">&nbsp;</a>[[endif]] 
								[[if configs.youtube]]<a href="{configs.youtube}" target="_blank" class="youtube">&nbsp;</a>[[endif]]
							</div>
							
							<div class="f-cr">
								
								[[if modul.index]]	
									<a href="http://www.future-group.ru/">Создание сайтов</a>
								[[else]]
									Создание сайтов
								[[endif]] &mdash; Future-Group.ru
								
								<!--LiveInternet counter--><script type="text/javascript"><!--
							document.write("<a href='http://www.liveinternet.ru/click' "+
							"target=_blank><img src='//counter.yadro.ru/hit?t44.1;r"+
							escape(document.referrer)+((typeof(screen)=="undefined")?"":
							";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
							screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
							";"+Math.random()+
							"' alt='' title='LiveInternet' "+
							"border='0' width='31' height='31' class='livintr'><\/a>")
							//--></script><!--/LiveInternet-->
							</div>
						</div>
					</div>


				</div>
			</div>
		</div>
	</div>
	<!-- PAGE -->
	<div id="current"></div>
	[[if not user.id]]
		<div id="getpasswordpopup" >
			<div class="popup">
				<div class="down">
					<div class="center">
						<div class="close"><img src="/images/exit.png"></div>
						<div class="header">Востановление пароля</div>
						<form id="loginform" method="post">
							<input type="hidden" name="action" value="getpassword">
							<p class="error">{error_getpass.email}</p>
							<table>
								<tr>
									<td class="first"><span>Email</span></td>
									<td><input type="text" class="fieldfocus [[if error_getpass.email]]error[[endif]]" name="email" value="[[if request.email]]{request.email}[[else]]Ваш Email[[endif]]" title="Ваш Email"/></td>
								</tr>
								<tr>
									<td></td>
									<td>
										<button id="buttonsend"></button></td>
								</tr>
							</table>
						</form>
					</div>
				</div>
			</div>
		</div>
		
		<div id="hiddenModalContent" >
			<div class="popup">
				<div class="down">
					<div class="center">
						<div class="close"><img src="/images/exit.png"></div>
						<div class="header">Вход в личный кабинет</div>
						<form id="loginform" method="post">
							<input type="hidden" name="action" value="login">
							<p class="error">{error_log.password}</p>
							<table>
								<tr>
									<td class="first"><span>Email</span></td>
									<td><input type="text" class="fieldfocus" name="email" value="Ваш Email" title="Ваш Email"/></td>
								</tr>
								<tr>
									<td class="first"><span>Пароль</span></td>
									<td><input type="password" class="fieldfocus" name="password" value="" title="Пароль"  /></td>
								</tr>
								<tr>
									<td></td>
									<td class="greenright"><a href="#" onclick="return false;" id="confirm_getpass" class="m5px">я забыл
											пароль</a></td>
								</tr>
								<tr>
									<td></td>
									<td class="greenright"><a href="/registracija/" id="confirm_reg" onclick="return false;">регистрация на сайте</a>
									</td>
								</tr>
								<tr>
									<td></td>
									<td>
										<button id="buttonlog"></button></td>
								</tr>
							</table>
						</form>
					</div>
				</div>
			</div>
		</div>
		
		
		<div id="hiddenreg">
			<div id="reg">
				<div class="down">
					<div class="center">
						<div class="close"><img src="/images/exit.png"></div>
						<div class="header">Регистрация на сайте www.oriflame.ru</div>
						[[if num_formreg==1]]
							<form id="regform" method="post">
								<input type="hidden" id="num_formreg" name="num_formreg" value="1">
								<input type="hidden" name="action" value="registration">
								<input type="hidden" id="ya_hochu" name="ya_hochu" value="{request.ya_hochu}">
								<div class="green">
									Я хочу <span><a rel="economit" href="#" [[if request.ya_hochu=='economit']]class="active"[[endif]] onclick="return false;">Экономить</a>
									</span> 
									<span class="sep"></span> <a rel="raspostronyat" href="#" [[if request.ya_hochu=='raspostronyat']]class="active"[[endif]] onclick="return false;" >Рекомендовать</a> 
									<span class="sep"></span> <a rel="biznes" href="#" [[if request.ya_hochu=='biznes']]class="active"[[endif]] onclick="return false;" >Вести бизнес</a>
									<span class="ya_hochu_param" id="_economit">{configs.economit}</span>
									<span class="ya_hochu_param" id="_raspostronyat">{configs.raspostronyat}</span>
									<span class="ya_hochu_param" id="_biznes">{configs.biznes}</span>
								</div>
								<div class="black">Мои персональные данные:</div>
								<table>
									<tr>
										<td class="first"><span>Меня зовут</span></td>
										<td><input type="text" class="fieldfocus [[if error_reg.fio]]error[[endif]]" name="fio" value="[[if request.fio]]{request.fio}[[else]]Ваше ФИО[[endif]]" title="Ваше ФИО"/></td>
									</tr>
									<tr>
										<td class="first"><span>Я родился</span></td>
										<td><input type="text" class="fieldfocus [[if error_reg.date]]error[[endif]]" name="date" value="[[if request.date]]{request.date}[[else]]Ваша дата рождения[[endif]]" title="Ваша дата рождения"/></td>
									</tr>
									<tr>
										<td class="first"><span>Мои данные</span></td>
										<td><input type="text" class="fieldfocus [[if error_reg.pasport]]error[[endif]]" name="pasport" value="[[if request.pasport]]{request.pasport}[[else]]Серия и номер паспорта[[endif]]" title="Серия и номер паспорта"/></td>
									</tr>
								</table>
								<div class="black">Связаться со мной можно</div>
								<table>
									<tr>
										<td class="first"><span>По электронной почте</span></td>
										<td><input type="text" class="fieldfocus [[if error_reg.email]]error[[endif]]" name="email" value="[[if request.email]]{request.email}[[else]]Ваш Email[[endif]]" title="Ваш Email"/></td>
									</tr>
									<tr>
										<td class="first"><span class="or">или</span>
										</td>
										<td></td>
									</tr>
									<tr>
										<td class="first"><span>По телефону</span></td>
										<td><input type="text" class="fieldfocus [[if error_reg.phone]]error[[endif]]" name="phone" value="[[if request.phone]]{request.phone}[[else]]Ваш телефон[[endif]]" title="Ваш телефон"/></td>
									</tr>
								</table>
								<div class="black">Я проживаю</div>
								<table>
									<tr>
										<td class="first"><span>По адресу</span></td>
										<td><input type="text" class="fieldfocus [[if error_reg.adres]]error[[endif]]" name="adres" value="[[if request.adres]]{request.adres}[[else]]Ваш фактический адрес[[endif]]" title="Ваш фактический адрес"/></td>
									</tr>
								</table>
								<button id="buttonsend"></button>
							</form>
						[[else]]
							<form id="regform" method="post">
								<input type="hidden" id="num_formreg" name="num_formreg" value="2">
								<input type="hidden" name="action" value="registration">
								<input type="hidden" id="ya_hochu" name="ya_hochu" value="{request.ya_hochu}">
								<div class="green">
									Я хочу <span><a rel="economit" href="#" [[if request.ya_hochu=='economit']]class="active"[[endif]] onclick="return false;">Экономить</a>
									</span> 
									<span class="sep"></span> <a rel="raspostronyat" href="#" [[if request.ya_hochu=='raspostronyat']]class="active"[[endif]] onclick="return false;" >Рекомендовать</a> 
									<span class="sep"></span> <a rel="biznes" href="#" [[if request.ya_hochu=='biznes']]class="active"[[endif]] onclick="return false;" >Вести бизнес</a>
									<span class="ya_hochu_param" id="_economit">{configs.economit}</span>
									<span class="ya_hochu_param" id="_raspostronyat">{configs.raspostronyat}</span>
									<span class="ya_hochu_param" id="_biznes">{configs.biznes}</span>
								</div>
								<div class="black">Мои персональные данные:</div>
								<table>
									<tr>
										<td class="first"><span>Меня зовут</span></td>
										<td><input type="text" class="fieldfocus [[if error_reg.fio]]error[[endif]]" name="fio" value="[[if request.fio]]{request.fio}[[else]]Ваше ФИО[[endif]]" title="Ваше ФИО"/></td>
									</tr>
									<tr>
										<td class="first"><span>Я родился</span></td>
										<td><input type="text" class="fieldfocus [[if error_reg.date]]error[[endif]]" name="date" value="[[if request.date]]{request.date}[[else]]Ваша дата рождения[[endif]]" title="Ваша дата рождения"/></td>
									</tr>
								</table>
								<div class="black">Связаться со мной можно</div>
								<table>
									<tr>
										<td class="first"><span>По электронной почте</span></td>
										<td><input type="text" class="fieldfocus [[if error_reg.email]]error[[endif]]" name="email" value="[[if request.email]]{request.email}[[else]]Ваш Email[[endif]]" title="Ваш Email"/></td>
									</tr>
									<tr>
										<td class="first"><span class="or">или</span>
										</td>
										<td></td>
									</tr>
									<tr>
										<td class="first"><span>По телефону</span></td>
										<td><input type="text" class="fieldfocus [[if error_reg.phone]]error[[endif]]" name="phone" value="[[if request.phone]]{request.phone}[[else]]Ваш телефон[[endif]]" title="Ваш телефон"/></td>
									</tr>
								</table>
								<button id="buttonsend"></button>
							</form>
						[[endif]]
					</div>
				</div>
			</div>
		</div>
		[[if error_log]]
			[[raw]]
				<script>
					$("#hiddenModalContent").css("top",getBodyScrollTop()+30);
					$('#current,#hiddenModalContent').show();
				</script>
			[[endraw]]
		[[endif]]
		[[if error_reg]]
			[[raw]]
				<script>
					$("#hiddenreg").css("top",getBodyScrollTop()+30);
					$('#current,#hiddenreg').show();
				</script>
			[[endraw]]
		[[endif]]
		[[if error_getpass]]
			[[raw]]
				<script>
					$("#getpasswordpopup").css("top",getBodyScrollTop()+30);
					$('#current,#getpasswordpopup').show();
				</script>
			[[endraw]]
		[[endif]]
	[[endif]]	
	[[if _messages]]
		[[raw]]
			<script>
				$('#_message, #current').show();
			</script>
		[[endraw]]
		<div id="_message">
			<div class="popup" id="login" style="position: absolute; top: 20%; left: 28%;">
				<div class="down">
					<div class="center">
						<div class="close"><img src="/images/exit.png"></div>
						<div class="header">{_messages.title}</div>
						<div class="text_message">{_messages.text|raw}</div>
					</div>
				</div>
			</div>
		</div>
	[[endif]]
	<div class="tooltip"></div>
	[[raw]]
		<!-- Yandex.Metrika counter --><div style="display:none;"><script type="text/javascript">(function(w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter12424726 = new Ya.Metrika({id:12424726, enableAll: true, webvisor:true}); } catch(e) { } }); })(window, "yandex_metrika_callbacks");</script></div><script src="//mc.yandex.ru/metrika/watch.js" type="text/javascript" defer="defer"></script><noscript><div><img src="//mc.yandex.ru/watch/12424726" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->
	[[endraw]]
</body>
</html>