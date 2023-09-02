<?php

class Settings extends SDF\Controller
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
    $view = new View("Settings", "settings", ["settings" => setting()], "list");
    $this->load->view('partials/head', $view);
    $this->load->view('dashboard/settings/list', $view);
    $this->load->view('partials/footer', $view);
  }

  public function create(): void
  {
    if ($this->request->method === "POST") {
      $this->store();
      return;
    }
    $view = new View("Create Setting", "settings", subpage: "create");
    $this->load->view('partials/head', $view);
    $this->load->view('dashboard/settings/create', $view);
    $this->load->view('partials/footer', $view);
  }

  public function store(string $method = "create", int $id = null): void
  {
    if ($this->request->method() === "POST") {
      try {
        if ($method === "update") {
          if (empty($id)) $id = active()->id;
          if (updateSetting($id, $_POST['value']))
            flash->add("Success", "Setting updated.");
          else
            flash->add("Error", "Setting could not be updated.");
          redirect('dashboard');
        } else {
          if (createSetting($_POST['name'], $_POST['value']))
            flash->add("Success", "Setting created.");
          else
            flash->add("Error", "Setting could not be created.");
          redirect('dashboard');
        }
      } catch (Exception $e) {
        flash->add("Error", $e->getMessage());
        redirect('dashboard/settings/' . $method . (!empty($id) ? '/' . $id : ''));
      }
    } else {
      redirect('dashboard/settings/' . $method . (!empty($id) ? '/' . $id : ''));
    }
  }

  public function update(int $setting = null): void
  {
    if ($this->request->method() === "POST") {
      $this->store(method: "update", id: $setting);
    } else {
      $view = new View("Update Setting", "settings", ["setting" => active()]);
      if (!empty($setting)) $view = new View("Update Setting", "settings", ["sett" => setting($setting)[0]]);
      $this->load->view('partials/head', $view);
      $this->load->view('dashboard/settings/update', $view);
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
      redirect('dashboard/settings');
    } catch (Exception $e) {
      flash->add("Error", $e->getMessage());
      redirect('dashboard/settings');
    }
  }

}
