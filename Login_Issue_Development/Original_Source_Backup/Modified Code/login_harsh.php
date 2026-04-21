<?php 

//header("X-XSS-Protection: 1; mode=block");
// ini_set('header always set x-frame-options',"DENY");
error_reporting(1);
include_once "config_harsh.php";
session_start();
// if(isset($_SESSION['email']))
// {
//   header('Location: inventory_layout');
//   exit();
//   }

/* Variables Documentation:
 * HitURLNo: counter for how many times a URL was hit or accessed. 
 * Check_multiple_status: flag to check whether multiple login records exist for the same email (e.g. user is both client and firm).
 * AuthorizedFlag: security marker that signifies if a user is "allowed" (1) or "not allowed" (0).
 */
?>




<!DOCTYPE html>
<!---- for browser version check----------------------------->
<script>
var browser = '';
var browserVersion = 0;

if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) {
    browser = 'MSIE';
} 
if(browserVersion === 0){
    browserVersion = parseFloat(new Number(RegExp.$1));
}
//alert(browser + "*" + browserVersion);
if(browserVersion > 0 && browserVersion < 9){
 //alert('We do not support Internet explorer browser below version 9. We recommend to switch to latest version of Google chrome for better experience.');
 window.location.reload("error_page");
}
</script>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AACANet | Sign In</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta http-equiv="X-UA-Compatible" content="IE=11"/>
  <meta http-equiv="X-UA-Compatible" content="IE=10"/>
  <meta http-equiv="X-UA-Compatible" content="IE=9"/>
  <meta http-equiv="X-UA-Compatible" content="IE=8"/>
  <link rel="stylesheet" href="css/PSnnect.min.css">
  <link rel="stylesheet" href="css/PSPanel.css">

<!--  <link rel="stylesheet" href="css/loader.css"> -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/fevicon.ico">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/fevicon.ico">
  <link rel="apple-touch-icon-precomposed" href="img/fevicon.ico">
  <link rel="shortcut icon" href="img/fevicon.ico">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<script src="js/PSjquery.min.js"></script>
