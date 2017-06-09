<xml>
	<?php
	if ($this->user) {
		echo '
			<id>'.$this->user['u_id'].'</id>
			<nom>'.$this->user['u_nom'].'</nom>
			<prenom>'.$this->user['u_prenom'].'</prenom>
			<datenaissance>'.$this->user['u_date_naissance'].'</datenaissance>';
	}
	?>
</xml>