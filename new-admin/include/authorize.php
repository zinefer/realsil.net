<?

$authorize = array();
$authorize_error = array();

$authorize['worker_password'] = '/\A.{0,32}\Z/';
$authorize_error['worker_password'] = 'Your password must be no longer than 32 characters long';


?>