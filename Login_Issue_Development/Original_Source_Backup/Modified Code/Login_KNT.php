<?php 

//header("X-XSS-Protection: 1; mode=block");
error_reporting(1);
include_once "config_harsh.php";
session_start();

/* ── COOKIE-FIX: Helper functions ──────────────────────────────────── */
function getDeviceName($ua) {
    $ua = $ua ?: 'Unknown';
    $browser = 'Unknown Browser';
    if (preg_match('/Edg\//i', $ua))            $browser = 'Edge';
    elseif (preg_match('/OPR|Opera/i', $ua))     $browser = 'Opera';
    elseif (preg_match('/Chrome/i', $ua))        $browser = 'Chrome';
    elseif (preg_match('/Firefox/i', $ua))       $browser = 'Firefox';
    elseif (preg_match('/Safari/i', $ua))        $browser = 'Safari';
    elseif (preg_match('/MSIE|Trident/i', $ua))  $browser = 'IE';
    $os = 'Unknown OS';
    if (preg_match('/iPhone/i', $ua))              $os = 'iPhone';
    elseif (preg_match('/iPad/i', $ua))            $os = 'iPad';
    elseif (preg_match('/Android/i', $ua))         $os = 'Android';
    elseif (preg_match('/Macintosh|Mac OS/i', $ua)) $os = 'Mac';
    elseif (preg_match('/Windows/i', $ua))         $os = 'Windows';
    elseif (preg_match('/Linux/i', $ua))           $os = 'Linux';
    return $browser . ' on ' . $os;
}
function getNormalizedIp() {
    $ip = $_SERVER['REMOTE_ADDR'];
    if ($ip === '::1') $ip = '127.0.0.1';
    return $ip;
}
function setDeviceCookie($token) {
    setcookie('device_token', $token, [
        'expires'  => time() + (30 * 24 * 60 * 60),
        'path'     => '/',
        'httponly'  => true,
        'samesite' => 'Lax',
        'secure'   => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'),
    ]);
}
?>
<!DOCTYPE html>
<script>
var browser='';var browserVersion=0;
if(/MSIE (\d+\.\d+);/.test(navigator.userAgent)){browser='MSIE';}
if(browserVersion===0){browserVersion=parseFloat(new Number(RegExp.$1));}
if(browserVersion>0&&browserVersion<9){window.location.reload("error_page");}
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
html{background-image:linear-gradient(to bottom right,#BB133E,#002e5b);}
body{background:#ffffff00;}
.clearable__clear{position:absolute;top:6px;}
:focus-visible{outline:-webkit-focus-ring-color auto 0px!important;}
input:-internal-autofill-selected{background-color:#fff!important;}
.wrapper-login button[type=button],.wrapper-login button[type=submit],.wrapper-login button[type=reset]{-webkit-box-shadow:2px 2px 3px #002e5b;box-shadow:2px 2px 3px #002e5b;}
.wrapper-login a{font-size:14px;}
.ml10{margin-left:10px;}.mt10{margin-top:10px;}.f_wid{width:100%;}
.user{background:#ffffff;border:3px solid #002e5b;border-radius:15px;padding:2px 0px;}
.user:hover{box-shadow:6px 6px 8px lightgrey;}
.bor{border-bottom:0px solid #28648A!important;width:100%;border-top-right-radius:9px;border-bottom-right-radius:9px;}
.wrapper-login input[type=text],.wrapper-login input[type=password]{background-color:#e8f0fe!important;}
.p0{padding:0px;}.pr0{padding-right:0px;}
.input-group .input-group-addon:hover{font-size:18px;}
.fourth:hover{box-shadow:2px 2px 4px #002e5b!important;font-size:14px!important;}
.linkedin{background:#3c8dbc;border-top-left-radius:10%;border-bottom-left-radius:10%;color:#fff;height:30px;width:30px;float:right;box-shadow:-6px 6px 7px #d2d6de;}
.linkedin:hover{width:50px!important;border-top-left-radius:10%;border-bottom-left-radius:10%;border-right:none;transition:width 2s,transform 2s;}
.device-panel{background:#fff;border:2px solid #002e5b;border-radius:12px;padding:18px 20px;margin-top:10px;}
.device-panel h5{color:#002e5b;font-weight:700;margin-bottom:12px;font-size:14px;}
.device-panel p{font-size:12px;color:#555;margin-bottom:14px;}
.otp-error-msg{color:red;font-size:12px;margin-bottom:10px;font-weight:600;}
.device-choice-btn{display:block;width:100%;padding:9px 14px;margin-bottom:8px;border-radius:8px;border:2px solid #002e5b;background:#fff;color:#002e5b;font-size:13px;font-weight:600;cursor:pointer;text-align:left;transition:background .2s,color .2s;}
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
<body class="hold-transition skin-yellow sidebar-mini" style="background-color:rgba(0,0,0,0);">
<div id="show"><img src="img/tilt.png" style="width:80px;"><h6>We don't support Mobile view for best experience go to Desktop view</h6></div>
<?php
for($i=1;$i<=36;$i++){$months[]=date("Y-m",strtotime(date('Y-m-01')." -$i months"));}
$DATE1=$months[10];$DATE2=date('Y-m');$DATE4=$months[34];
unset($_SESSION['count']);
$msg="";$Emailmsg='';$passwordmsg='';$unauthuser='';$unauthusermore='';
$showLoginForm=true;$showOtpForm=false;$showNewDeviceChoice=false;$showRemoveDevice=false;
$otpPendingName='';$otpErrorMsg='';$trustedDeviceList=[];

/* ═══════════════════════════════════════════════════════════════════
   STEP A — Resume after correct OTP
   ═══════════════════════════════════════════════════════════════════ */
if(isset($_SESSION['otp_login_resume'])&&$_SESSION['otp_login_resume']==1&&isset($_SESSION['otp_login_user_id'])){
    $resumeUserId=(int)$_SESSION['otp_login_user_id'];
    unset($_SESSION['otp_login_resume']);
    $agent=$_SERVER['HTTP_USER_AGENT'];
    $ipAddress=getNormalizedIp();
    $host_name=gethostname();
    $resumeResult=mysqli_query($conn,"SELECT * FROM tbl_login WHERE id=".$resumeUserId." LIMIT 1");
    $row=mysqli_fetch_assoc($resumeResult);
    if($row){
        $role=$row['role'];$role1=$row['role'];$fullName=$row['fullName'];$email=$row['email'];
        $firmCode=$row['firmCode'];$clientCode=$row['clientCode'];$id=$row['id'];
        if($role==6||$role==10){$role=6;}
        $existingIPsA=array_values(array_filter(array_unique(explode(',',$row['IPaddress'])),fn($v)=>trim($v)!==''));
        if(!in_array($ipAddress,$existingIPsA)){if(count($existingIPsA)>=5)array_shift($existingIPsA);$existingIPsA[]=$ipAddress;}
        mysqli_query($conn,"UPDATE tbl_login SET IPaddress='".implode(',',$existingIPsA)."' WHERE id=".$id);
        $_SESSION['email']=$email;$_SESSION['userType']=$row['userType'];$_SESSION['state']=$row['state'];
        $_SESSION['portfolioCode']=$row['portfolioCode'];$_SESSION['role']=$role;$_SESSION['role60r10']=$role1;
        $_SESSION['fullName']=$fullName;$_SESSION['userloginType']=$row['userloginType'];
        $_SESSION['productCode']=$row['productCode'];$_SESSION['firmCode']=$firmCode;$_SESSION['clientCode']=$clientCode;
        $_SESSION['companyId']=$row['companyId'];$_SESSION['LastName']=$row['LastName'];$_SESSION['id']=$id;
        $_SESSION['UserGroup']=$row['UserGroup'];$_SESSION['phoneNo']=$row['phoneNo'];$_SESSION['timeout']=time();
        $_SESSION['firmCodenew']=$firmCode;$_SESSION['clientCodenew']=$clientCode;
        $_SESSION['AACA_RCVD_BATCH_FROM']=$DATE1;$_SESSION['AACA_RCVD_BATCH_END']=$DATE2;
        $_SESSION['AACA_RCVD_BATCH_FROM_PIE']='2002-01';$_SESSION['AACA_RCVD_BATCH_END_PIE']=$DATE2;
        $_SESSION['SETLMNT_BATCH_FROM']=$DATE1;$_SESSION['SETLMNT_BATCH_END']=$DATE2;
        $_SESSION['AACA_RCVD_BATCH_FROM_TIMELINE']=$DATE4;$_SESSION['AACA_RCVD_BATCH_END_TIMELINE']=$DATE2;
        $dtP=DateTime::createFromFormat('Y-m-d H:i:s',$row['Passexpdate']);
        if(!$dtP)$dtP=DateTime::createFromFormat('Y-m-d',$row['Passexpdate']);
        if($dtP)mysqli_query($conn,"UPDATE tbl_login SET Passexpdate='".$dtP->format('Y-m-d H:i:s')."' WHERE id=".$id);
        $eularesult=mysqli_query($conn,"Select * from MANAGE_EULA where UserId=".$id);
        $roweula=mysqli_fetch_array($eularesult);
        $eulaStatus=$roweula['EulaStatus'];
        $euladaydate=strtotime(date('Y-m-d',strtotime($roweula['EulaDate'])));
        $currentDate=strtotime(date('Y-m-d'));
        $logindatediff=($currentDate-$euladaydate)/60/60/24;
        $eulayeardate=strtotime(date('Y-m-d',strtotime($roweula['createdAt'])));
        $logindateyeardiff=($currentDate-$eulayeardate)/60/60/24;
        $dtExp=DateTime::createFromFormat('Y-m-d H:i:s',$row['Passexpdate']);
        if(!$dtExp)$dtExp=DateTime::createFromFormat('Y-m-d',$row['Passexpdate']);
        $Passexpdate=$dtExp?strtotime($dtExp->format('Y-m-d')):0;
        $passexpday=($currentDate-$Passexpdate)/60/60/24;
        $rescountQuery=mysqli_query($conn,"SELECT count(1) as Check_multiple_status from tbl_login where bit_deleted_flag=0 and email='".$email."'");
        $fetchrescountQuery=mysqli_fetch_assoc($rescountQuery);
        if($fetchrescountQuery['Check_multiple_status']>=1&&$row['active_inactive_status']==0){$passwordmsg="Please authorise yourself";}
        else if($passexpday>=90&&$fetchrescountQuery['Check_multiple_status']>=1){header('Location: Passexp');}
        else if($logindateyeardiff>=366&&$fetchrescountQuery['Check_multiple_status']>=1){header('Location: EULA?val=1');}
        else if($fetchrescountQuery['Check_multiple_status']>=1&&$eulaStatus==0){header('Location: EULA');}
        else if($fetchrescountQuery['Check_multiple_status']>=1&&$eulaStatus==1&&$logindatediff>=90){header('Location: EULA');}
        else if($fetchrescountQuery['Check_multiple_status']>=1&&$eulaStatus==1&&$logindatediff<90){
            $date=date('Y-m-d H:i:s');
            mysqli_query($conn,"UPDATE MANAGE_EULA SET EulaDate='".$date."' WHERE UserId=".$id);
            if($fullName!=''&&$email!=''&&$ipAddress!=''){
                mysqli_query($conn,"INSERT INTO logged_in_logs(`userName`,`emailId`,`ipAddress`,`browserDetails`,`LoggedinWith`) VALUES ('$fullName','$email','$ipAddress','$agent','$host_name')");
            }
            if($fetchrescountQuery['Check_multiple_status']>1){$_SESSION['email']=$email;header('Location: loginnew');}
            else if($_SESSION['role']==9){header('Location: judgment_layout.php');}
            else{
                if(isset($_SESSION['settlement_number'])){header('Location: Settlement_Form/settlement-request');}
                else if(isset($_SESSION['urlloc'])){header('Location: mydownload');}
                else{header('Location: inventory_layout.php');}
            }
        }
    }
}

/* ═══════════════════════════════════════════════════════════════════
   STEP B — OTP form submitted
   ═══════════════════════════════════════════════════════════════════ */
if(isset($_POST['verify_otp'])){
    $otpInput=trim($_POST['otp_code']);
    $otpUserId=(int)$_SESSION['otp_login_user_id'];
    if($otpUserId>0){
        $otpResult=mysqli_query($conn,"SELECT * FROM tbl_login WHERE id=".$otpUserId." LIMIT 1");
        $otpRow=mysqli_fetch_array($otpResult);
        if($otpRow){
            $storedOtp=trim($otpRow['otp_code']);$otpCount=(int)$otpRow['otp_count'];$otpCreatedAt=$otpRow['otp_created_at'];
            if($otpCount>=5){
                $otpErrorMsg='Too many OTP attempts. Please log in again to generate a new OTP.';$showLoginForm=true;$showOtpForm=false;
            }else if($otpCreatedAt!=''&&(time()-strtotime($otpCreatedAt))>300){
                $otpErrorMsg='OTP expired. Please log in again to generate a new OTP.';$showLoginForm=true;$showOtpForm=false;
            }else if($otpInput!=''&&$storedOtp===$otpInput){
                /* COOKIE-FIX: Use random token from session */
                $deviceToken=isset($_SESSION['otp_login_device_token'])?$_SESSION['otp_login_device_token']:'';
                $deviceNickname=isset($_SESSION['otp_device_nickname'])?trim($_SESSION['otp_device_nickname']):'';
                if($deviceNickname=='')$deviceNickname=isset($_POST['otp_device_nickname'])?trim($_POST['otp_device_nickname']):'';
                if($deviceToken!=''){
                    $existingDevices=array_values(array_filter(array_unique(explode(',',$otpRow['device_ids'])),fn($v)=>trim($v)!==''));
                    if(!in_array($deviceToken,$existingDevices))$existingDevices[]=$deviceToken;
                    if(count($existingDevices)>5)$existingDevices=array_slice($existingDevices,-5);
                    mysqli_query($conn,"UPDATE tbl_login SET device_ids='".implode(',',$existingDevices)."' WHERE id=".$otpUserId);
                    $nmMap=($otpRow['device_nicknames']!=''&&$otpRow['device_nicknames']!==null)?json_decode($otpRow['device_nicknames'],true):[];
                    if(!is_array($nmMap))$nmMap=[];
                    if($deviceNickname=='')$deviceNickname=getDeviceName($_SERVER['HTTP_USER_AGENT']);
                    $nmMap[$deviceToken]=$deviceNickname;
                    mysqli_query($conn,"UPDATE tbl_login SET device_nicknames='".mysqli_real_escape_string($conn,json_encode($nmMap,JSON_UNESCAPED_UNICODE))."' WHERE id=".$otpUserId);
                    $loginIp=getNormalizedIp();
                    $ipMap=($otpRow['device_ip_map']!='')?json_decode($otpRow['device_ip_map'],true):[];
                    if(!is_array($ipMap))$ipMap=[];
                    $ipMap[$deviceToken]=$loginIp;
                    mysqli_query($conn,"UPDATE tbl_login SET device_ip_map='".mysqli_real_escape_string($conn,json_encode($ipMap,JSON_UNESCAPED_UNICODE))."' WHERE id=".$otpUserId);
                    $existingIPsB=array_values(array_filter(array_unique(explode(',',$otpRow['IPaddress'])),fn($v)=>trim($v)!==''));
                    if(!in_array($loginIp,$existingIPsB)){if(count($existingIPsB)>=5)array_shift($existingIPsB);$existingIPsB[]=$loginIp;}
                    mysqli_query($conn,"UPDATE tbl_login SET IPaddress='".implode(',',$existingIPsB)."' WHERE id=".$otpUserId);
                    setDeviceCookie($deviceToken);
                }
                mysqli_query($conn,"UPDATE tbl_login SET otp_code=NULL, otp_count=0, otp_created_at=NULL WHERE id=".$otpUserId);
                unset($_SESSION['otp_device_nickname'],$_SESSION['otp_login_device_token']);
                $_SESSION['otp_login_resume']=1;
                header('Location: '.$_SERVER['PHP_SELF']);exit();
            }else{
                mysqli_query($conn,"UPDATE tbl_login SET otp_count=otp_count+1 WHERE id=".$otpUserId);
                $otpErrorMsg='Invalid OTP. Please check and re-enter it.';$showLoginForm=false;$showOtpForm=true;
                $otpPendingName=isset($_SESSION['otp_login_name'])?$_SESSION['otp_login_name']:'';
            }
        }
    }
}

/* ═══════════════════════════════════════════════════════════════════
   STEP C — New device: generate random token + send OTP
   COOKIE-FIX: generates bin2hex(random_bytes(32)) instead of fingerprint
   ═══════════════════════════════════════════════════════════════════ */
if(isset($_POST['device_trust_choice'])){
    $choiceUserId=(int)$_SESSION['otp_login_user_id'];
    $nickname=isset($_POST['device_nickname'])?trim($_POST['device_nickname']):'';
    if($choiceUserId>0){
        $newDeviceToken=bin2hex(random_bytes(32));
        $_SESSION['otp_login_device_token']=$newDeviceToken;
        $_SESSION['otp_device_nickname']=$nickname;
        $choiceResult=mysqli_query($conn,"SELECT * FROM tbl_login WHERE id=".$choiceUserId." LIMIT 1");
        $choiceRow=mysqli_fetch_array($choiceResult);
        if($choiceRow){
            $otp=(string)random_int(100000,999999);$now=date('Y-m-d H:i:s');
            mysqli_query($conn,"UPDATE tbl_login SET otp_code='".$otp."', otp_count=0, otp_created_at='".$now."', otp_mail_time='".$now."' WHERE id=".$choiceUserId);
            $subject='Your login OTP';
            $message="Hello ".$choiceRow['fullName'].",\n\nYour login OTP is: ".$otp."\nIt will expire in 5 minutes.\n";
            $headers="From: no-reply@localhost\r\nContent-Type: text/plain; charset=UTF-8\r\n";
            if(function_exists('mail'))@mail($choiceRow['email'],$subject,$message,$headers);
        }
        $showLoginForm=false;$showOtpForm=true;
        $otpPendingName=isset($_SESSION['otp_login_name'])?$_SESSION['otp_login_name']:'';
    }
}

/* ═══════════════════════════════════════════════════════════════════
   STEP D — Device removal submitted
   COOKIE-FIX: uses remove_device_token instead of remove_fingerprint
   ═══════════════════════════════════════════════════════════════════ */
if(isset($_POST['remove_device_submit'])){
    $removeUserId=(int)$_SESSION['otp_login_user_id'];
    $tokenToRemove=isset($_POST['remove_device_token'])?trim($_POST['remove_device_token']):'';
    if($removeUserId>0&&$tokenToRemove!=''){
        $removeResult=mysqli_query($conn,"SELECT * FROM tbl_login WHERE id=".$removeUserId." LIMIT 1");
        $removeRow=mysqli_fetch_array($removeResult);
        $existingDevices=array_values(array_filter(array_unique(explode(',',$removeRow['device_ids'])),fn($t)=>trim($t)!==''&&$t!==$tokenToRemove));
        mysqli_query($conn,"UPDATE tbl_login SET device_ids='".implode(',',$existingDevices)."' WHERE id=".$removeUserId);
        $nmMap=($removeRow['device_nicknames']!='')?json_decode($removeRow['device_nicknames'],true):[];
        if(!is_array($nmMap))$nmMap=[];if(isset($nmMap[$tokenToRemove]))unset($nmMap[$tokenToRemove]);
        mysqli_query($conn,"UPDATE tbl_login SET device_nicknames='".mysqli_real_escape_string($conn,json_encode($nmMap,JSON_UNESCAPED_UNICODE))."' WHERE id=".$removeUserId);
        $ipMapD=($removeRow['device_ip_map']!='')?json_decode($removeRow['device_ip_map'],true):[];
        if(!is_array($ipMapD))$ipMapD=[];if(isset($ipMapD[$tokenToRemove]))unset($ipMapD[$tokenToRemove]);
        mysqli_query($conn,"UPDATE tbl_login SET device_ip_map='".mysqli_real_escape_string($conn,json_encode($ipMapD,JSON_UNESCAPED_UNICODE))."' WHERE id=".$removeUserId);
        if(!isset($_SESSION['otp_login_user_id'])||$_SESSION['otp_login_user_id']!=$removeUserId){$_SESSION['otp_login_user_id']=$removeUserId;}
        /* ── After removal: generate a new device token and send OTP immediately ──
           The slot is now free, so we skip the "New Device Detected" click-through
           and go straight to OTP — same as STEP C does for a normal new device.   */
        $newDeviceToken = bin2hex(random_bytes(32));
        $_SESSION['otp_login_device_token'] = $newDeviceToken;
        $_SESSION['otp_device_nickname'] = '';   // user can name it on next login if desired
        $removeRowFresh = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM tbl_login WHERE id=".$removeUserId." LIMIT 1"));
        if($removeRowFresh){
            $otp = (string)random_int(100000,999999);
            $now = date('Y-m-d H:i:s');
            mysqli_query($conn,"UPDATE tbl_login SET otp_code='".$otp."', otp_count=0, otp_created_at='".$now."', otp_mail_time='".$now."' WHERE id=".$removeUserId);
            $subject = 'Your login OTP';
            $message = "Hello ".$removeRowFresh['fullName'].",\n\nYour login OTP is: ".$otp."\nIt will expire in 5 minutes.\n";
            $headers = "From: no-reply@localhost\r\nContent-Type: text/plain; charset=UTF-8\r\n";
            if(function_exists('mail')) @mail($removeRowFresh['email'], $subject, $message, $headers);
        }
        $showLoginForm = false;
        $showOtpForm  = true;
        $otpPendingName = isset($_SESSION['otp_login_name']) ? $_SESSION['otp_login_name'] : '';
    }
}

/* ═══════════════════════════════════════════════════════════════════
   STEP E — Main login form submitted
   COOKIE-FIX: reads $_COOKIE['device_token'] instead of JS fingerprint
   ═══════════════════════════════════════════════════════════════════ */
if(isset($_POST['but_submit'])){
    $agent=$_SERVER['HTTP_USER_AGENT'];
    $ipAddress=getNormalizedIp();
    $host_name=gethostname();
    $email=trim($_POST['txt_uname']);$pass=trim($_POST['txt_pwd']);
    $postemail=htmlspecialchars($email,ENT_QUOTES,'UTF-8');
    $password=htmlspecialchars($pass,ENT_QUOTES,'UTF-8');
    $encrypted_string=md5($password);$date=date('Y-m-d H:i:s');
    /* COOKIE-FIX: Read device token from cookie */
    $currentDeviceToken=isset($_COOKIE['device_token'])?trim($_COOKIE['device_token']):'';
    if($postemail==''){$Emailmsg="User id can not be left blank";}
    if($password==''){$passwordmsg="Password id can not be left blank";}
    if($postemail!=""&&$password!=""){
        $sql_query="select count(*) as cntUser,UserGroup,id,fullName,vchPassword,email,LastName,companyId,userType,state,portfolioCode,role,productCode,firmCode,clientCode,loginStatus,createdAt,Check_multiple_status,Passexpdate,IPaddress,AuthorisedFlag,active_inactive_status,bit_deleted_flag,company_status,device_ids,device_nicknames,device_ip_map from tbl_login where email='".$postemail."' and bit_deleted_flag=0 and vchPassword!='' and company_status!=4 group by id,fullName,vchPassword,email,LastName,companyId,userType,state,portfolioCode,role,productCode,firmCode,clientCode,loginStatus,createdAt,Check_multiple_status,Passexpdate,IPaddress,AuthorisedFlag,active_inactive_status,bit_deleted_flag,company_status,device_ids,device_nicknames,device_ip_map";
        $result=mysqli_query($conn,$sql_query);$row=mysqli_fetch_assoc($result);
        $count=$row['cntUser'];$loginStatus=$row['loginStatus'];$userType=$row['userType'];$state=$row['state'];
        $portfolioCode=$row['portfolioCode'];$role=$row['role'];$role1=$row['role'];$fullName=$row['fullName'];
        $email=$row['email'];$userloginType=$row['userloginType'];$productCode=$row['productCode'];
        $firmCode=$row['firmCode'];$clientCode=$row['clientCode'];$companyId=$row['companyId'];
        $LastName=$row['LastName'];$passwordDB=$row['vchPassword'];$id=$row['id'];
        $dateex=DateTime::createFromFormat('Y-m-d H:i:s',$row['Passexpdate']);
        if(!$dateex)$dateex=DateTime::createFromFormat('Y-m-d',$row['Passexpdate']);
        if(!$dateex)$dateex=DateTime::createFromFormat('m-d-Y',$row['Passexpdate']);
        $Passexpdate=$dateex?strtotime($dateex->format('Y-m-d')):strtotime(date('Y-m-d',strtotime('+90 days')));
        $IPaddress=array_values(array_filter(array_unique(explode(',',$row['IPaddress'])),fn($v)=>trim($v)!==''));
        $countIPaddress=count($IPaddress);$AuthorisedFlag=$row['AuthorisedFlag'];$active_inactive_status=$row['active_inactive_status'];
        $_SESSION['id']=$id;
        if($role==6||$role==10){$role=6;}
        if(strtolower($postemail)!=strtolower($email)){$Emailmsg="Invalid userid";}
        else if($encrypted_string!=$passwordDB){$passwordmsg="Invalid Password";}
        else{
            $userResult=mysqli_query($conn,"SELECT Status FROM manage_user WHERE UserId=".$id." LIMIT 1");
            $userRow=mysqli_fetch_assoc($userResult);
            $userIsActive=$userRow?((int)$userRow['Status']===1):($AuthorisedFlag==1);
            $compResult=mysqli_query($conn,"SELECT Status FROM manage_company_registry WHERE CompanyId='".$companyId."' LIMIT 1");
            $compRow=mysqli_fetch_assoc($compResult);
            $companyIsActive=$compRow?((int)$compRow['Status']===1):($companyStatus===1);
            if(!$userIsActive){$passwordmsg="Your account is not active. Please contact your administrator.";}
            else if(!$companyIsActive){$passwordmsg="Company is inactive or terminated.";}
            if($passwordmsg==''){
                $trustedDevicesRaw=array_values(array_filter(array_unique(explode(',',$row['device_ids'])),fn($v)=>trim($v)!==''));

                /* ── Determine device status ── */
                $isTrusted = ($currentDeviceToken !== '' && in_array($currentDeviceToken, $trustedDevicesRaw));
                $isDeviceLimitReached = (!$isTrusted && count($trustedDevicesRaw) >= 5);

                /* COOKIE-FIX: Check cookie token against trusted list */
                if($isTrusted){
                    // ──── TRUSTED DEVICE — skip OTP ────
                    $_SESSION['userType']=$userType;$_SESSION['state']=$state;$_SESSION['portfolioCode']=$portfolioCode;
                    $_SESSION['role']=$role;$_SESSION['role60r10']=$role1;$_SESSION['fullName']=$fullName;
                    $_SESSION['userloginType']=$userloginType;$_SESSION['productCode']=$productCode;
                    $_SESSION['firmCode']=$firmCode;$_SESSION['clientCode']=$clientCode;$_SESSION['companyId']=$companyId;
                    $_SESSION['LastName']=$LastName;$_SESSION['id']=$id;$_SESSION['UserGroup']=$row['UserGroup'];
                    $_SESSION['phoneNo']=$row['phoneNo'];$_SESSION['timeout']=time();
                    $_SESSION['firmCodenew']=$firmCode;$_SESSION['clientCodenew']=$clientCode;
                    $_SESSION['AACA_RCVD_BATCH_FROM']=$DATE1;$_SESSION['AACA_RCVD_BATCH_END']=$DATE2;
                    $_SESSION['AACA_RCVD_BATCH_FROM_PIE']='2002-01';$_SESSION['AACA_RCVD_BATCH_END_PIE']=$DATE2;
                    $_SESSION['SETLMNT_BATCH_FROM']=$DATE1;$_SESSION['SETLMNT_BATCH_END']=$DATE2;
                    $_SESSION['AACA_RCVD_BATCH_FROM_TIMELINE']=$DATE4;$_SESSION['AACA_RCVD_BATCH_END_TIMELINE']=$DATE2;
                    // Update device→IP map
                    $ipMapUpdate=($row['device_ip_map']!='')?json_decode($row['device_ip_map'],true):[];
                    if(!is_array($ipMapUpdate))$ipMapUpdate=[];
                    $ipMapUpdate[$currentDeviceToken]=$ipAddress;
                    mysqli_query($conn,"UPDATE tbl_login SET device_ip_map='".mysqli_real_escape_string($conn,json_encode($ipMapUpdate,JSON_UNESCAPED_UNICODE))."' WHERE id=".$id);
                    // Update device name if missing
                    $nmMapU=($row['device_nicknames']!='')?json_decode($row['device_nicknames'],true):[];
                    if(!is_array($nmMapU))$nmMapU=[];
                    if(!isset($nmMapU[$currentDeviceToken])||$nmMapU[$currentDeviceToken]==''){
                        $nmMapU[$currentDeviceToken]=getDeviceName($agent);
                        mysqli_query($conn,"UPDATE tbl_login SET device_nicknames='".mysqli_real_escape_string($conn,json_encode($nmMapU,JSON_UNESCAPED_UNICODE))."' WHERE id=".$id);
                    }
                    // Save IPaddress column
                    $existingIPsT=array_values(array_filter(array_unique(explode(',',$row['IPaddress'])),fn($v)=>trim($v)!==''));
                    if(!in_array($ipAddress,$existingIPsT)){if(count($existingIPsT)>=5)array_shift($existingIPsT);$existingIPsT[]=$ipAddress;}
                    mysqli_query($conn,"UPDATE tbl_login SET IPaddress='".implode(',',$existingIPsT)."' WHERE id=".$id);
                    setDeviceCookie($currentDeviceToken);
                    // EULA checks
                    $eularesult=mysqli_query($conn,"Select * from MANAGE_EULA where UserId=".$id);
                    $roweula=mysqli_fetch_array($eularesult);$eulaStatus=$roweula['EulaStatus'];
                    $euladaydate=strtotime(date('Y-m-d',strtotime($roweula['EulaDate'])));$currentDate=strtotime(date('Y-m-d'));
                    $logindatediff=($currentDate-$euladaydate)/60/60/24;
                    $eulayeardate=strtotime(date('Y-m-d',strtotime($roweula['createdAt'])));
                    $logindateyeardiff=($currentDate-$eulayeardate)/60/60/24;
                    $passexpday=($currentDate-$Passexpdate)/60/60/24;
                    $countQuery="SELECT count(1) as Check_multiple_status from tbl_login where bit_deleted_flag=0 and email='".$postemail."'";
                    $rescountQuery=mysqli_query($conn,$countQuery);$fetchrescountQuery=mysqli_fetch_assoc($rescountQuery);
                    if($fetchrescountQuery['Check_multiple_status']>=1&&$active_inactive_status==0){$passwordmsg="Please authorise yourself";}
                    else if($passexpday>=90&&$fetchrescountQuery['Check_multiple_status']>=1){header('Location: Passexp');}
                    else if($logindateyeardiff>=366&&$fetchrescountQuery['Check_multiple_status']>=1){header('Location: EULA?val=1');}
                    else if($count>0&&$eulaStatus==1&&$logindatediff<90&&$fetchrescountQuery['Check_multiple_status']>=1){
                        $date=date('Y-m-d H:i:s');mysqli_query($conn,"UPDATE MANAGE_EULA SET EulaDate='".$date."' WHERE UserId=".$id);
                        if($fullName!=''&&$email!=''&&$ipAddress!=''){mysqli_query($conn,"INSERT INTO logged_in_logs(`userName`,`emailId`,`ipAddress`,`browserDetails`,`LoggedinWith`) VALUES ('$fullName','$email','$ipAddress','$agent','$host_name')");}
                        if($fetchrescountQuery['Check_multiple_status']>1){$_SESSION['email']=$email;header('Location: loginnew');}
                        else if($_SESSION['role']==9){header('Location: judgment_layout');}
                        else{if(isset($_SESSION['settlement_number'])){header('Location: Settlement_Form/settlement-request');}else if(isset($_SESSION['urlloc'])){header('Location: mydownload');}else{header('Location: inventory_layout.php');}}
                    }
                    else if($count>0&&$eulaStatus==0&&$fetchrescountQuery['Check_multiple_status']>=1){header('Location: EULA');}
                    else if($count>0&&$eulaStatus==1&&$logindatediff>=90&&$fetchrescountQuery['Check_multiple_status']>=1){header('Location: EULA');}
                    else{$msg="Invalid userid or password";}

                }else if($isDeviceLimitReached){
                    // ──── DEVICE LIMIT REACHED (5) — show removal popup ────
                    // Fires for ANY unrecognized browser/device (no cookie OR unrecognised cookie)
                    $showLoginForm=false;$showRemoveDevice=true;
                    $nmMap=($row['device_nicknames']!='')?json_decode($row['device_nicknames'],true):[];if(!is_array($nmMap))$nmMap=[];
                    $ipMap=($row['device_ip_map']!='')?json_decode($row['device_ip_map'],true):[];if(!is_array($ipMap))$ipMap=[];
                    $idx=1;
                    foreach($trustedDevicesRaw as $tk){
                        $label=(isset($nmMap[$tk])&&$nmMap[$tk]!=='')?htmlspecialchars($nmMap[$tk],ENT_QUOTES,'UTF-8'):'Device '.$idx;
                        $assocIp=isset($ipMap[$tk])?htmlspecialchars($ipMap[$tk],ENT_QUOTES,'UTF-8'):'N/A';
                        $trustedDeviceList[]=['token'=>$tk,'label'=>$label,'ip'=>$assocIp];$idx++;
                    }
                    $_SESSION['otp_login_user_id']=$id;$_SESSION['otp_login_email']=$email;$_SESSION['otp_login_name']=$fullName;

                }else{
                    // ──── NEW/UNKNOWN DEVICE — show "New Device Detected" panel ────
                    $_SESSION['otp_login_user_id']=$id;$_SESSION['otp_login_email']=$email;$_SESSION['otp_login_name']=$fullName;
                    $showLoginForm=false;$showNewDeviceChoice=true;
                }
            }
        }
    }
}
?>

<div class="wrapper-login fadeInDown login-section" id="warning-message1">
<div id="formContent" class="modal-dialog">
<div class="formHeader clearfix">
    <div class="col-sm-12 mar20B">
        <div class="fadeIn first">
            <div class="col-sm-6"><img src="img/aaca-net.png" class="img-resposnive login-logo ml10 f_wid" alt="aacanet"/></div>
            <div class="col-sm-6 text-center"><img src="img/pipeway-logo.gif" class="img-resposnive login-logo mt10 f_wid" alt="aacanet"/></div>
        </div>
    </div>
<div class="col-sm-12">
    <?php if($msg!==''):?><p style="color:red;font-size:12px;text-align:center;"><?php echo htmlspecialchars($msg,ENT_QUOTES,'UTF-8');?></p><?php endif;?>

    <!-- ═══ PANEL 1 — LOGIN FORM (COOKIE-FIX: no hidden fingerprint field) ═══ -->
    <?php if($showLoginForm):?>
    <form action="" id="loginForm" method="post" autocomplete="off">
        <span style="color:red"><?php echo $unauthuser;?></span>
        <span style="color:red"><?php echo $unauthusermore;?></span>
        <div class="form-group clearfix">
         <div class="input-group fadeIn second user">
          <span class="input-group-addon" style="background-color:rgba(0,0,0,0);border-bottom:0px;color:#012f5c;border-radius:10px;"><i class="fa fa-user"></i></span>
          <span class="clearable">
            <input type="text" class="bor" id="email" name="txt_uname" placeholder="User name" maxlength="50" value="<?php echo isset($_POST["txt_uname"])?$_POST["txt_uname"]:'';?>" autofocus>
            <i class="clearable__clear" style="display:inline;">&times;</i>
          </span>
         </div>
         <span style="color:red;font-size:11px;margin-left:45px;"><?php echo $Emailmsg;?></span>
        </div>
        <div class="form-group clearfix">
         <div class="input-group fadeIn third user">
          <span class="input-group-addon" style="background-color:rgba(0,0,0,0);border-bottom:0px;color:#012f5c;border-radius:10px;"><i class="fa fa-lock"></i></span>
          <span class="clearable">
           <input type="password" class="bor" id="password" name="txt_pwd" placeholder="Password" value="<?php echo isset($_POST["txt_pwd"])?$_POST["txt_pwd"]:'';?>" maxlength="20" autofocus>
           <i class="clearable__clear" style="display:inline;">&times;</i>
          </span>
         </div>
         <p style="color:red;font-size:11px;margin-left:45px;margin-bottom:0px;"><?php echo $passwordmsg;?></p>
         <?php if($Emailmsg!=''||$passwordmsg!=''){?><p style="color:#607D8B;font-size:11px;width:100%;margin-left:8px;margin-top:5px;">Please enter your user name and password. If you do not have a user name and password, please contact your company's Pipeway Administrator.</p><?php }?>
        </div>
        <div class="form-group clearfix">
          <button type="submit" class="fadeIn fourth f_wid" name="but_submit" id="but_submit" style="border-radius:15px;background:#002e5b;"><i class="fa fa-key"></i> Log In</button>
        </div>
        <div class="col-md-12" style="text-align:center;"><a class="underlineHover fadeIn fourth" id="forgotpass" href="forgotpassword">Forgot Password?</a></div>
    </form>
    </div></div>
    <section><div class="col-sm-8 p0"></div><div class="col-sm-4 p0" style="position:relative;bottom:65px;"><div class="linkedin"><a href="https://www.linkedin.com/company/aacanet-inc." target="blank" style="color:#fff;"><i class="fa fa-linkedin fa-x" style="padding:8px 10px;"></i></a></div></div></section>
    </div></div></form>
    <?php endif;?>

    <!-- ═══ PANEL 2 — NEW DEVICE DETECTED ═══ -->
    <?php if($showNewDeviceChoice):?>
    <div class="device-panel">
      <h5><i class="fa fa-laptop"></i>&nbsp; New Device Detected</h5>
      <p>We have not seen this device before.<br>Give this device a nickname (optional) and click below to receive your OTP.</p>
      <form action="" method="post" id="deviceChoiceYesForm">
        <input type="hidden" name="device_trust_choice" value="1">
        <label for="device_nickname" style="font-size:12px;color:#002e5b;font-weight:600;">Device nickname (optional):</label>
        <input type="text" id="device_nickname" name="device_nickname" class="device-nickname-input" placeholder="e.g. Office PC, My Laptop" maxlength="60">
        <button type="submit" class="device-choice-btn btn-primary-solid"><i class="fa fa-check-circle"></i>&nbsp; Send OTP</button>
      </form>
    </div>
    <?php endif;?>

    <!-- ═══ PANEL 3 — DEVICE LIMIT REACHED (5 devices, pick one to remove) ═══ -->
    <?php if($showRemoveDevice):?>
    <div class="device-panel">
      <h5><i class="fa fa-shield"></i>&nbsp; Trusted Device Limit Reached</h5>
      <p>You already have <strong>5 trusted devices</strong>.<br>Please remove one device to add this new device.</p>
      <form action="" method="post" id="removeDeviceForm">
        <input type="hidden" name="remove_device_submit" value="1">
        <?php foreach($trustedDeviceList as $dv):?>
        <div class="device-list-item">
          <input type="radio" name="remove_device_token" id="dev_<?php echo substr($dv['token'],0,12);?>" value="<?php echo htmlspecialchars($dv['token'],ENT_QUOTES,'UTF-8');?>">
          <label for="dev_<?php echo substr($dv['token'],0,12);?>">
            <span style="display:flex;flex-direction:column;gap:2px;">
              <span><i class="fa fa-laptop"></i>&nbsp; <strong><?php echo $dv['label'];?></strong></span>
              <span style="font-size:11px;color:#607D8B;margin-left:18px;"><i class="fa fa-globe"></i>&nbsp; IP: <?php echo $dv['ip'];?></span>
            </span>
          </label>
        </div>
        <?php endforeach;?>
        <p style="font-size:11px;color:#e53935;margin-top:8px;margin-bottom:10px;">* The selected device will be removed immediately.</p>
        <button type="submit" class="device-choice-btn btn-primary-solid" onclick="if(!document.querySelector('input[name=remove_device_token]:checked')){alert('Please select a device to remove.');return false;}">
          <i class="fa fa-trash-o"></i>&nbsp; Remove selected &amp; continue
        </button>
      </form>
    </div>
    <?php endif;?>

    <!-- ═══ PANEL 4 — OTP ENTRY ═══ -->
    <?php if($showOtpForm):?>
    <div class="device-panel">
      <h5><i class="fa fa-envelope-o"></i>&nbsp; Enter Your OTP</h5>
      <p>An OTP has been sent to your registered email address<?php if($otpPendingName!==''):?> (<strong><?php echo $otpPendingName;?></strong>)<?php endif;?>.<br>
        <small>Valid for <strong>5 minutes</strong>. Maximum <strong>5 attempts</strong>.</small></p>
      <?php if($otpErrorMsg!==''):?><p class="otp-error-msg"><?php echo htmlspecialchars($otpErrorMsg,ENT_QUOTES,'UTF-8');?></p><?php endif;?>
      <form action="" method="post" id="otpForm">
        <input type="hidden" name="verify_otp" value="1">
        <input type="hidden" name="otp_device_nickname" value="<?php echo htmlspecialchars((string)($_SESSION['otp_device_nickname']??''),ENT_QUOTES,'UTF-8');?>">
        <div class="form-group">
          <input type="text" name="otp_code" class="otp-input-box" placeholder="_ _ _ _ _ _" maxlength="6" autocomplete="one-time-code" inputmode="numeric" pattern="[0-9]{6}" required autofocus>
        </div>
        <button type="submit" class="device-choice-btn btn-primary-solid" style="margin-top:6px;width:auto;margin-left:auto;margin-right:auto;display:block;padding:9px 40px;">Verify OTP</button>
      </form>
      <div style="margin-top:10px;text-align:center;"><a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF'],ENT_QUOTES,'UTF-8');?>" style="font-size:12px;color:#002e5b;">&larr; Back to login</a></div>
    </div>
    <?php endif;?>

</div></div></div></div>

</body>
<script type="text/javascript">
/* COOKIE-FIX: Removed buildFp() fingerprint JS — device identification now via cookie */
$("#password").keypress(function(event){if(event.keyCode===13){$("#but_submit").click();}});
$(document).ready(function(){
    $(".clearable").each(function(){var $inp=$(this).find("input:text"),$cle=$(this).find(".clearable__clear");$inp.on("input",function(){$cle.toggle(!!this.value);});$cle.on("touchstart click",function(e){e.preventDefault();$inp.val("").trigger("input");});});
    $(".clearable").each(function(){var $inp=$(this).find("input:password"),$cle=$(this).find(".clearable__clear");$inp.on("input",function(){$cle.toggle(!!this.value);});$cle.on("touchstart click",function(e){e.preventDefault();$inp.val("").trigger("input");});});
});
var auth='<?php echo $unauthuser;?>';
if(auth!=''){var email='<?php echo $_POST['txt_uname'];?>';$.ajax({type:"GET",url:"authenticate.php",data:{email:email},success:function(data){}});}
</script>
<?php
if(isset($_SESSION['forgototp'])){?><script>swal({title:"",text:"OTP has been sent to your email id",timer:3000,showConfirmButton:false,type:'success'});</script><?php }unset($_SESSION['forgototp']);
if(isset($_SESSION['resetforgotpass'])){?><script>swal({title:"",text:"Password created successfully",timer:3000,showConfirmButton:false,type:'success'});</script><?php }unset($_SESSION['resetforgotpass']);
if(isset($_SESSION['authenticate'])){?><script>swal({title:"",text:"User authenticated successfully",timer:3000,showConfirmButton:false,type:'success'});</script><?php }unset($_SESSION['authenticate']);
if(isset($_SESSION['changepass'])){unset($_SESSION['email']);?><script>swal({title:"",text:"Password changed successfully",timer:3000,showConfirmButton:false,type:'success'});</script><?php }unset($_SESSION['changepass']);
if(isset($_SESSION['role'])&&isset($_SESSION['email'])&&!$showLoginForm&&!$showOtpForm&&!$showNewDeviceChoice&&!$showRemoveDevice){
    if($_SESSION['role']==9){header('Location: judgment_layout');}
    else{if(isset($_SESSION['settlement_number'])){header('Location: Settlement_Form/settlement-request');}else{header('Location: inventory_layout.php');}}
}
?>
</html>