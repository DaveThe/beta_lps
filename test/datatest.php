<?php

    $date_formt = new   \DateTime('NOW');
	print_r($date_formt);
	echo '<br>';
    $date_formt->add(new  \DateInterval('P1D'));
	print_r($date_formt);
?>