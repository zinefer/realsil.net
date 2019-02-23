<?php
	session_set_cookie_params(7776000, '/', 'realsil.net');
	session_start();

	// Unset all of the session variables.
	$_SESSION = array();

	// If it's desired to kill the session, also delete the session cookie.
	// Note: This will destroy the session, and not just the session data!
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-42000, '/');
	}

	session_destroy();
	header("Location: index.php"); exit;
?>