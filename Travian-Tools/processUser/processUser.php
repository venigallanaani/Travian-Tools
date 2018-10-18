<?php
// verify the user and signs into the account
function signIn(){
    
    include_once 'Utilities/DBFunctions.php';
    $userNm=$_POST['user'];
    $passWd=$_POST['pass'];
    
        $loginDtls=queryDB("SELECT * FROM PROFILE_LOGIN_DATA WHERE USER_NAME='".$userNm."'");
        
        if(mysqli_num_rows($loginDtls)==0){
            //check if the username exists
            $_SESSION['message']='<p class="'.'error'.'"> User doesn'."'t exist</p>";
            return header("location:login.php?error=user");
            exit();
        }else{
            $logIn=$loginDtls->fetch_assoc();
                //check if the password is correct
            if (password_verify($_POST['pass'], $logIn['USER_PASS']) ){
                if($logIn['USER_STATUS']=='INACTIVE'){
                    $_SESSION['message'] ='<p class="text">Account is not activated yet, please check your Email address <spawn style="text-decoration:underline">'.$logIn['USER_EMAIL'] .'</spawn> for the activation link</p>'.
            '<p><a href="login.php">Login!!</a></p>';
                    return header("location:login.php?login=inactive");
                    exit();
                }elseif($logIn['USER_STATUS']=='RESET'){
                    $_SESSION['message'] ='<p class="text">Password reset link is sent, please check your Email address <spawn style="text-decoration:underline">'.$logIn['USER_EMAIL'] .'</spawn> for the activation link</p>'.
                        '<p><a href="login.php">Login!!</a></p>';
                    return header("location:login.php?login=reset");
                    exit();
                }else{
                    $_SESSION['ACCOUNTID']=$logIn['ACCOUNT_ID'];
                    $_SESSION['USERNM']=$logIn['USER_NAME'];
                    $_SESSION['LOGIN']=TRUE;
                    include_once 'utilities/cookies.php';
                    setProfileCookie();
                    header("location: home.php");
                    exit();
                }
            }else{
                $_SESSION['message']='<p class="error">Incorrect password</p>';
                return header("location:login.php?error=pass");
                exit();
            }
        }                
}
?>

<?php function register(){
//Verrifies and creates an new account for the user.
    include_once 'Utilities/DBFunctions.php';
    $userNm=$_POST['user'];
    $email=$_POST['email'];
    $pass=$_POST['pass'];
    $passMM=$_POST['passMM'];   
 
    //check if the passwords are same
    if($pass != $passMM){
        $_SESSION['message']="<p class='error'> Passwords mismatch </p>";
        return header("location:register.php?error=mismatch");
        exit();
    }
    
    $profileQryStr = "SELECT * FROM PROFILE_LOGIN_DATA WHERE
                    USER_NAME='".$userNm."' || USER_EMAIL='".$email."'";
    
    $profileResult = queryDB($profileQryStr);
    
    if(mysqli_num_rows($profileResult)>0){
        while($profile=$profileResult->fetch_object()){
            //check if the username already exists in use
            if($profile->USER_NAME == $userNm){
                $_SESSION['message']="<p class='error'>Account Name already exists</p>";
                return header("location:register.php?error=user");
                exit();
            }
            //check if the email is already registered
            if($profile->USER_EMAIL == $email){
                $_SESSION['message']="<p class='error'>Email already exists</p>";
                return header("location:register.php?error=email");
                exit();
            }
        }        
    }else{
        $password = password_hash($pass, PASSWORD_BCRYPT);
        $hash = md5(rand(0,1000));
        $accountId = getUniqueId("Creating user ".$userNm);
        $profileInsertStr = "INSERT INTO profile_login_data (account_id, 
                    user_name, user_email, user_pass, user_hash, user_create_date, user_status) VALUES 
                    ('".$accountId."','".$userNm."','".$email."','".$password."','".$hash."',CURRENT_TIMESTAMP,'INACTIVE')";
        //echo $profileInsertStr;
        updateDB($profileInsertStr);
        
        //Creating email strings and sending email
        include_once 'utilities/email.php';
        $link = $activateLinkPrefix."?email=".$email."&hash=".$hash;
        $toAddress=$email;
        $headers = '"From:'.$fromEmailAddress.'"';
        $emailSubject = "Welcome to Travian-Tools";
        $text = 'Hello '.$userNm.',
                    Thank you for registering on Travian Tools. To activate your account, please click -
                '.$link;
        
        include_once 'utilities/email.php';
        sendEmail($toAddress,$emailSubject,$text,$headers);    
        
        $_SESSION['message']='<p class="text">Activation email has been sent, please check your Email address <spawn style="text-decoration:underline">'.$email .'</spawn> for the activation link</p>'.
            '<p><a href="login.php">Login!!</a></p>';
        
        return header("location:register.php?register=success");
        exit();
    }
    
}
?>

