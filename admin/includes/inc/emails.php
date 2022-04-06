<?php
function getEmailHeaders(){
    global $admin_email;
    global $site_name;
    $from = $admin_email;
    $headers = "Reply-To: $site_name <". $from .">\r\n"; 
    $headers .= "Return-Path: $site_name <". $from .">\r\n"; 
    $headers .= "From: $site_name <". $from .">\r\n" .
    $headers .= "Organization: $site_name\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "X-Priority: 3\r\n";
    $headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;
  return $headers;
}
function sendContactEmail($name, $email, $subject, $message){
    global $contact_email;
    global $site_name;
    global $site_url;
    $to = $contact_email;
    $m_subject = 'You Recieved a New Message';
    // To send HTML mail, the Content-type header must be set
  $headers = getEmailHeaders();
 $body = <<<BODY
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <title>${site_name}</title>
</head>

<body>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
            <tr>
                <td bgcolor="#eeeeee" align="center" style="padding:30px 15px">
                    <table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;padding:0px">
                        <tbody>
                            <tr>
                                <td>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tbody>
                                            <tr>
                                                <td align="center">
                                                    <a href="${site_url}" style="text-decoration:none" target="_blank">
                                                        <h2 style="font-family:sans-serif;text-align:center;color:#ffffff;background:#1076F7;margin:0;padding:30px;font-size:25px">${site_name}</h2>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:14px;color:#333;font-family:sans-serif;line-height:18px;vertical-align:top;padding:40px 20px 25px">
                                                    <p>You Recieved a new message from <a href="${site_url}">${site_name}.com</a> </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font:16px/22px 'Helvetica Neue',Arial,'sans-serif';text-align:left;color:#555555;padding:0px 40px 40px 20px">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 0">
                                                        <tbody>
                                                            <tr>
                                                                <td><b>Name:</b></td>
                                                                <td>${name}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Email:</b></td>
                                                                <td>${email}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Subject:</b></td>
                                                                <td>${subject}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Message:</b></td>
                                                                <td>${message}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
BODY;

    // Sending email
    if(mail($to, $m_subject, $body, $headers)){
        return true;
    } else{
        return false;
    }

}
function sendForgotEmail($to, $token){
    global $site_url;
    global $site_name;
    $url = $site_url;
    $headers = getEmailHeaders();
    $subject = "We received request to reset the password of your account";
    $body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>'. $site_name .'</title><meta name="viewport" content="width=device-width, initial-scale=1.0"/></head><body style="margin: 0; padding: 0;"> <table border="0" cellpadding="0" cellspacing="0" width="100%"> <tr> <td style="padding: 10px 0 30px 0;"> <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;"> <tr> <td align="center" bgcolor="#002553" style="padding: 40px 0 30px 0; color: #ffffff; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;"> <a href="'. $url .'" style="text-decoration: none;color: #ffffff;">'. $site_name .'</a> </td> </tr> <tr> <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;"> <table border="0" cellpadding="0" cellspacing="0" width="100%"> <tr> <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;"> <b>We received a request to reset the password for your account.</b> </td> </tr> <tr> <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;"> We received a request to reset the password for your account. If you requested a reset for the account associated with '. $to .', click the button below. </td> </tr> <tr> <td style="padding: 20px 0 20px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;text-align: center;" align="center"> <a href="'. $url .'/admin/forgot?token='. $token .'&email='. $to .'" bgcolor="#5191fa" style="text-align:center;background:#0DA3D6;color:#fff;text-decoration:none;padding:15px 20px;display:inline-block;"> Reset Password </a> </td> </tr> <tr> <td style="padding: 20px 0 20px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;"> A password reset request can be made by anyone, and while it does not indicate that your account is in any danger of being accessed by someone else, we do recommend that you ensure that you are using a secure and unique password to protect your '. $site_name .' account. We also suggest using a different password for every online account that you have. </td> </tr> <tr> <td style="padding: 20px 0 20px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 0px;"></td> </tr> <tr> <td style="padding: 20px 0 0px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;"> Best Regards </td> </tr> <tr> <td style="padding: 0px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;"> <a href="'. $url .'" style="font-family: sans-serif;text-decoration: none;">'. $site_name .'</a>. </td> </tr> </table> </td> </tr> </table> </td> </tr> </table></body></html>';
    if(mail($to, $subject, $body, $headers)){
        return true;
    } else {
        return false;
    }
}
function sendVerifyEmail($to, $token){
    global $site_url;
    global $site_name;
    $url = $site_url;
    $headers = getEmailHeaders();
    $subject = "We received request to reset the password of your account";
    $body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>'. $site_name .'</title><meta name="viewport" content="width=device-width, initial-scale=1.0"/></head><body style="margin: 0; padding: 0;"> <table border="0" cellpadding="0" cellspacing="0" width="100%"> <tr> <td style="padding: 10px 0 30px 0;"> <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;"> <tr> <td align="center" bgcolor="#002553" style="padding: 40px 0 30px 0; color: #ffffff; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;"> <a href="'. $url .'" style="text-decoration: none;color: #ffffff;">'. $site_name .'</a> </td> </tr> <tr> <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;"> <table border="0" cellpadding="0" cellspacing="0" width="100%"> <tr> <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;"> <b>We recieved a request for creating account.</b> </td> </tr> <tr> <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">We received a request to create account for this email. If you did not make this request, please <a href="'. $url .'/contact" style="font-family: sans-serif;text-decoration: none;">let us know</a>. If you requested an account associated with '. $to .', click the button below. </td> </tr> <tr> <td style="padding: 20px 0 20px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;text-align: center;" align="center"> <a href="'. $url .'/login?token='. $token .'&email='. $to .'" bgcolor="#5191fa" style="text-align:center;background:#0DA3D6;color:#fff;text-decoration:none;padding:15px 20px;display:inline-block;"> Verify Email Address </a> </td> </tr> <tr> <td style="padding: 20px 0 20px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;"> If you did not make the request for creating account then please let us now </td> </tr> <tr> <td style="padding: 20px 0 20px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;"> If you have any questions, please <a href="'. $url .'/contact" style="font-family: sans-serif;text-decoration: none;">contact us</a>. Thank you for using '. $site_name .'. </td> </tr> <tr> <td style="padding: 20px 0 0px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;"> Best Regards </td> </tr> <tr> <td style="padding: 0px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;"> <a href="'. $url .'" style="font-family: sans-serif;text-decoration: none;">'. $site_name .'</a>. </td> </tr> </table> </td> </tr> </table> </td> </tr> </table></body></html>';
    if(mail($to, $subject, $body, $headers)){
        return true;
    } else {
        return false;
    }
}