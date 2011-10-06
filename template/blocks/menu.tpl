<div id="topmenu">
	<div id="mainmenu-container">
		[[for m in menu]]
			<div class="item[[if m.status]] active[[endif]]"><div><div><a href="[[if m.index]]/[[else]]/{m.url}[[endif]]" rel="{m[modul.idField]}" >{m.caption}</a></div></div></div>	
		[[endfor]]
	</div>
	<div id="submenu-container">
		[[for m in menu]]
			<span class="sub-block [[if m.status]]show-sub-block[[endif]]" id="sub-block-{m[modul.idField]}" >
			[[for c in m['child']]]
				<div class="item [[if c.status]] active[[endif]]"><div><a href="/{m.url}/{c.url}">{c.caption}</a></div></div>
			[[endfor]]
			</span>
		[[endfor]]
	</div>
</div>