<?php 
function verifyRegister(){
    include_once 'utilities/DBFunctions.php';
    $email = ($_GET["email"]);
    $hash = ($_GET["hash"]);
    
    $profile = queryDB("SELECT * FROM profile_login_data WHERE "
        ."user_email = '".$email."' AND "
        ."user_hash = '".$hash."' AND user_status='INACTIVE'");
    
    if(mysqli_num_rows($profile)>0){
        updateDB("UPDATE profile_login_data SET user_status='ACTIVE' WHERE "
            ."user_email = '".$email."' AND user_hash = '".$hash."'");
        return TRUE;
        exit();
    }else{
        return FALSE;
        exit();
    }
}
?>


<?php 
function showReset(){
    include_once 'Utilities/DBFunctions.php';
    $email=($_POST['email']);
    
    $profileDtls = queryDB("SELECT * FROM profile_login_data WHERE user_email = '".$email."'");
    
    if(mysqli_num_rows($profileDtls)==0){
        $_SESSION['message']="<p class='text'>Account with Email address <spawn style='text-decoration:underline'>".$email."</spawn> doesn't exist</p>";
        header("location:reset.php?error=email");
        exit();
    }else{
        $profile = $profileDtls->fetch_assoc();
        $hash = (md5(rand(0,1000)));
        
        $profileUdpStr = "UPDATE profile_login_data SET ".
                            " user_hash = '".$hash.
                            "', user_status ='RESET' WHERE ".
                            " user_email ='".$email."'";
        queryDB($profileUdpStr);
        
        //Creating email strings and sending email
        include_once 'utilities/email.php';
        $link = $resetLinkPrefix."?email=".$email."&hash=".$hash;
        $toAddress=$email;
        $headers = '"From:'.$fromEmailAddress.'"';
        $emailSubject = "Travian-Tools Password Reset";
        $text = 'Hello '.$userNm.',
                    Please click the below link to reset the password -
                '.$link;
        
        sendEmail($toAddress,$emailSubject,$text,$headers);  
        
        $_SESSION['message']='<p class="text">Email has been sent, please check your Email address <spawn style="text-decoration:underline">'.$email .'</spawn> for the password reset link</p>'.
            '<p><a href="login.php">Login!!</a></p>';
        return header("location:reset.php?reset=success");
        exit();
    }        
}
?>

<?php 
//function checks and validates the reset activation link
function checkReset(){
    include_once 'utilities/DBFunctions.php';
    $_SESSION['message']=''; 
    $email=($_GET['email']);
    $hash=($_GET['hash']);
    
    $profileDtls = queryDB("SELECT * FROM profile_login_data WHERE 
                        user_hash = '".$hash."' AND user_email='".$email."' 
                        AND user_status='RESET'");
    
    if(mysqli_num_rows($profileDtls)>0){
        $_SESSION['email']=$email;
        $_SESSION['hash']=$hash;
        return TRUE;
    }else{
        $_SESSION['message']='<p class="text">Invalid password reset link, please try again </p>';
        return FALSE;
    }    
}
?>

<?php 
//functions help with reseting the password by entering the new password value
function resetPassword(){
    $_SESSION['message']='';    
    include_once 'utilities/DBFunctions.php';
    
    $pass=($_POST['pass']);
    $passMM=($_POST['passMM']);
    
    if($pass != $passMM){
        $_SESSION['message']="<p class='error'> Passwords mismatch </p>";
        return header("location:reset.php?email=".$_SESSION['email']."&hash=".$_SESSION['hash']);
        exit();
    }else{
        //echo 'Reset success';
        $password = (password_hash($pass, PASSWORD_BCRYPT));
        updateDB("UPDATE profile_login_data SET user_status='ACTIVE',user_pass='".$password."'"
            ." WHERE user_email = '".$_SESSION['email']."' AND user_hash = '".$_SESSION['hash']."'");
        return TRUE;
        exit();        
    }    
}
?>

