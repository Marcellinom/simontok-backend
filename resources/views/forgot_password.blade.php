<!DOCTYPE html>
<html>

<table align="center" cellpadding="0" cellspacing="0" border="0" width="100%"bgcolor="#f0f0f0">
    <tr>
        <td style="padding: 30px 30px 20px 30px;">
            <table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#ffffff" style="max-width: 650px; margin: auto;">
                <tr>
                    <td colspan="2" align="center" style="background-color: #333; padding: 40px;">
                        <a href="http://wso2.com/" target="_blank"><img src="http://cdn.wso2.com/wso2/newsletter/images/nl-2017/wso2-logo-transparent.png" border="0" /></a>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center" style="padding: 50px 50px 0px 50px;">
                        <h1 style="padding-right: 0em; margin: 0; line-height: 40px; font-weight:300; font-family: 'Nunito Sans', Arial, Verdana, Helvetica, sans-serif; color: #666; text-align: left; padding-bottom: 1em;">
                            Lupa Password?
                        </h1>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left; padding: 0px 50px;" valign="top">
                        <p style="font-size: 18px; margin: 0; line-height: 24px; font-family: 'Nunito Sans', Arial, Verdana, Helvetica, sans-serif; color: #666; text-align: left; padding-bottom: 3%;">
                            Hi {{$name}},
                        </p>
                        <p style="font-size: 18px; margin: 0; line-height: 24px; font-family: 'Nunito Sans', Arial, Verdana, Helvetica, sans-serif; color: #666; text-align: left; padding-bottom: 3%;">
                            Please change your password here <a href="{{config('app.fe_domain')}}/lupa_password?token={{$token}}">{{config('app.fe_domain')}}/lupa_password?token={{$token}}</a>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left; padding: 30px 50px 50px 50px" valign="top">
                        <p style="font-size: 18px; margin: 0; line-height: 24px; font-family: 'Nunito Sans', Arial, Verdana, Helvetica, sans-serif; color: #505050; text-align: left;">
                            Thanks,<br/>Simontok Team
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center" style="padding: 20px 40px 40px 40px;" bgcolor="#f0f0f0">
                        <p style="font-size: 12px; margin: 0; line-height: 24px; font-family: 'Nunito Sans', Arial, Verdana, Helvetica, sans-serif; color: #777;">
                            &copy; 2022
                            <a href="http://wso2.com/" target="_blank" style="color: #777; text-decoration: none">Simontok</a>
                            <br>
                            Departemen Teknik Informatika ITS
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</html>
