<?php

class Account extends SDF\Controller
{
  protected Request $request;

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
    $this->load->file("Types", SDF_APP_HELP);
    $this->request = new Request();

    if (!isSignedIn()) {
      flash->add("Warning", "You must be signed in to view this page.");
      redirect("signin");
    }
  }

  public function index(): void
  {
    $this->list();
  }

  public function list(): void
  {
    $view = new View("Accounts", "account", ["users" => user()], "list");
    $this->load->view('partials/head', $view);
    $this->load->view('dashboard/account/list', $view);
    $this->load->view('partials/footer', $view);
  }

  public function create(): void
  {
    if ($this->request->method === "POST") {
      $this->store();
      return;
    }
    $view = new View("Create Account", "account", subpage: "create");
    $this->load->view('partials/head', $view);
    $this->load->view('dashboard/account/create', $view);
    $this->load->view('partials/footer', $view);
  }

  public function store(string $method = "create", int $id = null): void
  {
    if ($this->request->method() === "POST") {
      try {
        if ($method === "update") {
          if (empty($id)) $id = active()->id;
          if (updateUser($id, $_POST['email'], $_POST['name'], $_POST['password']))
            flash->add("Success", "Account updated.");
          else
            flash->add("Error", "Account could not be updated.");
          redirect('dashboard');
        } else {
          if (createUser($_POST['email'], $_POST['name'], $_POST['password']))
            flash->add("Success", "Account created.");
          else
            flash->add("Error", "Account could not be created.");
          redirect('dashboard');
        }
      } catch (Exception $e) {
        flash->add("Error", $e->getMessage());
        redirect('dashboard/account/' . $method . (!empty($id) ? '/' . $id : ''));
      }
    } else {
      redirect('dashboard/account/' . $method . (!empty($id) ? '/' . $id : ''));
    }
  }

  public function update(int $user = null): void
  {
    if ($this->request->method() === "POST") {
      $this->store(method: "update", id: $user);
    } else {
      $view = new View("Update Account", "account", ["user" => active()]);
      if (!empty($user)) $view = new View("Update Account", "account", ["user" => user($user)[0]]);
      $this->load->view('partials/head', $view);
      $this->load->view('dashboard/account/update', $view);
      $this->load->view('partials/footer', $view);
    }
  }

  public function delete(int $id)
  {
    try {
      if ($id !== active()->id) {
        if (removeUser($id))
          flash->add("Success", "Account deleted.");
        else
          flash->add("Error", "Account could not be deleted.");
      } else flash->add("Error", "You cannot delete your own account.");
      redirect('dashboard/account');
    } catch (Exception $e) {
      flash->add("Error", $e->getMessage());
      redirect('dashboard/account');
    }
  }

}
