<?php

$app->get('/login', function () use ($app) {
  $app->render('user/login.phtml', array(
    'no_wrap' => true,
    'page_title' => 'Login'
  ));
});

$app->post('/login', function () use ($app, $session) {
  $username = $app->request()->post('username');
  $password = $app->request()->post('password');

  // Support logging in with email address
  $user = \Skeleton\Models\User::search()->where('email', $username)->where('password', hash("SHA1", $password))->execOne();

  // Support logging in with username
  if(!$user instanceof \Skeleton\Models\User){
    $user = \Skeleton\Models\User::search()->where('username', $username)->where('password', hash("SHA1", $password))->execOne();
  }

  // Check login failure.
  if(!$user instanceof \Skeleton\Models\User){
      header("Location: login?failed");
      exit;
  }else{
      $_SESSION['user'] = $user;
      header("Location: dashboard");
      exit;
  }

});


$app->get('/register', function () use ($app) {
  $app->render('user/register.phtml', array(
    'no_wrap' => false,
    'page_title' => 'Register'
  ));
});


$app->post('/register', function () use ($app) {
  if($_POST['password'] !== $_POST['password2']){
    header("Location: register?failed=" . urlencode("Passwords do not match"));
    exit;
  }

  if(\Skeleton\Models\User::search()->where('username', $_POST['username'])->count() > 0){
    header("Location: register?failed=" . urlencode("Username in use."));
    exit;
  }

  if(strlen($_POST['password']) < 6){
    header("Location: register?failed=" . urlencode("Password has to be atleast 6 characters"));
    exit;
  }

  if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    header("Location: register?failed=" . urlencode("Email address invalid"));
    exit;
  }

  $user = new \Skeleton\Models\User();
  $user->username = $_POST['username'];
  $user->password = hash("SHA1", $_POST['password']);
  $user->displayname = $_POST['realname'];
  $user->created = date("Y-m-d H:i:s");
  $user->email = $_POST['email'];
  $user->save();
  $user->reload();

  $_SESSION['user'] = $user;
  header("Location: dashboard");
  exit;
});

$app->get('/logout', function () use ($app, $session) {
  \FourOneOne\Session::dispose('user');
  header("Location: login");
  exit;
});