<?php

class Auth extends SDF\Controller
{
  /**
   * Not necessary to add, but
   * it feels kinda nice to
   * control all variables
   * flowing through
   * controller.
   */
  public function __construct()
  {
    parent::__construct();
    $this->load->file("Session", SDF_APP_LIB);
    $this->load->file("Database", SDF_APP_LIB);
    $this->load->file("Flash", SDF_APP_LIB);
    $this->load->helper("Global");
    $this->load->helper("Database");
    $this->load->helper("Flash");
    $this->load->helper("Auth");
  }

  public function index()
  {
    $this->signin();
  }

  public function signin()
  {
    if (isSignedIn()) redirect("dashboard");
    $this->load->view("auth/signin");
  }

  public function signup()
  {
    if (isSignedIn()) redirect("dashboard");
    $this->load->view("auth/signup");
  }

  public function signout()
  {
    signOut();
  }

  public function callback(string $method = "ledit")
  {
    if ($method === "ledit") {
      if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['signin'])) {
          signIn($_POST["email"], $_POST["password"]);
        } elseif (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['signup'])) {
          signUp($_POST["name"], $_POST["email"], $_POST["password"]);
        } else {
          flash->add("Bad Request", "You sent an incorrect request to the page you want to access. Please try again.");
        }
        redirect("/signin");
      }
    }

    if ($method === "google") {
      die("not supported");
    }
  }
}
