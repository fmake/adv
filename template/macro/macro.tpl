[[macro level_space(level)]]
	[[ if level > 1 ]]
		{'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'}
		[[ set level = level - 1 ]]
		{_self.level_space(level)}
	[[ endif]]
[[endmacro]]
