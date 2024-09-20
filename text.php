<?php
# Check if file exists
$file = 'https://demo.porosiq.com/assets/plugins/jQuery/jquery-2.2.3.min.js';
$file_headers = @get_headers($file);
$file_headers[0] == 'HTTP/1.1 200 OK' ? $rate_confirmation_exists[1] = 1 : '';

echo $file_headers[0];
