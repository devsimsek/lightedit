<?php
if (!isset($_SESSION)) session_start();

if (!function_exists("encodePassword")) {
  function encodePassword(string $password): string
  {
    return hash('SHA256', md5($password));
  }
}

if (!function_exists('matchSha')) {
  function matchSha(string $hashed, string $unhashed): bool
  {
    return $hashed == hash('SHA256', md5($unhashed));
  }
}

function signIn(string $email, string $password)
{
  try {
    if (!empty($email) && !empty($password)) {
      $user = query("SELECT * FROM `user` WHERE `email` = ?", [$email])[0] ?? false;
      if ($user) {
        if ($user->password === encodePassword($password)) {
          $_SESSION['user'] = (object)$user;
          flash->add("Sign In Successful.", "You successfully signed in.", type: "success");
          redirect("dashboard");
        }
        flash->add("Wrong Password.", "Please check your records and try again.", type: "warning");
        redirect("signin");
      }
      flash->add("User Not Found.", "Please check your records and try again.", type: "warning");
      redirect("signin");
    }
    flash->add("Sign in Failed.", "Please check your records and try again.", type: "warning");
    redirect("signin");
  } catch (PDOException $e) {
    flash->add("Something Unexpected Happened", "Please try again later.", type: "danger");
    redirect("signin");
  }
}

function signUp(string $name, string $email, string $password): void
{
  try {
    if (!empty($name) && !empty($email) && !empty($password)) {
      if (createUser($email, $name, $password)) {
        flash->add("Registration Successful", "You have successfully registered. Please login to continue.", type: "success");
        redirect("signin");
      }
      flash->add("Registration Failed", "Something went wrong. Please try again later.", type: "success");
      redirect("signup");
    }
    flash->add("Registration Failed", "Please check your form. Some of the required fields are missing.", type: "success");
    redirect("signup");
  } catch (PDOException|Exception $e) {
    flash->add("Something went wrong", "Please try again later.", type: "danger");
    redirect("signup");
  }
}

function signOut(): void
{
  session_destroy();
  flash->initialize();
  redirect("signin");
}

function isSignedIn(): bool
{
  if (isset($_SESSION['user'])) {
    if (!is_bool(query("SELECT * FROM `user` WHERE `id` = ?", [$_SESSION['user']->id]))) {
      return true;
    }
    return false;
  }
  return isset($_SESSION['user']);
}

function rank2string($rank = null): string
{
  if ($rank === null && isset($_SESSION["user"]->rank))
    return rank2string($_SESSION["user"]->rank);
  else
    return match ($rank) {
      -1 => "Banned user",
      0 => "Customer",
      1 => "Staff",
      2 => "Administrator",
      3 => "Developer",
      default => "unknown rank",
    };
}

function limitRank(int $level, string $redirect = null): bool
{
  if ($user = user($_SESSION['user']->id)) {
    is_array($user) ? $user = $user[0] : do_nothing();
    if (!empty($redirect) && $user->rank >= $level)
      redirect($redirect);
    return $user->rank >= $level;
  } else {
    if (isSignedIn()) signOut();
  }
  return false;
}

function active(): User|false
{
  if (isSignedIn()) {
    return castToObject($_SESSION['user'], "User");
  }
  return false;
}
