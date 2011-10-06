[[ include TEMPLATE_PATH ~ "blocks/header.tpl"]]
<body>
	<div class="left-background"></div>
	<div id="page">
		<div class="p-inner">
			<div id="head">
				[[ include TEMPLATE_PATH ~ "blocks/user_info.tpl"]]
				[[ include TEMPLATE_PATH ~ "blocks/menu.tpl"]]
			</div>
			
			<div id="content">
				<div id="wrapper">
					<div id="left">
					[[ block left ]]
						<h4>Пользователи</h4>
						<ul>
							<li><a href="">Настройка доступа</a></li>
							<li><a href="">Настройка оповещений</a></li>
							<li>Настройка паролей</li>
							<li><a href="">Настройка доступа</a></li>
						</ul>
						<br />
						<h4>Sape</h4>
						<ul>
							<li><a href="">Настройка обновлений</a></li>
							<li><a href="">Настройка оповещений</a></li>
						</ul>
						[[ endblock ]]
					</div>
					<div id="right">
					[[ block right ]]
						<div id="tabs">			
							<div class="item">Новости</div>
							<div class="item active">Заметки безопасности</div>
							<div class="item">Инфо</div>
							<div class="item">Недавние документы</div>
						</div>
						<div id="main-container">
							<h1>Настройка паролей</h1>
							<button class="green"><div><div>Редактировать</div></div></button>
							<table class="edit-table">
								<colgroup>
									<col width="170px" />
									<col />
									<col width="120px" />
								</colgroup>
								<thead>
									<tr>
										<td>
											Роль
										</td>
										<td>
											Описание
										</td>
										<td>
											Действие
										</td>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											Менеджер проектов
										</td>
										<td>
											Over a year in the works, MODX: The Official Guide by Bob Ray is a 772 page reference for all things MODX. 
											in-house MODX Press and we're tremendously proud to put our name on it.
										</td>
										<td>
											<a href="" class="link-icon" ><img src="/images/edit-icon.gif" alt="" /></a>
											<a href="" class="link-icon" ><img src="/images/delete-icon.gif" alt="" /></a>
										</td>
									</tr>
									<tr class="odd">
										<td>
											Менеджер проектов
										</td>
										<td>
											Over a year in the works, MODX: The Official Guide by Bob Ray is a 772 page reference for all things MODX. 
											in-house MODX Press and we're tremendously proud to put our name on it.
										</td>
										<td>
											<a href="" class="link-icon" ><img src="/images/edit-icon.gif" alt="" /></a>
											<a href="" class="link-icon" ><img src="/images/delete-icon.gif" alt="" /></a>
										</td>
									</tr>
									<tr>
										<td>
											Менеджер проектов
										</td>
										<td>
											Over a year in the works, MODX: The Official Guide by Bob Ray is a 772 page reference for all things MODX. 
											in-house MODX Press and we're tremendously proud to put our name on it.
										</td>
										<td>
											<a href="" class="link-icon" ><img src="/images/edit-icon.gif" alt="" /></a>
											<a href="" class="link-icon" ><img src="/images/delete-icon.gif" alt="" /></a>
										</td>
									</tr>
									<tr class="odd">
										<td>
											Менеджер проектов
										</td>
										<td>
											Over a year in the works, MODX: The Official Guide by Bob Ray is a 772 page reference for all things MODX. 
											in-house MODX Press and we're tremendously proud to put our name on it.
										</td>
										<td>
											<a href="" class="link-icon" ><img src="/images/edit-icon.gif" alt="" /></a>
											<a href="" class="link-icon" ><img src="/images/delete-icon.gif" alt="" /></a>
										</td>
									</tr>
									<tr>
										<td>
											Менеджер проектов
										</td>
										<td>
											Over a year in the works, MODX: The Official Guide by Bob Ray is a 772 page reference for all things MODX. 
											in-house MODX Press and we're tremendously proud to put our name on it.
										</td>
										<td>
											<a href="" class="link-icon" ><img src="/images/edit-icon.gif" alt="" /></a>
											<a href="" class="link-icon" ><img src="/images/delete-icon.gif" alt="" /></a>
										</td>
									</tr>
									<tr class="odd">
										<td>
											Менеджер проектов
										</td>
										<td>
											Over a year in the works, MODX: The Official Guide by Bob Ray is a 772 page reference for all things MODX. 
											in-house MODX Press and we're tremendously proud to put our name on it.
										</td>
										<td>
											<a href="" class="link-icon" ><img src="/images/edit-icon.gif" alt="" /></a>
											<a href="" class="link-icon" ><img src="/images/delete-icon.gif" alt="" /></a>
										</td>
									</tr>
									<tr>
										<td>
											Менеджер проектов
										</td>
										<td>
											Over a year in the works, MODX: The Official Guide by Bob Ray is a 772 page reference for all things MODX. 
											in-house MODX Press and we're tremendously proud to put our name on it.
										</td>
										<td>
											<a href="" class="link-icon" ><img src="/images/edit-icon.gif" alt="" /></a>
											<a href="" class="link-icon" ><img src="/images/delete-icon.gif" alt="" /></a>
										</td>
									</tr>
									<tr class="odd">
										<td>
											Менеджер проектов
										</td>
										<td>
											Over a year in the works, MODX: The Official Guide by Bob Ray is a 772 page reference for all things MODX. 
											in-house MODX Press and we're tremendously proud to put our name on it.
										</td>
										<td>
											<a href="" class="link-icon" ><img src="/images/edit-icon.gif" alt="" /></a>
											<a href="" class="link-icon" ><img src="/images/delete-icon.gif" alt="" /></a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						[[ endblock ]]
					</div>
				</div>
			</div>
		
		</div>
	
	</div>

	
</body>
</html>