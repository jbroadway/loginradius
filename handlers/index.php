<?php

if (User::require_login ()) {
	// already logged in
	if ($this->internal) {
		// do nothing if it's embedded
		return;
	}
	// redirect if they've gone to /loginradius
	$this->redirect ('/user');
}

$obj = new LoginRadius ($appconf['LoginRadius']['api_secret']);

if (! $obj->IsAuthenticate) {
	// append head scripts to head
	$page->add_script ($this->run ('loginradius/head'));

	if (! isset ($data['text'])) {
		$data['text'] = i18n_get ('Sign in with LoginRadius');
	}

	// show login link
	echo $tpl->render ('loginradius/index', array (
		'text' => $data['text'],
		'api_key' => $appconf['LoginRadius']['api_key']
	));
	return;
}

// we're authenticated, get data
$token = 'lr:' . substr ($obj->Provider, 0, 1) . ':' . $obj->ID;

// user lookup
if (isset ($obj->EmailID)) {
	$u = User::query ()->where ('email', $obj->EmailID)->single ();
} else {
	$uid = User_OpenID::get_user_id ($token);
	if ($uid) {
		$u = new User ($uid);
	}
}

@session_start ();
$_SESSION['session_openid'] = $token;

if ($u) {
	// already have an account, log them in
	$u->session_id = md5 (uniqid (mt_rand (), 1));
	$u->expires = gmdate ('Y-m-d H:i:s', time () + 2592000);
	$try = 0;
	while (! $u->put ()) {
		$u->session_id = md5 (uniqid (mt_rand (), 1));
		$try++;
		if ($try == 5) {
			$this->redirect ($_GET['redirect']);
		}
	}
	$_SESSION['session_id'] = $u->session_id;

	// save openid token
	$oid = new User_OpenID (array (
		'token' => $token,
		'user_id' => $u->id
	));
	$oid->put ();

	$this->redirect ('/user');
}

// signup form to create a linked account, prefill name and email
$_POST['name'] = $obj->FirstName . ' ' . $obj->LastName;
$_POST['email'] = $obj->EmailID;
$_POST['redirect'] = '/user';
$_POST['token'] = $token;
echo $this->run ('user/login/newuser');

?>