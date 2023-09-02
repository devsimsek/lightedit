<?php

global $database_config;
global $payment_config;
$database_config = load_config("database");
$payment_config = load_config("payment");

define("db", new Database($database_config['host'], $database_config['name'], $database_config['user'], $database_config['password']));
const flash = new Flash();
const session = new Session();

/**
 * Base url
 * Returns base url of the site
 * @param string|null $path
 * @return string|null
 */
function base_url(string $path = null): ?string
{
  if (!defined("BASE_URL")) {
    if (isset($_SERVER['HTTPS'])) {
      $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    } else {
      if (SDF_ENV === "development")
        $protocol = 'http';
      else $protocol = 'https';
    }

    if ($path != null) {
      return $protocol . "://" . $_SERVER['HTTP_HOST'] . DIRECTORY_SEPARATOR . $path;
    }
    return $protocol . "://" . $_SERVER['HTTP_HOST'] . DIRECTORY_SEPARATOR;
  } else {
    return BASE_URL;
  }
}

/**
 * Redirect
 * redirects to another url
 * @param string $url
 * @param bool $permanent
 */
function redirect(string $url, bool $permanent = false): void
{
  if (headers_sent() === false) {
    //header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    header("location: " . base_url($url), true, ($permanent === true) ? 301 : 302);
  }
  //header("location: " . base_url($url));
  print_r("<script>window.location.href = '" . $url . "'</script>");
  exit();
}

/**
 * Converts a string to a slug.
 *
 * This function takes a string as input and performs several operations to convert it into a slug.
 * The slug is a URL-friendly representation of the string, typically used in generating SEO-friendly URLs.
 *
 * @param string $str The string to be converted to a slug.
 * @return array|string|null The slug representation of the input string, or null if the input is empty.
 */
function strtoslug(string $str): array|string|null
{
  $str = trim($str); // trim
  $str = strtolower($str);

  // remove accents, swap ñ for n, etc
  $from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;şığ";
  $to = "aaaaeeeeiiiioooouuuunc------sig";
  $str = str_replace(str_split($from), str_split($to), $str);

  $str = preg_replace('/[^a-z0-9 -]/', '', $str); // remove invalid chars
  $str = preg_replace('/\s+/', '-', $str); // collapse whitespace and replace by -
  $str = preg_replace('/-+/', '-', $str); // collapse dashes

  return $str;
}


/**
 * Summarizes a given string by truncating it to a specified length and adding an ellipsis at the end.
 *
 * This function takes a string as input and returns a summarized version of the string by truncating it to a specified length.
 * If the string length is already less than or equal to the specified length, the original string is returned as it is.
 * The function replaces newlines with spaces and collapses consecutive whitespace characters into a single space.
 * The summarized string is then returned with an optional ellipsis character at the end.
 *
 * @param string $str The string to be summarized.
 * @param int $n The maximum length of the summarized string. Default is 500.
 * @param string $end_char The character(s) to append at the end of the summarized string. Default is '&#8230;' (ellipsis character).
 * @return string The summarized version of the input string.
 */
function summarize(string $str, int $n = 150, string $end_char = '&#8230;'): string
{
  if (strlen($str) < $n) {
    return $str;
  }

  $str = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $str));

  if (strlen($str) <= $n) {
    return $str;
  }

  $out = "";
  foreach (explode(' ', trim($str)) as $val) {
    $out .= $val . ' ';

    if (strlen($out) >= $n) {
      $out = trim($out);
      return (strlen($out) == strlen($str)) ? $out : $out . $end_char;
    }
  }
  return "";
}

function load_config(string $file, string $key = null)
{
  if (file_exists(SDF_APP_CONF . '/' . $file . '.php')) {
    if (!array_key_exists(SDF_APP_CONF . '/' . $file . '.php', get_included_files())) {
      require SDF_APP_CONF . '/' . $file . '.php';
    }
    if (isset($config)) {
      if (!empty($key)) {
        if (array_key_exists($key, $config)) {
          return $config[$key];
        } else {
          return false;
        }
      } else {
        return $config;
      }
    }
  }
  return null;
}

function save_config(string $file, string $field, string $value): bool
{
  $data = file_get_contents(SDF_APP_CONF . '/' . $file . '.php'); // reads an array of lines
  //preg_match_all('/'.$field.'/m', $data, $matches);
  $data = preg_replace('/' . $field . '/m', $value, $data);
  return file_put_contents(SDF_APP_CONF . '/' . $file . '.php', $data);

}

/**
 * Generate pagination links and return paginated data.
 *
 * @param array $data The array containing the data to be paginated.
 * @param int $resultsPerPage The number of results to display per page.
 * @param int $currentPage The current page number.
 * @return array                An array containing the paginated data and pagination links.
 */
function paginateData(array $data, int $resultsPerPage, int $currentPage): array
{
  $totalRows = count($data);

  $totalPages = ceil($totalRows / $resultsPerPage);

  $offset = ($currentPage - 1) * $resultsPerPage;

  $currentPageData = array_slice($data, $offset, $resultsPerPage);

  $paginationLinks = [];
  for ($i = 1; $i <= $totalPages; $i++) {
    if ($i == $currentPage) {
      $paginationLinks[] = ['page' => $i, 'current' => true];
    } else {
      $paginationLinks[] = ['page' => $i, 'current' => false];
    }
  }

  return ['page' => $currentPage, 'data' => $currentPageData, 'pagination' => $paginationLinks, "totalPages" => $totalPages];
}

/**
 * Do nothing.
 *
 * @return void
 */
function do_nothing()
{
}

/**
 * Cast an object to a class or interface.
 * @param $instance
 * @param $className
 * @return mixed
 */
function castToObject($instance, $className): mixed
{
  return unserialize(sprintf(
    'O:%d:"%s"%s',
    strlen($className),
    $className,
    strstr(strstr(serialize($instance), '"'), ':')
  ));
}
