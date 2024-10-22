<script type='text/javascript'>
    var LBL_LOGIN_SUBMIT = '{sugar_translate module="Users" label="LBL_LOGIN_SUBMIT"}';
    var LBL_REQUEST_SUBMIT = '{sugar_translate module="Users" label="LBL_REQUEST_SUBMIT"}';

</script>
{literal}

    <link href="modules/CL_custom_login/loginSlider/css/jquery.bxslider.css" rel="stylesheet"/>
{/literal}
<div class="login-form" style="display: none">
    <div class="header"><h1><img height="{$LOGO_HEIGHT}" border="0" width="{$LOGO_WIDTH}" alt="Company Logo"
                                 style="float: right"
                                 src="{$LOGO_URL}"></h1></div>
    <div class="content">

        {* <h2>{$WELCOME_TO} {$COMPANY_NAME}</h2> *}
        <table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
            <tr>
                <td colspan="2" align="left">
                    <div id="login_form">
                        <form action="index.php" method="post" name="DetailView" id="form" onsubmit="return document.getElementById('cant_login').value == ''">
                            <table cellpadding="0" cellspacing="2" border="0" align="center" width="100%">
                                <input type="hidden" name="module" value="Users">
                                <input type="hidden" name="action" value="Authenticate">
                                <input type="hidden" name="return_module" value="Users">
                                <input type="hidden" name="return_action" value="Login">
                                <input type="hidden" id="cant_login" name="cant_login" value="">
                                <input type="hidden" name="login_module"
                                       value="{$LOGIN_MODULE}">
                                <input type="hidden" name="login_action"
                                       value="{$LOGIN_ACTION}">
                                <input type="hidden" name="login_record"
                                       value="{$LOGIN_RECORD}">
                                {if $LOGIN_ERROR_CONDITION}
                                    <tr>
                                        <td class="dataLabel" colspan="2" valign="top" style="padding-bottom:10px;"><span
                                                class="error">{$LOGIN_ERROR_LBL} : {$LOGIN_ERROR}</span></td>

                                    </tr>
                                {else}
                                    <tr>
                                        <td class="dataLabel" width='1%'></td>
                                        <td class="dataLabel"><span id='post_error' class="error"></span></td>
                                    </tr>
                                {/if}
                                {if !empty($SELECT_LANGUAGE)}
                                    <tr>
                                        <td scope="row">{sugar_translate module="Users" label="LBL_LANGUAGE"}:</td>
                                        <td><select style='width: 152px' name='login_language' onchange="switchLanguage(this.value)">{$SELECT_LANGUAGE}</select></td>
                                    </tr>
                                {/if}
                                {if $SHOW_BROWSER_UNSUPPORTED}
                                    <tr>
                                        <td colspan="2">
                                            <label class="alert alert-danger" style="width: 100%; font-weight: bolder; text-align: center;">Browser Not Supported</label>
                                        </td>
                                    </tr>
                                {/if}
                                <tr>

                                    <td width="70%" colspan="2">
                                        <label class="form-label"> {$LOGIN_USER_NAME_LBL}: </label><br/>
                                        <input type="text" size='20' tabindex="1" id="user_name" name="user_name" class="form-input"
                                               value="{$LOGIN_USER_NAME}"></td>
                                </tr>
                                <tr>

                                    <td width="70%" colspan="2"><label
                                            class="form-label">{$LOGIN_PASSWORD_LBL}
                                            : </label><br/><input type="password" size='20' tabindex="2" id="{$INPUT_PASSWORD}"
                                                              name="{$INPUT_PASSWORD}" class="form-input"
                                                              value="{$LOGIN_PASSWORD}"></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="2"><input style="{$BUTTONP}"
                                                                        title="{$LBL_LOGIN_BUTTON_TITLE}"
                                                                        accessKey="{$LBL_LOGIN_BUTTON_TITLE}" class="button {$SUITECLASS}"
                                                                        type="submit" tabindex="3" id="login_button" name="Login"
                                                                        value="{$LBL_LOGIN_BUTTON_LABEL}"><br>&nbsp;
                                    </td>

                                </tr>

                            </table>
                        </form>
                    </div>
                </td>
            </tr>

            <tr>
                <td colspan="2" align="left">
                    <div id='more' style='display:none;'>
                        <form action="index.php" method="post" name="fp_form" id="fp_form">
                            <table cellpadding="0" cellspacing="2" border="0" align="center" width="100%">
                                <tbody>
                                    <tr>
                                        <td width="70%" colspan="2">
                                            <input type="hidden" name="entryPoint" value="GeneratePassword">
                                            <label class="form-label"> {sugar_translate module="Users" label="LBL_USER_NAME"}
                                                : </label><br>
                                            <input type="text" size='26' id="fp_user_name" name="fp_user_name" class="form-input"
                                                   value='{$LOGIN_USER_NAME}'/>
                                        </td>
                                    </tr>
                                    <tr>

                                        <td width="70%" colspan="2"><label
                                                class="form-label">{sugar_translate module="Users" label="LBL_EMAIL"}
                                                :</label><br>
                                            <input type="text" size='26' id="fp_user_mail" class="form-input" name="fp_user_mail"
                                                   value=''>
                                        </td>
                                    </tr>
                                    {if $CAPTCHA_CODE}
                                        <tr>
                                            <td width='70%' colspan="2">
                                                <label
                                                    class="form-label">{$LBL_RECAPTCHA_INSTRUCTION}:
                                                    :</label><br>
                                                <input type='text' size='26' id='recaptcha_response_field' class="form-input" value=''></td>

                                        </tr>
                                        <tr>

                                            <td colspan='2'><div style='margin-left:2px'class='x-sqs-list' id='recaptcha_image'></div></td>
                                        </tr>
                                        <tr>
                                            <td colspan='2' align='right'><a href='javascript:Recaptcha.reload()'>{$LBL_RECAPTCHA_NEW_CAPTCHA}</a>&nbsp;&nbsp;
                                            </td>
                                        </tr>
                                    {/if}
                                    <tr><td colspan="2" id="generate_success" class='error'></td></tr>
                                    <tr>
                                        <td align="left" width="70%" colspan="2">
                                            <input style="float: left; display:inline;" title="Email Temp Password" class="button {$SUITECLASS}" type="button"
                                                   onclick="validateAndSubmit();
                                                           return document.getElementById('cant_login').value == ''"
                                                   id="generate_pwd_button" name="fp_login" value="{sugar_translate module="Users" label="LBL_LOGIN_SUBMIT"}">
                                            <div id="wait_pwd_generation" style="float: left;padding: 15px;"></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>

                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <!--  <div class="option" style="cursor: hand; cursor: pointer; margin:15px 0px 10px 0px;" onclick='toggleDisplay("more");'> -->

                    <div class="option" style="cursor: hand; cursor: pointer; margin:15px 0px 10px 0px;" onclick=''>
                        <a href='javascript:void(0)' id='option_link'>{sugar_translate module="Users" label="LBL_LOGIN_FORGOT_PASSWORD"}</a>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="login-slider" style="visibility: hidden">
    <ul class="bxslider">
        {if $DISABLED_PLUGIN_LOGINSLIDER!=true}
            {if $IS_SLIDER_IMAGE_ARRAY}
                {foreach from=$SLIDER_IMAGES item=item}
                    <li><img src="{$item}"/></li>
                    {/foreach}
                {/if}
            {/if}
    </ul>
