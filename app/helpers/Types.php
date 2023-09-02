<?php

use JetBrains\PhpStorm\NoReturn;

if (!function_exists("query")) die("Fatal, Database helper is not loaded. This app requires database helper to work.");

/**
 *
 */
class View
{
  /**
   * @var string
   */
  public string $page = "home";

  /**
   * @var string
   */
  public string $title = "smskSoft CMS";
  /**
   * @var string
   */
  public string $subpage = "";
  /**
   * @var object|array
   */
  public object|array $data = [];

  /**
   * View type constructor.
   * @return array
   */
  public function __construct(string $title, string $page, object|array $data = [], string $subpage = "")
  {
    $this->title = $title;
    $this->page = $page;
    $this->subpage = $subpage;
    $this->data = $data;
    return ['title' => $this->title, 'page' => $this->page, 'subpage' => $this->subpage, ...$this->data];
  }

  /**
   * @param $name
   * @return mixed
   */
  public function __get($name)
  {
    return $this->$name;
  }

  /**
   * @param $name
   * @param $value
   * @return void
   */
  public function __set($name, $value)
  {
    $this->$name = $value;
  }

  /**
   * @return string
   */
  public function getTitle(): string
  {
    return $this->title;
  }

  /**
   * @param string $title
   * @return void
   */
  public function setTitle(string $title): void
  {
    $this->title = $title;
  }

  /**
   * @return string
   */
  public function getPage(): string
  {
    return $this->page;
  }

  /**
   * @param string $page
   * @return void
   */
  public function setPage(string $page): void
  {
    $this->page = $page;
  }

  /**
   * @return string
   */
  public function getSubpage(): string
  {
    return $this->subpage;
  }

  /**
   * @param string $subpage
   * @return void
   */
  public function setSubpage(string $subpage): void
  {
    $this->subpage = $subpage;
  }

  /**
   * @return object|array
   */
  public function getData(): object|array
  {
    return $this->data;
  }

  /**
   * @param object|array $data
   * @return void
   */
  public function setData(object|array $data): void
  {
    $this->data = $data;
  }
}

/**
 *
 */
class File
{

  /**
   * @var array|string[]
   */
  private array $allowedFileTypes;
  /**
   * @var string
   */
  private string $path;
  /**
   * @var string
   */
  private string $type;
  /**
   * @var string
   */
  private string $name;

  /**
   * @param string $name
   * @param string $type
   * @param array $allowedFileTypes
   */
  public function __construct(string $name, string $type, array $allowedFileTypes = ["image/jpeg", "image/jpg", "image/png", "image/webp"])
  {
    $this->path = SDF_ROOT . $type . DIRECTORY_SEPARATOR;
    $this->name = $name;
    $this->type = $type;
    $this->allowedFileTypes = $allowedFileTypes;
  }

  /**
   * @param $fileInputName
   * @return array
   */
  public function uploadFile($fileInputName): array
  {
    if (!isset($_FILES[$fileInputName])) {
      return [false, "No file uploaded."];
    }

    $file = $_FILES[$fileInputName];
    $fileName = basename($file["name"]);
    $targetPath = $this->path . $fileName;

    // Check if the file type is allowed
    if (!empty($this->allowedFileTypes) && !in_array($file["type"], $this->allowedFileTypes)) {
      return [false, "File type not allowed."];
    }

    if (move_uploaded_file($file["tmp_name"], $targetPath)) {
      if ($file["type"] === "image/webp") $fileName = $this->pngToWebp($targetPath);
      return [true, $fileName];
    } else {
      return [false, "File upload failed."];
    }
  }

  /**
   * @param $sourceImagePath
   * @param $quality
   * @return string
   */
  public function pngToWebp($sourceImagePath, $quality = 80): string
  {
    $sourceImage = imagecreatefrompng($sourceImagePath);
    $destinationImagePath = pathinfo($sourceImagePath, PATHINFO_DIRNAME) . '/' . pathinfo($sourceImagePath, PATHINFO_FILENAME) . '.webp';
    $destinationImage = imagecreatetruecolor(imagesx($sourceImage), imagesy($sourceImage));
    $whiteColor = imagecolorallocate($destinationImage, 255, 255, 255);
    imagefill($destinationImage, 0, 0, $whiteColor);
    imagecopy($destinationImage, $sourceImage, 0, 0, 0, 0, imagesx($sourceImage), imagesy($sourceImage));
    imagewebp($destinationImage, $destinationImagePath, $quality);
    imagedestroy($sourceImage);
    imagedestroy($destinationImage);
    return $destinationImagePath;
  }

  /**
   * @param $fileName
   * @return bool
   */
  public function deleteFile($fileName): bool
  {
    $file = $this->path . $fileName;
    if (file_exists($file)) unlink($file);
    return true;
  }

  /**
   * @return string
   */
  public function getFileName(): string
  {
    return $this->name;
  }

  /**
   * @return string
   */
  public function getType(): string
  {
    return $this->type;
  }
}

class Request
{
  public string $method;
  public string $url;
  public string $ip;
  public string $userAgent;
  public string $referer;
  public array|false $headers;

  public function __construct()
  {
    $this->method = $_SERVER['REQUEST_METHOD'] ?? "undefined";
    $this->url = $_SERVER['REQUEST_URI'] ?? "undefined";
    $this->ip = $_SERVER['REMOTE_ADDR'] ?? "undefined";
    $this->userAgent = $_SERVER['HTTP_USER_AGENT'] ?? "undefined";
    $this->referer = $_SERVER['HTTP_REFERER'] ?? "undefined";
    $this->headers = getallheaders();
  }

  public function method(): string
  {
    return $_SERVER['REQUEST_METHOD'];
  }

  public function body(string $field = null, string $method = "post"): mixed
  {
    if ($method === "post") {
      if (empty($_POST)) $_POST = json_decode(file_get_contents("php://input"));
      if (!empty($field)) return $_POST[$field];
      return $_POST;
    }
    if ($method === "get") {
      if (empty($_GET)) $_GET = json_decode(file_get_contents("php://input"));
      if (!empty($field)) return $_GET[$field];
      return $_GET;
    };
    return false;
  }

  #[NoReturn] public function sendResponse(mixed $content, int $status = 200, string $content_type = "application/json"): void
  {
    http_response_code($status);
    header("Content-Type: " . $content_type);
    print_r($content);
    die();
  }
}

class User
{
  public int $id;

  public string $name;
  public string $email;
  public string $password;

  public string $method;
  public int $rank;
}
