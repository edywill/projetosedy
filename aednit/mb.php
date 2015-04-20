<?php 
mb_internal_encoding('iso-8859-1');
mb_http_output('iso-8859-1');
mb_http_input('iso-8859-1');
mb_language('uni');
mb_regex_encoding('iso-8859-1');
ob_start('mb_output_handler');
?>