</div>
{if $CAPTCHA_CODE}
    {literal}
        <script type='text/javascript' src='include/javascript/sugar_grp1_yui.js'></script><script type='text/javascript' src='include/javascript/sugar_grp_yui2.js'></script>
        <script type='text/javascript' src='http://api.recaptcha.net/js/recaptcha_ajax.js'></script>
        <script>
            function initCaptcha() {
                Recaptcha.create({/literal}'{$CAPTCHA_PUBLICKEY}'{literal}, 'captchaImage', {theme: 'custom'});
            }
            window.onload = initCaptcha;

            var handleFailure = handleSuccess;
            var handleSuccess = function (o) {
                if (o.responseText !== undefined && o.responseText == 'Success') {
                    generatepwd();
                    Recaptcha.reload();
                }
                else {
                    if (o.responseText != '')
                        document.getElementById('generate_success').innerHTML = o.responseText;
                    Recaptcha.reload();
                }
            }
            var callback2 = {success: handleSuccess, failure: handleFailure};

            function validateAndSubmit() {
                var form = document.getElementById('form');
                var url = '&to_pdf=1&module=Home&action=index&entryPoint=Changenewpassword&recaptcha_challenge_field=' + Recaptcha.get_challenge() + '&recaptcha_response_field=' + Recaptcha.get_response();
                YAHOO.util.Connect.asyncRequest('POST', 'index.php', callback2, url);
            }
        </script>
    {/literal}
{else}
    {literal}
        <script>
            function validateAndSubmit() {
                generatepwd();
            }
        </script>
    {/literal}
{/if}
{literal}
    <script>
        function generatepwd() {
            document.getElementById('generate_pwd_button').value = 'Please Wait';
            document.getElementById('generate_pwd_button').disabled = 1;
            document.getElementById('wait_pwd_generation').innerHTML = '<img src="themes/default/images/img_loading.gif" >';
            var callback;
            callback = {
                success: function (o) {
                    document.getElementById('generate_pwd_button').value = LBL_LOGIN_SUBMIT;
                    document.getElementById('generate_pwd_button').disabled = 0;
                    document.getElementById('wait_pwd_generation').innerHTML = '';
                    checkok = o.responseText;
                    //OnTrack #1220
                    //if (checkok.charAt(0) != '1')
                    //    document.getElementById('generate_success').innerHTML = checkok;
                    //else 
                    document.getElementById('generate_success').innerHTML = LBL_REQUEST_SUBMIT;
                },
                failure: function (o) {
                    document.getElementById('generate_pwd_button').value = LBL_LOGIN_SUBMIT;
                    document.getElementById('generate_pwd_button').disabled = 0;
                    document.getElementById('wait_pwd_generation').innerHTML = '';
                    alert(SUGAR.language.get('app_strings', 'LBL_AJAX_FAILURE'));
                }
            }
            postData = '&to_pdf=1&module=Home&action=index&entryPoint=GeneratePassword&username=' + document.getElementById("fp_user_name").value + '&user_email=' + document.getElementById("fp_user_mail").value + '&link=1';
            YAHOO.util.Connect.asyncRequest('POST', 'index.php', callback, postData);
        }
        function loadScript(url, callback) {
            var script = document.createElement("script")
            script.type = "text/javascript";
            if (script.readyState) { //IE
                script.onreadystatechange = function () {
                    if (script.readyState == "loaded" || script.readyState == "complete") {
                        script.onreadystatechange = null;
                        callback();
                    }
                };
            } else { //Others
                script.onload = function () {
                    callback();
                };
            }
            script.src = url;
            document.getElementsByTagName("head")[0].appendChild(script);
        }

        function set_focus() {
            if (document.DetailView.user_name.value != '') {
                document.DetailView.user_password.focus();
                document.DetailView.user_password.select();
            }
            else
                document.DetailView.user_name.focus();
        }
        function setLoginDialogPosition() {
            /*   $('.login-form').css({
             position: 'absolute',
             top: ($(window).height() - $('.login-form').outerHeight() - 100) / 2,
             left: ($(window).width() - $('.login-form').outerWidth()) / 2}
             );*/
            $('.bx-controls-direction').css({
                position: 'absolute',
                left: ($(window).width() - $('.bx-controls-direction').outerWidth()) / 2}
            );
        }
        loadScript("modules/CL_custom_login/loginSlider/js/jquery.js", function () {
            $(document).ready(function () {
                if (window.jQuery) {
                    $('.option').click(function () {
                        if ($('#more').css('display') == 'none') {
                            $('#login_form').fadeOut(function () {
                                $('#more').fadeIn();
                                $('#option_link').text('Login');
                            })
                        } else {
                            $('#more').fadeOut(function () {
                                $('#login_form').fadeIn();
                                $('#option_link').text('Forgot password?');
                            })
                        }
                    });
                    $('head').append('<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />');

                    $.getScript('modules/CL_custom_login/loginSlider/js/jquery.bxslider.js', function (success) {
                        $('.bxslider').bxSlider({
                            pager: false,
                            startSlide: 0,
                            controls: true,
                            auto: true,
                            touchEnabled: true,
                            mode: 'fade'
                        });
                        jQuery(function () {
                            jQuery(".bxslider li img").each(function (i, elem) {
                                var img = jQuery(elem);
                                var div = jQuery("<div />").css({
                                    background: "url(" + img.attr("src") + ") no-repeat",
                                    height: $(window).height(),
                                    width: $(window).width()
                                });
                                div.addClass("replacedImage");
                                img.replaceWith(div);
                            });
                        });
                        $('.login-slider, .login-slider .bx-wrapper, .login-slider .bx-viewport').css('height', $(window).height() + $('#footer').height());
                        $('.login-form').show();
                        $('.login-slider').css('visibility', 'visible');
                        setLoginDialogPosition();
                    });
                }
                if (action_sugar_grp1 == 'Login') {
                    if (typeof document.getElementById('header') != 'undefined' && document.getElementById('header') != null) {
                        document.getElementById('header').style.display = 'none';
                    }
                    if (typeof document.getElementById('footer') != 'undefined' && document.getElementById('footer') != null) {
                        document.getElementById('footer').style.display = 'none';
                    }
                }
                $('#content').find('table').attr('cellpadding', '0');
                $('#content').find('table').attr('cellspacing', '0');
                $('#content').find('table').attr('border', '0');
                $('#content').find('table').attr('align', 'center');
            });
            $(window).resize(function () {
                $('.replacedImage').css('height', $(window).height());
                $('.replacedImage').css('width', $(window).width());
                setLoginDialogPosition();
            });
        });
    </script>
{/literal}

