<?php
/*
DAD Online. Web browser MMORPG.
Copyright(C) 2012 Aceapps Aplicaciones. 
This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses
*/

	if (!isset($_SESSION['email'])) {
		$email = "";
	} else {
		$email = $_SESSION['email'];
	}

	echo '</article>

		</section><!-- end of #main content-->

		<footer>
		<p><a>'.$email.'</a>
		&copy; <a href="http://aceapps.com.ve">aceapps.com.ve</a></p>
		</footer>

		</div><!-- #wrapper -->

		</body>
		</html>';
?>
