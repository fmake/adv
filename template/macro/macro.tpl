[[macro level_space(level)]]
	[[ if level > 1 ]]
		{'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'}
		[[ set level = level - 1 ]]
		{_self.level_space(level)}
	[[ endif]]
[[endmacro]]

[[ macro input(name, value, type, size) ]]
    <input type="{ type|default('text') }" name="{ name }}" value="{ value|e }" size="{ size|default(20) }" />
[[ endmacro ]]

[[ macro action(link,src, alt, width, height, confirm) ]]
	<a href="{link}" [[if confirm]] onclick="return confirm('{confirm}');"  [[endif]]>
		<img src="/images/admin/actions/{src}" width="{ width }" height="{ height }" border="0" alt="{alt}" />
	</a>
[[ endmacro ]]
