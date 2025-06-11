<?php
session_start();
include_once  __DIR__.'/../database/dbconfig.php';
// Error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class SystemConfig {
    private $conn;
    
    private $system_name;
    private $system_phone_number;
    private $system_email;
    private $system_logo;
    private $system_address;
    private $system_facebook;
    private $system_instagram;
    private $system_copyright;
    private $system_config_last_update;

    private $smtp_email;
    private $smtp_password;
    private $email_config_last_update;

    private $SKey;
    private $SSKey;
    private $google_recaptcha_api_last_update;

    private $google_maps_api;


    public function __construct()
    {
        $database = new Database();
        $db = $database->dbConnection();
        $this->conn = $db;
        
        // get system configuration
        $stmt = $this->runQuery("SELECT * FROM system_config LIMIT 1");
        $stmt->execute(array());
        $system_config = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->system_name = $system_config['system_name'];
        $this->system_phone_number = $system_config['system_phone_number'];
        $this->system_email = $system_config['system_email'];
        $this->system_logo = $system_config['system_logo'];
        $this->system_address = $system_config['system_address'];
        $this->system_facebook = $system_config['system_facebook'];
        $this->system_instagram = $system_config['system_instagram'];
        $this->system_copyright = $system_config['system_copy_right'];
        $this->system_config_last_update = $system_config['updated_at'];
        
        // get email configuration
        $stmt = $this->runQuery("SELECT * FROM email_config LIMIT 1");
        $stmt->execute(array());
        $email_config = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->smtp_email = $email_config['email'];
        $this->smtp_password = $email_config['password'];
        $this->email_config_last_update = $email_config['updated_at'];
        
        // get Google reCAPTCHA V3 API configuration
        $stmt = $this->runQuery("SELECT * FROM google_recaptcha_api LIMIT 1");
        $stmt->execute(array());
        $google = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->SKey = $google['site_key'];
        $this->SSKey = $google['site_secret_key'];
        $this->google_recaptcha_api_last_update = $google['updated_at'];

        //get Google Maps API
        $stmt = $this->runQuery("SELECT * FROM google_maps_api LIMIT 1");
        $stmt->execute(array());
        $google_maps = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->google_maps_api = $google_maps['api'];

    }

    public function runQuery($sql) {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }

    // getters for properties
    public function getSystemName() {
        return $this->system_name;
    }

    public function getSystemNumber() {
        return $this->system_phone_number;
    }

    public function getSystemEmail() {
        return $this->system_email;
    }

    public function getSystemLogo() {
        return $this->system_logo;
    }

    public function getSystemAddress() {
        return $this->system_address;
    }

    public function getSystemFacebook() {
        return $this->system_facebook;
    }

    public function getSystemInstagram() {
        return $this->system_instagram;
    }

    public function getSystemCopyright() {
        return $this->system_copyright;
    }

    public function getSystemConfigLastUpdate() {
        return $this->system_config_last_update;
    }

    public function getSmtpEmail() {
        return $this->smtp_email;
    }

    public function getSmtpPassword() {
        return $this->smtp_password;
    }

    public function getEmailConfigLastUpdate() {
        return $this->email_config_last_update;
    }

    public function getSKey() {
        return $this->SKey;
    }

    public function getSSKey() {
        return $this->SSKey;
    }

    public function getGoogleRecaptchaApiLastUpdate() {
        return $this->google_recaptcha_api_last_update;
    }

    public function getGoogleMapsAPI() {
        return $this->google_maps_api;
    }
 
}

 // Main URL class
class MainUrl {
    private $url;

    public function __construct() {
        // Check if the server is running on localhost
        if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_ADDR'] === '127.0.0.1') {
            $this->url = "http://localhost/MAGRENT";
        } else {
            // Set the URL for the web host
            $this->url = "https://magrent.website";
        }
    }
    

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
    }


}

?>