<script src="js/PSnnect.min.js"></script>
<script src="js/PSnnectValidator.min.js"></script>
<script src="js/SignInVal.js"></script>
<link rel="stylesheet" href="css/sweetalert.css">
<script src="js/sweetalert.min.js"></script>
<style>
html{background-image: linear-gradient(to bottom right, #BB133E, #002e5b);}
body{background:#ffffff00;/*background-color: rgba(0, 0, 0, 0.2);*/}
.clearable__clear{position: absolute;top: 6px;}
/*.has-success .input-group-addon{color: #002e5b!important;background:#fff!important;}*/
:focus-visible {outline: -webkit-focus-ring-color auto 0px!important;}
input:-internal-autofill-selected {background-color: #fff !important;}
.wrapper-login button[type=button], .wrapper-login button[type=submit], .wrapper-login button[type=reset]{
    -webkit-box-shadow: 2px 2px 3px #002e5b;box-shadow: 2px 2px 3px #002e5b;}
.wrapper-login a {font-size: 14px;}
.ml10{margin-left: 10px;}
.mt10{margin-top: 10px;}
.f_wid{width:100%;}
.user{background: #ffffff;border: 3px solid #002e5b;border-radius: 15px;padding: 2px 0px;}
.user:hover {box-shadow: 6px 6px 8px lightgrey;}
.bor{border-bottom: 0px solid #28648A!important;width: 100%;border-top-right-radius: 9px;border-bottom-right-radius: 9px;}
.wrapper-login input[type=text], .wrapper-login input[type=password]{background-color: #e8f0fe!important;}
.p0{padding:0px;}
.pr0{padding-right:0px;}
.input-group .input-group-addon:hover{font-size:18px;}
.fourth:hover{box-shadow:2px 2px 4px #002e5b!important;font-size:14px!important;}

/*Start Linkdin*/
.linkedin{background: #3c8dbc;border-top-left-radius: 10%;border-bottom-left-radius: 10%;color: #fff;height: 30px;width:30px;float:right;
          box-shadow: -6px 6px 7px #d2d6de;}
.linkedin:hover{width: 50px!important;border-top-left-radius: 10%;border-bottom-left-radius: 10%;border-right: none;transition: width 2s, transform 2s;}
/*End Linkdin*/
/* Device & OTP panels */
.device-panel{background:#fff;border:2px solid #002e5b;border-radius:12px;padding:18px 20px;margin-top:10px;}
.device-panel h5{color:#002e5b;font-weight:700;margin-bottom:12px;font-size:14px;}
.device-panel p{font-size:12px;color:#555;margin-bottom:14px;}
.otp-error-msg{color:red;font-size:12px;margin-bottom:10px;font-weight:600;}
.device-choice-btn{display:block;width:100%;padding:9px 14px;margin-bottom:8px;border-radius:8px;border:2px solid #002e5b;background:#fff;color:#002e5b;font-size:13px;font-weight:600;cursor:pointer;text-align:left;transition:background 0.2s,color 0.2s;}
.device-choice-btn:hover{background:#002e5b;color:#fff;}
.device-choice-btn.btn-primary-solid{background:#002e5b;color:#fff;}
.device-choice-btn.btn-primary-solid:hover{background:#001f42;}
.device-list-item{display:flex;align-items:center;justify-content:space-between;border:1px solid #dce3ec;border-radius:8px;padding:8px 12px;margin-bottom:7px;background:#f7f9fc;}
.device-list-item label{font-size:12px;color:#333;margin:0;cursor:pointer;flex:1;padding-left:8px;}
.device-list-item input[type=radio]{cursor:pointer;}
.device-nickname-input{width:100%;border:1px solid #b0bec5;border-radius:6px;padding:7px 10px;font-size:12px;margin-top:4px;margin-bottom:10px;background:#e8f0fe;}
.otp-input-box{letter-spacing:4px;font-size:20px;text-align:center;border:2px solid #002e5b;border-radius:8px;padding:8px;background:#e8f0fe;width:100%;}
</style>
</head>

<body class="hold-transition skin-yellow sidebar-mini" style="background-color: rgba(0, 0, 0, 0);">
<div id="show">
    <img src="img/tilt.png" style="width:80px;">
    <h6>We don't support Mobile view for best experience go to Desktop view</h6>
</div>

<?php



for ($i = 1; $i <= 36; $i++) 
    {
    $months[] = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
}

$DATE1 = $months[10]; //Start Date
$DATE2 = date('Y-m'); //End Date

$DATE4 = $months[34]; //Start Date for timeline graph 3 years


unset($_SESSION['count']);
$msg="";$Emailmsg=''; $passwordmsg='';
$unauthuser=''; $unauthusermore='';
$showLoginForm       = true;
$showOtpForm         = false;
$showNewDeviceChoice = false;
$showRemoveDevice    = false;
$otpPendingName      = '';
$otpErrorMsg         = '';
$trustedDeviceList   = [];
$showRemoveIp        = false;   // NEW — Panel 5: user picks which IP to remove
$ipList              = [];      // NEW — list of current IPs shown in Panel 5

/* =========================================================
   STEP A — Resume after correct OTP
   ========================================================= */
if(isset($_SESSION['otp_login_resume']) && $_SESSION['otp_login_resume']==1 && isset($_SESSION['otp_login_user_id'])){
    $resumeUserId = (int)$_SESSION['otp_login_user_id'];
    unset($_SESSION['otp_login_resume']);

    $agent     = $_SERVER['HTTP_USER_AGENT'];
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    if($ipAddress === '::1') $ipAddress = '127.0.0.1';
    $host_name = gethostname();

    $resumeResult = mysqli_query($conn, "SELECT * FROM tbl_login WHERE id=".$resumeUserId." LIMIT 1");
    $row          = mysqli_fetch_assoc($resumeResult);

    if($row){
        $role       = $row['role'];
        $role1      = $row['role'];
        $fullName   = $row['fullName'];
        $email      = $row['email'];
        $firmCode   = $row['firmCode'];
        $clientCode = $row['clientCode'];
        $id         = $row['id'];

        if($role==6 || $role==10){ $role=6; } else { $role=$role; }

        // FIX: Always save IP — unconditionally add if not already present
        $existingIPsA = array_values(array_filter(array_unique(explode(',', $row['IPaddress'])), fn($v) => trim($v) !== ''));
        if(!in_array($ipAddress, $existingIPsA)){
            if(count($existingIPsA) >= 5) array_shift($existingIPsA);
            $existingIPsA[] = $ipAddress;
        }
        // Always run UPDATE — even if IP already exists — to ensure column is never empty
        mysqli_query($conn, "UPDATE tbl_login SET IPaddress='".implode(',', $existingIPsA)."' WHERE id=".$id);

        $_SESSION['email']                         = $email;
        $_SESSION['userType']                      = $row['userType'];
        $_SESSION['state']                         = $row['state'];
        $_SESSION['portfolioCode']                 = $row['portfolioCode'];
        $_SESSION['role']                          = $role;
        $_SESSION['role60r10']                     = $role1;
        $_SESSION['fullName']                      = $fullName;
        $_SESSION['userloginType']                 = $row['userloginType'];
        $_SESSION['productCode']                   = $row['productCode'];
        $_SESSION['firmCode']                      = $firmCode;
        $_SESSION['clientCode']                    = $clientCode;
        $_SESSION['companyId']                     = $row['companyId'];
        $_SESSION['LastName']                      = $row['LastName'];
        $_SESSION['id']                            = $id;
        $_SESSION['UserGroup']                     = $row['UserGroup'];
        $_SESSION['phoneNo']                       = $row['phoneNo'];
        $_SESSION['timeout']                       = time();
        $_SESSION['firmCodenew']                   = $firmCode;
        $_SESSION['clientCodenew']                 = $clientCode;
        $_SESSION['AACA_RCVD_BATCH_FROM']          = $DATE1;
        $_SESSION['AACA_RCVD_BATCH_END']           = $DATE2;
        $_SESSION['AACA_RCVD_BATCH_FROM_PIE']      = '2002-01';
        $_SESSION['AACA_RCVD_BATCH_END_PIE']       = $DATE2;
        $_SESSION['SETLMNT_BATCH_FROM']            = $DATE1;
        $_SESSION['SETLMNT_BATCH_END']             = $DATE2;
        $_SESSION['AACA_RCVD_BATCH_FROM_TIMELINE'] = $DATE4;
        $_SESSION['AACA_RCVD_BATCH_END_TIMELINE']  = $DATE2;

        // Normalise Passexpdate format (PDF fix: PastExpDate invalid)
        $dtP = DateTime::createFromFormat('Y-m-d H:i:s', $row['Passexpdate']);
        if(!$dtP) $dtP = DateTime::createFromFormat('Y-m-d', $row['Passexpdate']);
        if($dtP) mysqli_query($conn, "UPDATE tbl_login SET Passexpdate='".$dtP->format('Y-m-d H:i:s')."' WHERE id=".$id);

        $eularesult        = mysqli_query($conn, "Select * from MANAGE_EULA where UserId=".$id."");
        $roweula           = mysqli_fetch_array($eularesult);
        $eulaStatus        = $roweula['EulaStatus'];
        $euladaydate       = strtotime(date('Y-m-d',strtotime($roweula['EulaDate'])));
        $currentDate       = strtotime(date('Y-m-d'));
        $logindatediff     = ($currentDate - $euladaydate)/60/60/24;
        $eulayeardate      = strtotime(date('Y-m-d',strtotime($roweula['createdAt'])));
        $logindateyeardiff = ($currentDate - $eulayeardate)/60/60/24;

        $dtExp       = DateTime::createFromFormat('Y-m-d H:i:s', $row['Passexpdate']);
        if(!$dtExp) $dtExp = DateTime::createFromFormat('Y-m-d', $row['Passexpdate']);
        $Passexpdate = $dtExp ? strtotime($dtExp->format('Y-m-d')) : 0;
        $passexpday  = ($currentDate - $Passexpdate)/60/60/24;

        $rescountQuery      = mysqli_query($conn, "SELECT count(1) as Check_multiple_status from tbl_login where bit_deleted_flag=0 and email='".$email."'");
        $fetchrescountQuery = mysqli_fetch_assoc($rescountQuery);

        if($fetchrescountQuery['Check_multiple_status']>=1 && $row['active_inactive_status']==0){
            $passwordmsg = "Please authorise yourself";
        }
        else if($passexpday>=90 && $fetchrescountQuery['Check_multiple_status']>=1){
            header('Location: Passexp');
        }
        else if($logindateyeardiff>=366 && $fetchrescountQuery['Check_multiple_status']>=1){
            header('Location: EULA?val=1');
        }
        else if($fetchrescountQuery['Check_multiple_status']>=1 && $eulaStatus==0){
            header('Location: EULA');
        }
        else if($fetchrescountQuery['Check_multiple_status']>=1 && $eulaStatus==1 && $logindatediff>=90){
            header('Location: EULA');
        }
        else if($fetchrescountQuery['Check_multiple_status']>=1 && $eulaStatus==1 && $logindatediff<90){
            $date = date('Y-m-d H:i:s');
            $eulaloginDetails = "UPDATE MANAGE_EULA SET EulaDate='".$date."' WHERE UserId=".$id."";
            mysqli_query($conn, $eulaloginDetails);

            // Log login only when all fields present
            if($fullName!='' && $email!='' && $ipAddress!=''){
                $qryloginDetails = "INSERT INTO logged_in_logs(`userName`,`emailId`,`ipAddress`,`browserDetails`,`LoggedinWith`) VALUES ('$fullName','$email','$ipAddress','$agent','$host_name')";
                mysqli_query($conn, $qryloginDetails);
            }


            
            if($fetchrescountQuery['Check_multiple_status']>1){
                $_SESSION['email'] = $email;
                header('Location: loginnew');
            }
            else if($_SESSION['role']==9){
                header('Location: judgment_layout.php');
            } else {
                if(isset($_SESSION['settlement_number'])){
                    header('Location: Settlement_Form/settlement-request');
                } else if(isset($_SESSION['urlloc'])){
                    header('Location: mydownload');
                } else {
                    header('Location: inventory_layout.php');
                }
            }
        }
    }
}
/* =========================================================
   STEP B — OTP form submitted
   ========================================================= */
if(isset($_POST['verify_otp'])){
    $otpInput  = trim($_POST['otp_code']);
    $otpUserId = (int)$_SESSION['otp_login_user_id'];

    if($otpUserId > 0){
        $otpResult = mysqli_query($conn, "SELECT * FROM tbl_login WHERE id=".$otpUserId." LIMIT 1");
        $otpRow    = mysqli_fetch_array($otpResult);

        if($otpRow){
            $storedOtp    = trim($otpRow['otp_code']);
            $otpCount     = (int)$otpRow['otp_count'];
            $otpCreatedAt = $otpRow['otp_created_at'];

            if($otpCount >= 5){
                // Locked — 5 wrong attempts (PDF fix: OTP count)
                $otpErrorMsg   = 'Too many OTP attempts. Please log in again to generate a new OTP.';
                $showLoginForm = true;
                $showOtpForm   = false;

            } else if($otpCreatedAt != '' && (time() - strtotime($otpCreatedAt)) > 300){
                // Expired — 5 minutes (PDF fix: OTP expiry)
                $otpErrorMsg   = 'OTP expired. Please log in again to generate a new OTP.';
                $showLoginForm = true;
                $showOtpForm   = false;

            } else if($otpInput != '' && $storedOtp === $otpInput){
                // Correct OTP
                $trustChoice   = isset($_SESSION['otp_trust_choice']) ? $_SESSION['otp_trust_choice'] : 'yes';
                $currentDevice = isset($_SESSION['otp_login_device'])  ? $_SESSION['otp_login_device']  : '';

                // Always save device to trusted list (No/one-time option removed)
                if($currentDevice != ''){
                    // Save device to trusted list max 5
                    $existingDevices = array_values(array_filter(array_unique(explode(',', $otpRow['device_ids'])), fn($v) => trim($v) !== ''));
                    if(!in_array($currentDevice, $existingDevices)) $existingDevices[] = $currentDevice;
                    if(count($existingDevices) > 5) $existingDevices = array_slice($existingDevices, -5);
                    mysqli_query($conn, "UPDATE tbl_login SET device_ids='".implode(',', $existingDevices)."' WHERE id=".$otpUserId);

                    // Save nickname — auto-assign "Device N" if user left it blank
                    $nickname = isset($_SESSION['otp_device_nickname']) ? trim($_SESSION['otp_device_nickname']) : '';
                    if($nickname == '') $nickname = isset($_POST['otp_device_nickname']) ? trim($_POST['otp_device_nickname']) : '';

                    // Always save a nickname — generate "Device N" label if user provided nothing
                    $nmMap = ($otpRow['device_nicknames'] != '' && $otpRow['device_nicknames'] !== null)
                        ? json_decode($otpRow['device_nicknames'], true) : [];
                    if(!is_array($nmMap)) $nmMap = [];

                    if($nickname == ''){
                        // Count how many devices are already trusted to pick the next number
                        $existingDeviceCount = count(array_values(array_filter(
                            array_unique(explode(',', $otpRow['device_ids'])),
                            fn($v) => trim($v) !== ''
                        )));
                        $nickname = 'Device ' . ($existingDeviceCount + 1);
                    }

                    $nmMap[$currentDevice] = $nickname;
                    mysqli_query($conn, "UPDATE tbl_login SET device_nicknames='".mysqli_real_escape_string($conn, json_encode($nmMap, JSON_UNESCAPED_UNICODE))."' WHERE id=".$otpUserId);

                    // Save device→IP mapping so the removal panel can show IP alongside device name
                    $loginIp = $_SERVER['REMOTE_ADDR'];
                    if($loginIp === '::1') $loginIp = '127.0.0.1';
                    $ipMap   = ($otpRow['device_ip_map'] != '') ? json_decode($otpRow['device_ip_map'], true) : [];
                    if(!is_array($ipMap)) $ipMap = [];
                    $ipMap[$currentDevice] = $loginIp;
                    mysqli_query($conn, "UPDATE tbl_login SET device_ip_map='".mysqli_real_escape_string($conn, json_encode($ipMap, JSON_UNESCAPED_UNICODE))."' WHERE id=".$otpUserId);

                    // FIX: Save IPaddress column in STEP B — this was the missing piece causing empty IPaddress
                    $existingIPsB = array_values(array_filter(array_unique(explode(',', $otpRow['IPaddress'])), fn($v) => trim($v) !== ''));
                    if(!in_array($loginIp, $existingIPsB)){
                        if(count($existingIPsB) >= 5) array_shift($existingIPsB);
                        $existingIPsB[] = $loginIp;
                    }
                    mysqli_query($conn, "UPDATE tbl_login SET IPaddress='".implode(',', $existingIPsB)."' WHERE id=".$otpUserId);
                }

                // Clear OTP after use (PDF fix)
                mysqli_query($conn, "UPDATE tbl_login SET otp_code=NULL, otp_count=0, otp_created_at=NULL WHERE id=".$otpUserId);
                unset($_SESSION['otp_trust_choice'], $_SESSION['otp_device_nickname']);
                $_SESSION['otp_login_resume'] = 1;
                header('Location: '.$_SERVER['PHP_SELF']);
                exit();

            } else {
                // Wrong OTP — increment counter (PDF fix: OTP count)
                mysqli_query($conn, "UPDATE tbl_login SET otp_count=otp_count+1 WHERE id=".$otpUserId);
                $otpErrorMsg    = 'Invalid OTP. Please check and re-enter it.';
                $showLoginForm  = false;
                $showOtpForm    = true;
                $otpPendingName = isset($_SESSION['otp_login_name']) ? $_SESSION['otp_login_name'] : '';
            }
        }
    }
}

/* =========================================================
   STEP C — Device trust (always Yes — one-time No option removed)
   ========================================================= */
if(isset($_POST['device_trust_choice'])){
    $choiceUserId = (int)$_SESSION['otp_login_user_id'];
    $trustChoice  = 'yes'; // always yes — No/one-time option removed
    $nickname     = isset($_POST['device_nickname']) ? trim($_POST['device_nickname']) : '';

    if($choiceUserId > 0){
        $_SESSION['otp_trust_choice']    = $trustChoice;
        $_SESSION['otp_device_nickname'] = $nickname;

        $choiceResult = mysqli_query($conn, "SELECT * FROM tbl_login WHERE id=".$choiceUserId." LIMIT 1");
        $choiceRow    = mysqli_fetch_array($choiceResult);

        if($choiceRow){
            // Generate 6-digit OTP — always numeric, never starts with = (PDF fix)
            $otp = (string)random_int(100000, 999999);
            $now = date('Y-m-d H:i:s');
            // Store OTP, reset count to 0, save timestamps in YYYY-MM-DD HH:MM:SS (PDF fix)
            mysqli_query($conn, "UPDATE tbl_login SET otp_code='".$otp."', otp_count=0, otp_created_at='".$now."', otp_mail_time='".$now."' WHERE id=".$choiceUserId);

            // Send OTP email
            $subject = 'Your login OTP';
            $message = "Hello ".$choiceRow['fullName'].",\n\nYour login OTP is: ".$otp."\nIt will expire in 5 minutes.\n";
            $headers = "From: no-reply@localhost\r\nContent-Type: text/plain; charset=UTF-8\r\n";
            if(function_exists('mail')) @mail($choiceRow['email'], $subject, $message, $headers);
        }

        $showLoginForm  = false;
        $showOtpForm    = true;
        $otpPendingName = isset($_SESSION['otp_login_name']) ? $_SESSION['otp_login_name'] : '';
    }
}

/* =========================================================
   STEP D — Device removal submitted
   ========================================================= */
if(isset($_POST['remove_device_submit'])){
    $removeUserId = (int)$_SESSION['otp_login_user_id'];
    $fpToRemove   = isset($_POST['remove_fingerprint']) ? trim($_POST['remove_fingerprint']) : '';

    if($removeUserId > 0 && $fpToRemove != ''){
        $removeResult = mysqli_query($conn, "SELECT * FROM tbl_login WHERE id=".$removeUserId." LIMIT 1");
        $removeRow    = mysqli_fetch_array($removeResult);

        // Remove selected fingerprint from device list
        $existingDevices = array_values(array_filter(array_unique(explode(',', $removeRow['device_ids'])), fn($fp) => trim($fp) !== '' && $fp !== $fpToRemove));
        mysqli_query($conn, "UPDATE tbl_login SET device_ids='".implode(',', $existingDevices)."' WHERE id=".$removeUserId);

        // Remove nickname for that device
        $nmMap = ($removeRow['device_nicknames'] != '') ? json_decode($removeRow['device_nicknames'], true) : [];
        if(!is_array($nmMap)) $nmMap = [];
        if(isset($nmMap[$fpToRemove])) unset($nmMap[$fpToRemove]);
        mysqli_query($conn, "UPDATE tbl_login SET device_nicknames='".mysqli_real_escape_string($conn, json_encode($nmMap, JSON_UNESCAPED_UNICODE))."' WHERE id=".$removeUserId);

        // BUG FIX (Bug 2): Also remove the IP mapping for the removed device fingerprint
        $ipMapD = ($removeRow['device_ip_map'] != '') ? json_decode($removeRow['device_ip_map'], true) : [];
        if(!is_array($ipMapD)) $ipMapD = [];
        if(isset($ipMapD[$fpToRemove])) unset($ipMapD[$fpToRemove]);
        mysqli_query($conn, "UPDATE tbl_login SET device_ip_map='".mysqli_real_escape_string($conn, json_encode($ipMapD, JSON_UNESCAPED_UNICODE))."' WHERE id=".$removeUserId);

        // BUG FIX (Bug 1): Ensure session vars are set before showing new-device-choice panel
        // (otp_login_user_id and otp_login_device should already be in session from STEP E,
        //  but guard explicitly so the trust-choice panel works correctly)
        if(!isset($_SESSION['otp_login_user_id']) || $_SESSION['otp_login_user_id'] != $removeUserId){
            $_SESSION['otp_login_user_id'] = $removeUserId;
        }

        $showLoginForm       = false;
        $showNewDeviceChoice = true;
    }
}

/* =========================================================
   STEP F — IP removal submitted by user
   After IP is removed, check the device list:
     • device already trusted  → resume login directly
     • device list also full   → show device removal panel
     • device list has room    → show new-device trust panel
   ========================================================= */
if(isset($_POST['remove_ip_submit'])){
    $removeIpUserId = (int)($_SESSION['otp_login_user_id'] ?? 0);
    $ipToRemove     = trim($_POST['remove_ip'] ?? '');

    if($removeIpUserId > 0 && $ipToRemove !== ''){
        $removeIpRow = mysqli_fetch_assoc(
            mysqli_query($conn, "SELECT * FROM tbl_login WHERE id=".$removeIpUserId." LIMIT 1")
        );

        if($removeIpRow){
            // 1. Remove the chosen IP and save the new pending IP
            $newCurrentIp = $_SESSION['otp_pending_ip'] ?? '';
            $existingIPs  = array_values(array_filter(
                array_unique(explode(',', $removeIpRow['IPaddress'])),
                fn($v) => trim($v) !== '' && $v !== $ipToRemove
            ));
            if($newCurrentIp !== '' && !in_array($newCurrentIp, $existingIPs)){
                $existingIPs[] = $newCurrentIp;
            }
            if(count($existingIPs) > 5) $existingIPs = array_slice($existingIPs, -5);
            mysqli_query($conn,
                "UPDATE tbl_login SET IPaddress='".implode(',', $existingIPs)."' WHERE id=".$removeIpUserId
            );

            // BUG FIX (Bug 3 & 6): Re-fetch fresh row AFTER the IP update so device list data is current
            $removeIpRow = mysqli_fetch_assoc(
                mysqli_query($conn, "SELECT * FROM tbl_login WHERE id=".$removeIpUserId." LIMIT 1")
            );

            // 2. Check the device list to decide which panel to show next
            $currentDevice     = $_SESSION['otp_login_device'] ?? '';
            $trustedDevicesRaw = array_values(array_filter(
                array_unique(explode(',', $removeIpRow['device_ids'])),
                fn($v) => trim($v) !== ''
            ));

            unset($_SESSION['otp_pending_ip']);
            $showLoginForm = false;

            if(in_array($currentDevice, $trustedDevicesRaw)){
                // Device already trusted — go straight to login resume
                $_SESSION['otp_login_resume'] = 1;
                header('Location: '.$_SERVER['PHP_SELF']);
                exit();

            } else if(count($trustedDevicesRaw) >= 5){
                // Device list ALSO full — show device removal panel with name + IP
                $showRemoveDevice = true;
                $nmMap = ($removeIpRow['device_nicknames'] !== '')
                    ? (json_decode($removeIpRow['device_nicknames'], true) ?? []) : [];
                $ipMap = ($removeIpRow['device_ip_map'] !== '')
                    ? (json_decode($removeIpRow['device_ip_map'], true) ?? []) : [];

                // FIX: fill any missing IP entries with current login IP so "IP not recorded" never shows
                $ipMapChanged = false;
                foreach($trustedDevicesRaw as $fp){
                    if(!isset($ipMap[$fp]) || trim($ipMap[$fp]) === ''){
                        $ipMap[$fp]   = $_SERVER['REMOTE_ADDR'];
                        $ipMapChanged = true;
                    }
                }
                if($ipMapChanged){
                    mysqli_query($conn, "UPDATE tbl_login SET device_ip_map='".mysqli_real_escape_string($conn, json_encode($ipMap, JSON_UNESCAPED_UNICODE))."' WHERE id=".$removeIpUserId);
                }

                $idx = 1;
                foreach($trustedDevicesRaw as $fp){
                    $label   = (isset($nmMap[$fp]) && $nmMap[$fp] !== '')
                        ? htmlspecialchars($nmMap[$fp], ENT_QUOTES, 'UTF-8') : 'Device '.$idx;
                    $assocIp = htmlspecialchars($ipMap[$fp], ENT_QUOTES, 'UTF-8'); // always has a value now
                    $trustedDeviceList[] = ['fingerprint' => $fp, 'label' => $label, 'ip' => $assocIp];
                    $idx++;
                }

            } else {
                // Device list has room — show new-device trust choice
                $showNewDeviceChoice = true;
            }
        }
    }
}


/* =========================================================
   STEP E — Main login form submitted
   ========================================================= */
if(isset($_POST['but_submit'])){
    $agent               =$_SERVER['HTTP_USER_AGENT'];
    $ipAddress           =$_SERVER['REMOTE_ADDR']; 
    if($ipAddress === '::1') $ipAddress = '127.0.0.1';
    $host_name           =gethostname();
    $email               =trim($_POST['txt_uname']);
    $pass                =trim($_POST['txt_pwd']);
     $postemail           =htmlspecialchars($email,ENT_QUOTES, 'UTF-8');//echo $postemail;exit;
    $password            =htmlspecialchars($pass,ENT_QUOTES, 'UTF-8');
    $encrypted_string = md5($password);
    $date             =date('Y-m-d H:i:s');

    // Device fingerprint from JS (PDF fix: browser + screen + connection → SHA-256)
    $jsFpRaw       = isset($_POST['device_fp_raw']) ? trim($_POST['device_fp_raw']) : '';
    $currentDevice = ($jsFpRaw != '') ? hash('sha256', strtolower($jsFpRaw)) : '';

    if($postemail==''){
            $Emailmsg="User id can not be left blank";
    }
    if($password == ''){
     $passwordmsg="Password id can not be left blank";
    }
    if ($postemail != "" && $password != ""){
       $sql_query = "select count(*) as cntUser,UserGroup,id,fullName,vchPassword,email,LastName,companyId,userType,state,portfolioCode,role,productCode,firmCode,clientCode,loginStatus,createdAt,Check_multiple_status,Passexpdate,IPaddress,AuthorisedFlag,active_inactive_status,bit_deleted_flag,company_status,device_ids,device_nicknames,device_ip_map from tbl_login where email='".$postemail."' and bit_deleted_flag=0 and  vchPassword !='' and company_status!=4 group by id,fullName,vchPassword,email,LastName,companyId,userType,state,portfolioCode,role,productCode,firmCode,clientCode,loginStatus,createdAt,Check_multiple_status,Passexpdate,IPaddress,AuthorisedFlag,active_inactive_status,bit_deleted_flag,company_status,device_ids,device_nicknames,device_ip_map";

        $result = mysqli_query($conn,$sql_query);
        $row = mysqli_fetch_assoc($result);
        $count          = $row['cntUser'];
    $loginStatus    = $row['loginStatus'];
            $userType       =$row['userType'];
            $state          =$row['state'];
            $portfolioCode  =$row['portfolioCode'];
            $role           =$row['role'];
            $role1          =$row['role'];
            $fullName       =$row['fullName'];
            $email          =$row['email'];
            $userloginType  =$row['userloginType'];
            $productCode    =$row['productCode'];
            $firmCode       =$row['firmCode'];
            $clientCode     =$row['clientCode'];
            $companyId      =$row['companyId'];
            $LastName       =$row['LastName'];
            $passwordDB     =$row['vchPassword'];
            $id             =$row['id'];
           $dateex = DateTime::createFromFormat('Y-m-d H:i:s', $row['Passexpdate']);
if (!$dateex) $dateex = DateTime::createFromFormat('Y-m-d', $row['Passexpdate']);
if (!$dateex) $dateex = DateTime::createFromFormat('m-d-Y', $row['Passexpdate']);
$Passexpdate = $dateex ? strtotime($dateex->format('Y-m-d')) : strtotime(date('Y-m-d', strtotime('+90 days')));
            // BUG FIX (Bug 5): filter empty strings so count is always accurate
            $IPaddress      = array_values(array_filter(array_unique(explode(',', $row['IPaddress'])), fn($v) => trim($v) !== ''));
            $countIPaddress = count($IPaddress);
            $AuthorisedFlag =$row['AuthorisedFlag'];
            $active_inactive_status=$row['active_inactive_status'];


        $_SESSION['id'] = $id;
        if($role==6 || $role==10){
            $role=6;
        }else {
            $role=$role;
        }

//print_r($mac);exit;

        if(strtolower($postemail)!=strtolower($email)){
            $Emailmsg="Invalid userid";
        } 
        else  if($encrypted_string!= $passwordDB){
            $passwordmsg="Invalid Password";
        }
        // else if($countIPaddress ==5 && (!in_array($ipAddress, $IPaddress))){
         //   $unauthusermore="More than 5 devices exceeded, cannot be authenticated. Please contact admin.";
         //   $updatestatus="UPDATE tbl_login SET AuthorisedFlag=1  WHERE  email='".$email."'";
         //    mysqli_query($conn,$updatestatus);
         //  }
          //  else if(!in_array($ipAddress, $IPaddress)){
          //   $unauthuser="Device not verified, please check email for verification code.";
            
          // }
          // HG-11/04/2026 
else {
    // 1. Check user status
    $userResult = mysqli_query($conn, "SELECT Status FROM manage_user WHERE UserId=" . $id . " LIMIT 1");
    $userRow    = mysqli_fetch_assoc($userResult);
    if ($userRow) {
        $userIsActive = ((int)$userRow['Status'] === 1);
    } else {
        $userIsActive = ($AuthorisedFlag == 1);
    }

    // 2. Check company status
    $compResult = mysqli_query($conn, "SELECT Status FROM manage_company_registry WHERE CompanyId='" . $companyId . "' LIMIT 1");
    $compRow    = mysqli_fetch_assoc($compResult);
    if ($compRow) {
        $companyIsActive = ((int)$compRow['Status'] === 1);
    } else {
        $companyIsActive = ($companyStatus === 1);
    }

    if (!$userIsActive) {
        $passwordmsg = "Your account is not active. Please contact your administrator.";
    } else if (!$companyIsActive) {
        $passwordmsg = "Company is inactive or terminated.";
    }

if ($passwordmsg == '') {

        // Get trusted devices list
        $trustedDevicesRaw = array_values(array_filter(
            array_unique(explode(',', $row['device_ids'])),
            fn($v) => trim($v) !== ''
        ));

        if(in_array($currentDevice, $trustedDevicesRaw)){
                    // Known device — go straight to login (no OTP needed)
           $_SESSION['userType']     = $userType;
            $_SESSION['state']        = $state;
            $_SESSION['portfolioCode']= $portfolioCode;
            $_SESSION['role']         = $role;
            $_SESSION['role60r10']    = $role1;
            $_SESSION['fullName']     = $fullName;
            $_SESSION['userloginType']= $userloginType;
            $_SESSION['productCode']  = $productCode;
            $_SESSION['firmCode']     = $firmCode;
            $_SESSION['clientCode']   = $clientCode;
            $_SESSION['companyId']    = $companyId;
            $_SESSION['LastName']     = $LastName;
            $_SESSION['id']           = $id;
            $_SESSION['UserGroup']    = $row['UserGroup'];
            $_SESSION['phoneNo']      = $row['phoneNo'];
            $_SESSION['timeout']      = time();
            $_SESSION['firmCodenew']     = $firmCode;
            $_SESSION['clientCodenew']   = $clientCode;


            $_SESSION['AACA_RCVD_BATCH_FROM'] = $DATE1;
            $_SESSION['AACA_RCVD_BATCH_END'] = $DATE2;
            $_SESSION['AACA_RCVD_BATCH_FROM_PIE'] = '2002-01';
            $_SESSION['AACA_RCVD_BATCH_END_PIE'] = $DATE2;

            $_SESSION['SETLMNT_BATCH_FROM'] = $DATE1;
            $_SESSION['SETLMNT_BATCH_END'] = $DATE2;

            $_SESSION['AACA_RCVD_BATCH_FROM_TIMELINE'] = $DATE4;
            $_SESSION['AACA_RCVD_BATCH_END_TIMELINE'] = $DATE2;


// Update device→IP map for this trusted device on every login
// Update device→IP map for this trusted device on every login
$ipMapUpdate = ($row['device_ip_map'] != '') ? json_decode($row['device_ip_map'], true) : [];
if(!is_array($ipMapUpdate)) $ipMapUpdate = [];
$ipMapUpdate[$currentDevice] = $ipAddress;
mysqli_query($conn, "UPDATE tbl_login SET device_ip_map='".mysqli_real_escape_string($conn, json_encode($ipMapUpdate, JSON_UNESCAPED_UNICODE))."' WHERE id=".$id);

// FIX: Also save IPaddress column for trusted device logins
$existingIPsTrusted = array_values(array_filter(array_unique(explode(',', $row['IPaddress'])), fn($v) => trim($v) !== ''));
if(!in_array($ipAddress, $existingIPsTrusted)){
    if(count($existingIPsTrusted) >= 5) array_shift($existingIPsTrusted);
    $existingIPsTrusted[] = $ipAddress;
}
mysqli_query($conn, "UPDATE tbl_login SET IPaddress='".implode(',', $existingIPsTrusted)."' WHERE id=".$id);

            $eulaQue="Select * from MANAGE_EULA where UserId=".$id."";
       $eularesult = mysqli_query($conn,$eulaQue);
       $roweula = mysqli_fetch_array($eularesult);
       $eulaStatus= $roweula['EulaStatus'];
       $euladaydate=strtotime(date('Y-m-d',strtotime($roweula['EulaDate'])));
       $currentDate=strtotime(date('Y-m-d'));
       $logindatediff=($currentDate - $euladaydate)/60/60/24;

      $eulayeardate     =strtotime(date('Y-m-d',strtotime($roweula['createdAt'])));
       $logindateyeardiff=($currentDate - $eulayeardate)/60/60/24;
                          $passexpday       =($currentDate - $Passexpdate)/60/60/24;

  $countQuery="SELECT count(1) as Check_multiple_status  from tbl_login where  bit_deleted_flag=0 and email='".$postemail."'";//echo $countQuery;exit;
       $rescountQuery=mysqli_query($conn,$countQuery);
       $fetchrescountQuery=mysqli_fetch_assoc($rescountQuery);

// if($row['bit_deleted_flag']!=$active_inactive_status){
//   $passwordmsg="Please authorise yourself";
//   }  


                    // FIX: was ==1 (wrong — blocked active users). Now ==0 matches STEP A logic (blocks inactive users only)
                    if($fetchrescountQuery['Check_multiple_status']>=1 && $active_inactive_status==0){
                        $passwordmsg="Please authorise yourself";
                    }
                    else if($passexpday>=90 && $fetchrescountQuery['Check_multiple_status']>=1){
                        header('Location: Passexp');
                    }else if($logindateyeardiff >= 366 && $fetchrescountQuery['Check_multiple_status']>=1){
                        header('Location: EULA?val=1');
                    }


                    else if($count > 0 && $eulaStatus==1 && $logindatediff <90   && $fetchrescountQuery['Check_multiple_status']>=1){//$loginStatus==1 && 
                        $date=date('Y-m-d H:i:s');
   $eulaloginDetails = "UPDATE MANAGE_EULA SET EulaDate='". $date."' WHERE UserId=".$id."" ;
   $eulaupdate = mysqli_query($conn,$eulaloginDetails);
//header('Location: inventory_layout.php');

  /*to show path based on usertype and role*/
                        // Log login — only when all fields present (PDF fix: no NULL in logs)
                        if($fullName!='' && $email!='' && $ipAddress!=''){
                            $qryloginDetails = "INSERT INTO logged_in_logs(`userName`,`emailId`,`ipAddress`,`browserDetails`,`LoggedinWith`) VALUES ('$fullName','$email','$ipAddress','$agent','$host_name')";
                            mysqli_query($conn, $qryloginDetails);
                        }

// BUG FIX (Bug 4 & 5): For a TRUSTED device, silently manage IP list — never show IP-removal panel.
// Filter empty strings first (Bug 5) so count is accurate.
                        $existingIPs = array_values(array_filter(
                            array_unique(explode(',', $row['IPaddress'])),
                            fn($v) => trim($v) !== ''
                        ));
                        if(in_array($ipAddress, $existingIPs)){
                            // IP already known — no change needed
                        } else {
                            // New IP — add it; if at limit, silently drop the oldest one
                            if(count($existingIPs) >= 5){
                                array_shift($existingIPs); // remove oldest
                            }
                            $existingIPs[] = $ipAddress;
                        }
                        mysqli_query($conn, "UPDATE tbl_login SET IPaddress='".implode(',', $existingIPs)."' WHERE id=".$id);

                        // Redirect after successful trusted-device login
                        if($fetchrescountQuery['Check_multiple_status']>1){
                                $_SESSION['email'] = $email;
                                header('Location: loginnew');
                            }
                            else if($_SESSION['role']==9){
                                header('Location: judgment_layout');
                            } else {
                                if(isset($_SESSION['settlement_number'])){
                                    header('Location: Settlement_Form/settlement-request');
                                } else if(isset($_SESSION['urlloc'])){
                                    header('Location: mydownload');
                                }else {
                                    header('Location: inventory_layout.php');
                                }
                            }
                        /*to show path based on usertype and role*/

                    }
                     
                    else if($count > 0 && $eulaStatus==0  && $fetchrescountQuery['Check_multiple_status']>=1){//$loginStatus==1 && 
                        header('Location: EULA');
                    }
                    else if($count > 0 && $eulaStatus==1 &&  $logindatediff >=90  && $fetchrescountQuery['Check_multiple_status']>=1){//$loginStatus==1 && 
                        header('Location: EULA');
                    }
                    // else if($loginStatus==0 && $count>0  && $row['Check_multiple_status']==0){ 
                    //   $_SESSION['email'] = $email;

                    // header('Location: changepassword');
                    // }


                    else {
                        $msg="Invalid userid or password";
                    }

        } else if(is_array($trustedDevicesRaw) && count($trustedDevicesRaw) >= 5){
                    // Device list full — show remove panel
                    $showLoginForm    = false;
                    $showRemoveDevice = true;

                    $nmMap = ($row['device_nicknames'] != '') ? json_decode($row['device_nicknames'], true) : [];
                    if(!is_array($nmMap)) $nmMap = [];

                    $ipMap = ($row['device_ip_map'] != '') ? json_decode($row['device_ip_map'], true) : [];
                    if(!is_array($ipMap)) $ipMap = [];

                    // FIX: fill any missing IP entries with current login IP so "IP not recorded" never shows
                    $ipMapChanged = false;
                    foreach($trustedDevicesRaw as $fp){
                        if(!isset($ipMap[$fp]) || trim($ipMap[$fp]) === ''){
                            $ipMap[$fp]   = $ipAddress;
                            $ipMapChanged = true;
                        }
                    }
                    if($ipMapChanged){
                        mysqli_query($conn, "UPDATE tbl_login SET device_ip_map='".mysqli_real_escape_string($conn, json_encode($ipMap, JSON_UNESCAPED_UNICODE))."' WHERE id=".$id);
                    }

                    $idx = 1;
                    foreach($trustedDevicesRaw as $fp){
                        $label   = (isset($nmMap[$fp]) && $nmMap[$fp] !== '')
                            ? htmlspecialchars($nmMap[$fp], ENT_QUOTES, 'UTF-8') : 'Device '.$idx;
                        $assocIp = htmlspecialchars($ipMap[$fp], ENT_QUOTES, 'UTF-8'); // always has a value now
                        $trustedDeviceList[] = ['fingerprint' => $fp, 'label' => $label, 'ip' => $assocIp];
                        $idx++;
                    }

                    $_SESSION['otp_login_user_id'] = $id;
                    $_SESSION['otp_login_device']  = $currentDevice;
                    $_SESSION['otp_login_email']   = $email;
                    $_SESSION['otp_login_name']    = $fullName;

        } else if(is_array($trustedDevicesRaw)) {
                    // New/unknown device path
                    $_SESSION['otp_login_user_id'] = $id;
                    $_SESSION['otp_login_device']  = $currentDevice;
                    $_SESSION['otp_login_email']   = $email;
                    $_SESSION['otp_login_name']    = $fullName;

                    // BUG FIX (Bug 4 & 5): Check if IP list is full BEFORE showing trust choice.
                    // For a NEW device, the IP-removal panel should appear here (not in the trusted-device branch).
                    $existingIPsNew = array_values(array_filter(
                        array_unique(explode(',', $row['IPaddress'])),
                        fn($v) => trim($v) !== ''
                    ));

                    if(!in_array($ipAddress, $existingIPsNew) && count($existingIPsNew) >= 5){
                        // IP list is full — ask user which IP to drop first
                        $_SESSION['otp_pending_ip'] = $ipAddress;
                        $showLoginForm  = false;
                        $showRemoveIp   = true;
                        $ipList         = $existingIPsNew;
                    } else {
                        // IP list has room (or IP already present) — ask Yes/No for device trust
                        $showLoginForm       = false;
                        $showNewDeviceChoice = true;
                    }
        }

} // end if($passwordmsg == '')
} // end else (credential checks passed)
    } // end if ($postemail != "" && $password != "")
} // end if(isset($_POST['but_submit']))
        
?>

<!--<div class="loader"></div> -->

<div class="wrapper-login fadeInDown login-section" id="warning-message1">

 <div id="formContent" class="modal-dialog">
      
    <div class="formHeader clearfix">
        <div class="col-sm-12 mar20B">
            <div class="fadeIn first">
              <!--<img src="assets/gallery/ko-logo.png" class="img-resposnive login-logo" alt="User Icon"/><br>-->
                <div class="col-sm-6">
                    <img src="img/aaca-net.png" class="img-resposnive login-logo  ml10 f_wid" alt="aacanet"/>
                </div>
                <div class="col-sm-6 text-center">
                    <!--<h1>PIPEWAY</h1>-->
                    <img src="img/pipeway-logo.gif" class="img-resposnive login-logo  mt10 f_wid" alt="aacanet"/>
                </div>
            </div>
        </div>
    
    <div class="col-sm-12">
             <?php if ($msg !== '') : ?>
          <p style="color:red; font-size:12px; text-align:center;">
            <?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?>
          </p>
        <?php endif; ?>

         <!-- ═════════════════════════════════════════════════════════════════
             PANEL 1 — STANDARD LOGIN FORM
             ═════════════════════════════════════════════════════════════════ -->
             <?php if ($showLoginForm) : ?>
        <form action="" id="loginForm" method="post" autocomplete="off">

              <!--
            HIDDEN FIELD: device_fp_raw
            JavaScript fills this before form submit with:
              • navigator.userAgent   — which browser
              • screen.width x height — screen size
              • connection type       — internet connection
            PHP hashes it with SHA-256 = device fingerprint.
            PDF fix (Option 1): website makes its own ID to recognize the device.
          -->
            <input type="hidden" id="device_fp_raw" name="device_fp_raw" value="" />

           <span style="color:red"><?php echo $unauthuser;?></span>
         <span style="color:red"><?php echo $unauthusermore;?></span>
        <div class="form-group clearfix">
         <div class="input-group fadeIn second user">
          <span class="input-group-addon" style="background-color: #eeeeee0a;
    border-bottom: 0px solid #28648A;color: #012f5c;transition: all .5s ease;background-color: rgba(0, 0, 0, 0);border-radius:10px;"><i class="fa fa-user" aria-hidden="true"></i></span> 
  
            <span class="clearable">
            <input type="text" class="bor" id="email" name="txt_uname" placeholder="User name" maxlength="50" value="<?php echo isset($_POST["txt_uname"]) ? $_POST["txt_uname"] : ''; ?>" / autofocus>
              <i class="clearable__clear" style="display: inline;">&times;</i>
          </span>
          </div>
          <span style="color:red;font-size: 11px;margin-left: 45px;margin-bottom:0px;"><?php echo $Emailmsg;?></span>
        </div>
        <div class="form-group clearfix">
         <div class="input-group fadeIn third user">
           <span class="input-group-addon" style="background-color: #eeeeee0a;
    border-bottom: 0px solid #28648A;color: #012f5c;transition: all .5s ease;background-color: rgba(0, 0, 0, 0);border-radius:10px;"><i class="fa fa-lock" aria-hidden="true"></i></span> 
<!--           <input type="password" id="password" class="" name="password" placeholder="Password"> -->
            <span class="clearable">
           <input type="password" class="bor" id="password" name="txt_pwd" placeholder="Password" value="<?php echo isset($_POST["txt_pwd"]) ? $_POST["txt_pwd"] : ''; ?>"/ maxlength="20" autofocus>
             <i class="clearable__clear" style="display: inline;">&times;</i>
         </span>
        </div>
        <p style="color:red;font-size: 11px;margin-left: 45px;margin-bottom:0px;"><?php echo $passwordmsg;?></p>
        <?php if($Emailmsg!='' || $passwordmsg!='') {?>
        <p style="color:#607D8B;font-size: 11px;width: 100%;margin-left: 8px;margin-top:5px;">Please enter your user name and password. If you do not have a user name and password, please contact your company's Pipeway Administrator.  If you forgot your user name or password, contact your company's Pipeway Administrator or use the link below. </p>
      <?php }?>
        </div>
       <!--   <span class="loginmsg"><?php //echo $msg;?></span> -->
        <div class="form-group clearfix">
          <button type="submit" class="fadeIn fourth f_wid" name="but_submit" id="but_submit" style="border-radius: 15px;background: #002e5b;"><i class="fa fa-key" aria-hidden="true"></i> Log In</button>

        <!--   <input type="submit" class="textbox" value="Login" name="but_submit" id="but_submit"  /></br></br> 
               <a href="forgotpassword.php" id="forgotpass"><b>Forgot password ?</b></a>  -->
          
          <!--<br><a class="underlineHover fadeIn fourth" id="forgotpass" href="forgotpassword.php">Forgot Password?</a>--->
        </div>
		<div class="col-md-12" style="text-align:center;">
		<a class="underlineHover fadeIn fourth" id="forgotpass" href="forgotpassword">Forgot Password?</a>
		</div>
    </form>
    </div>

    </div>
    
<!--    <div id="formFooter">
      <a class="underlineHover fadeIn fourth" href="register.html#">Register here</a>
    </div> -->
  <section>
	  <div class="col-sm-8 p0"></div>
	  <div class="col-sm-4 p0" style="position: relative;bottom: 65px;">
        <div class="linkedin" style="" title="Connect wih us!">
          <a href="https://www.linkedin.com/company/aacanet-inc." target="blank"  title="Connect with us!" style="color:#fff;">
          <i class="fa fa-linkedin fa-x" style="padding: 8px 10px;"></i></a>
        </div>
	  </div>
	</section>
   </div>  
 </div>
        </form>
        <?php endif; ?>

        <!-- ═════════════════════════════════════════════════════════════════
             PANEL 2 — NEW DEVICE DETECTED
             ═════════════════════════════════════════════════════════════════ -->
        <?php if ($showNewDeviceChoice) : ?>
        <div class="device-panel">

          <h5>
            <i class="fa fa-laptop" aria-hidden="true"></i>&nbsp;
            New Device Detected
          </h5>

          <p>
            We have not seen this device before.<br>
            Give this device a nickname (optional) and click below to receive your OTP.
          </p>

          <form action="" method="post" id="deviceChoiceYesForm">
            <input type="hidden" name="device_trust_choice" value="1">
            <input type="hidden" name="trust_choice" value="yes">

            <label for="device_nickname"
                   style="font-size:12px; color:#002e5b; font-weight:600;">
              Give this device a nickname (optional):
            </label>
            <input type="text"
                   id="device_nickname"
                   name="device_nickname"
                   class="device-nickname-input"
                   placeholder="e.g. Office PC, My Laptop"
                   maxlength="60">

            <button type="submit" class="device-choice-btn btn-primary-solid">
              <i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;
              Send OTP
            </button>
          </form>

        </div>
        <?php endif; ?>

        <!-- ═════════════════════════════════════════════════════════════════
             PANEL 3 — TRUSTED DEVICE LIMIT REACHED (Remove One)
             ─────────────────────────────────────────────────────────────────
             PDF fix: "give them a list of their trusted login devices and
             allow them to choose which one to remove."
             ═════════════════════════════════════════════════════════════════ -->
        <?php if ($showRemoveDevice) : ?>
        <div class="device-panel">

          <h5>
            <i class="fa fa-shield" aria-hidden="true"></i>&nbsp;
            Trusted Device Limit Reached
          </h5>

          <p>
            You already have <strong>5 trusted devices</strong>.<br>
            Please remove one device from the list below to add this new device.
          </p>

          <form action="" method="post" id="removeDeviceForm">
            <input type="hidden" name="remove_device_submit" value="1">

            <?php foreach ($trustedDeviceList as $dv) : ?>
            <div class="device-list-item">
              <input type="radio"
                     name="remove_fingerprint"
                     id="dev_<?php echo htmlspecialchars($dv['fingerprint'], ENT_QUOTES, 'UTF-8'); ?>"
                     value="<?php echo htmlspecialchars($dv['fingerprint'], ENT_QUOTES, 'UTF-8'); ?>">
              <label for="dev_<?php echo htmlspecialchars($dv['fingerprint'], ENT_QUOTES, 'UTF-8'); ?>">
                <span style="display:flex;flex-direction:column;gap:2px;">
                  <span>
                    <i class="fa fa-laptop" aria-hidden="true"></i>&nbsp;
                    <strong><?php echo $dv['label']; ?></strong>
                  </span>
                  <span style="font-size:11px;color:#607D8B;margin-left:18px;">
                    <i class="fa fa-globe" aria-hidden="true"></i>&nbsp;
                    IP: <?php echo $dv['ip']; ?>
                  </span>
                </span>
              </label>
            </div>
            <?php endforeach; ?>

            <p style="font-size:11px; color:#e53935; margin-top:8px; margin-bottom:10px;">
              * The selected device will be removed from your trusted list immediately.
            </p>

            <button type="submit"
                    class="device-choice-btn btn-primary-solid"
                    onclick="if (!document.querySelector('input[name=remove_fingerprint]:checked')) {
                                 alert('Please select a device to remove.');
                                 return false;
                             }">
              <i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;
              Remove selected &amp; continue
            </button>

          </form>
        </div>
        <?php endif; ?>
        <!-- ═════════════════════════════════════════════════════════════════
             PANEL 4 — IP ADDRESS LIMIT REACHED (User Chooses Which to Remove)
             ═════════════════════════════════════════════════════════════════ -->
        <?php if ($showRemoveIp) : ?>
        <div class="device-panel">

          <h5>
            <i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;
            Trusted IP Limit Reached
          </h5>

          <p>
            You already have <strong>5 saved IP addresses</strong>.<br>
            Please select one to remove so your current IP can be added.
          </p>

          <form action="" method="post" id="removeIpForm">
            <input type="hidden" name="remove_ip_submit" value="1">

            <?php foreach ($ipList as $idx => $savedIp) : ?>
            <div class="device-list-item">
              <input type="radio"
                     name="remove_ip"
                     id="ip_<?php echo $idx; ?>"
                     value="<?php echo htmlspecialchars($savedIp, ENT_QUOTES, 'UTF-8'); ?>">
              <label for="ip_<?php echo $idx; ?>">
                <i class="fa fa-globe" aria-hidden="true"></i>&nbsp;
                <?php echo htmlspecialchars($savedIp, ENT_QUOTES, 'UTF-8'); ?>
              </label>
            </div>
            <?php endforeach; ?>

            <p style="font-size:11px; color:#e53935; margin-top:8px; margin-bottom:10px;">
              * The selected IP will be removed and your current IP will be added.
            </p>

            <button type="submit"
                    class="device-choice-btn btn-primary-solid"
                    onclick="if(!document.querySelector('input[name=remove_ip]:checked')){
                                 alert('Please select an IP address to remove.');
                                 return false;
                             }">
              <i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;
              Remove selected &amp; continue
            </button>

          </form>
        </div>
        <?php endif; ?>

        <!-- ═════════════════════════════════════════════════════════════════
             PANEL 5 — OTP ENTRY SCREEN
             ─────────────────────────────────────────────────────────────────
             User types the 6-digit OTP received by email.
             Valid for 5 minutes. Maximum 5 wrong attempts.
             Errors shown as plain red text directly on this panel.
             ═════════════════════════════════════════════════════════════════ -->
         <?php if ($showOtpForm) : ?> 
        <div class="device-panel">

          <h5>
            <i class="fa fa-envelope-o" aria-hidden="true"></i>&nbsp;
            Enter Your OTP
          </h5>

          <p>
            An OTP has been sent to your registered email address
            <?php if ($otpPendingName !== '') : ?>
              (<strong><?php echo $otpPendingName; ?></strong>)
            <?php endif; ?>.<br>
            <small>
              The OTP is valid for <strong>5 minutes</strong>.
              You have a maximum of <strong>5 attempts</strong>.
            </small>
          </p>

          <!-- Plain red text error message (wrong OTP / expired / locked) -->
          <?php if ($otpErrorMsg !== '') : ?>
          <p class="otp-error-msg">
            <?php echo htmlspecialchars($otpErrorMsg, ENT_QUOTES, 'UTF-8'); ?>
          </p>
          <?php endif; ?>

          <form action="" method="post" id="otpForm">

            <input type="hidden" name="verify_otp" value="1">

            <!--
              Carries the device nickname through the OTP POST as a fallback
              in case the session value is lost between Step C and Step B.
            -->
            <input type="hidden"
                   name="otp_device_nickname"
                   value="<?php echo htmlspecialchars(
                       (string)($_SESSION['otp_device_nickname'] ?? ''),
                       ENT_QUOTES,
                       'UTF-8'
                   ); ?>">

            <div class="form-group">
              <input type="text"
                     name="otp_code"
                     class="otp-input-box"
                     placeholder="_ _ _ _ _ _"
                     maxlength="6"
                     autocomplete="one-time-code"
                     inputmode="numeric"
                     pattern="[0-9]{6}"
                     required
                     autofocus>
            </div>

           <button type="submit"
        class="device-choice-btn btn-primary-solid"
        style="margin-top:6px; width:auto; margin-left:auto; margin-right:auto; display:block; padding:9px 40px;">
              Verify OTP
            </button>

          </form>

          <!-- Back to login link -->
          <div style="margin-top:10px; text-align:center;">
            <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>"
               style="font-size:12px; color:#002e5b;">
              &larr; Back to login
            </a>
          </div>

        </div>
        <?php endif; ?>

      </div><!-- /.col-sm-12 -->
    </div><!-- /.formHeader -->
  </div><!-- /#formContent -->
</div><!-- /.wrapper-login -->

</body>
<script type="text/javascript">

// Device fingerprint — JS collects browser UA + screen size + connection type before submit
(function(){
    function buildFp(){
        var ua  = (navigator.userAgent || '').toLowerCase().trim();
        var scr = screen.width + 'x' + screen.height;
        var con = (navigator.connection && navigator.connection.effectiveType) ? navigator.connection.effectiveType : 'unknown';
        return ua + '|' + scr + '|' + con;
    }
    var f = document.getElementById('device_fp_raw');
    if(f) f.value = buildFp();
    var form = document.getElementById('loginForm');
    if(form) form.addEventListener('submit', function(){ var f = document.getElementById('device_fp_raw'); if(f) f.value = buildFp(); });
})();

  $("#password").keypress(function(event) { 
      if (event.keyCode === 13) { 
          $("#but_submit").click(); 
      } 
  });
  $(document).ready(function(){
    $(".clearable").each(function() {

  var $inp = $(this).find("input:text"),
      $cle = $(this).find(".clearable__clear");

  $inp.on("input", function(){
     $cle.toggle(!!this.value);
     });

  $cle.on("touchstart click", function(e) {
     e.preventDefault();
      $inp.val("").trigger("input");
     });

});
 $(".clearable").each(function() {

  var $inp = $(this).find("input:password"),
      $cle = $(this).find(".clearable__clear");

  $inp.on("input", function(){
     $cle.toggle(!!this.value);
     });

  $cle.on("touchstart click", function(e) { 
    e.preventDefault(); 
    $inp.val("").trigger("input"); 
});

});
  }) 
  var auth ='<?php echo $unauthuser;?>';
if(auth!=''){
  var email='<?php echo $_POST['txt_uname'];?>';
  $.ajax({
  type: "GET",
  url: "authenticate.php",
  data:{email:email},
   success: function(data){
 
   }
 });
}
</script>
<?php
/* Start:Change log sweet alert  by puja kuamri on dt-061021 */
if(isset($_SESSION['forgototp']))
{?>
   <script> swal({title: "",
   text: "OTP has been sent to your email id",
   timer: 3000,
   showConfirmButton: false,
   type: 'success'
   });  </script>
<?php } 
unset($_SESSION['forgototp']);
if(isset($_SESSION['resetforgotpass']))
{?>
   <script> swal({title: "",
   text: "Password created successfully",
   timer: 3000,
   showConfirmButton: false,
   type: 'success'
   });  </script>
<?php } 
unset($_SESSION['resetforgotpass']);


if(isset($_SESSION['authenticate']))
{?>
   <script> swal({title: "",
   text: "User authenticated successfully",
   timer: 3000,
   showConfirmButton: false,
   type: 'success'
   });  </script>
<?php } 
unset($_SESSION['authenticate']);
if(isset($_SESSION['changepass'])){ 
    unset($_SESSION['email']);
    ?>
   <script> swal({title: "",
   text: "Password changed successfully",
   timer: 3000,
   showConfirmButton: false,
   type: 'success'
   });  </script>
<?php }
 unset($_SESSION['changepass']);
/*End: Change log sweet alert  by puja kuamri on dt-061021*/

// Only redirect if a login just completed in this same request
// (i.e. NOT on a fresh page load, and NOT during OTP flow)
if(isset($_SESSION['role']) && isset($_SESSION['email']) && !$showLoginForm && !$showOtpForm && !$showNewDeviceChoice && !$showRemoveDevice && !$showRemoveIp){
    if($_SESSION['role'] == 9){
        header('Location: judgment_layout');
    } else {
        if(isset($_SESSION['settlement_number'])){
            header('Location: Settlement_Form/settlement-request');
        } else {
            header('Location: inventory_layout.php');
        }
    }
}


//$_SESSION["login_time_stamp"] = time(); 

?>



</html>