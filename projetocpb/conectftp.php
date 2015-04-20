<?php 
		$servidor = '10.67.16.18';
        $con_id = ftp_connect($servidor) or die( 'Não conectou em: '.$servidor );
        $cheqftp='ftp://ciweb:rio2016@10.67.16.18/';
		ftp_login( $con_id, 'ciweb', 'rio2016' );
?>