<html>
	<body>
		<form action="../api/" method="post">
			<input type="hidden" value="<?php
				$Input = array(
					'SearchLyrics' => array(
						'Artist' => 'Jimmy Eat World',
						'Track'  => 'The Middle',
						'Album'  => 'Bleed American',
					),
				);
				echo htmlentities(json_encode($Input), ENT_QUOTES);
			?>" name="input">
			<input type="submit">
		</form>
	</body>
</html>