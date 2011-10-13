<div id="toper">
	<div id="user">
		<a href="/settings/user">{user.name}</a>  (<a href="/?action=logout">Выйти</a>)
	</div>
	[[ if not modul.index ]]
	<a href="/" id="logo" title="На главную">
		<span>Venta-adv</span>
	</a>
	[[else]]
	<div id="logo" title="На главную">
		<span>Venta-adv</span>
	</div>	
	[[endif]]
</div>