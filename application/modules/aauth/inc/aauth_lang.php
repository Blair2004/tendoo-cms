<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/* E-mail Messages */

// Account verification
$lang['aauth_email_verification_subject'] = __('Tendoo CMS : Account Verification');
$lang['aauth_email_verification_code'] = __('Hey you have successfully created an account using Tendoo CMS. Please consider activating your account using the following verification code.\n\n<strong>Your verification code is</strong>: ');
$lang['aauth_email_verification_link'] = sprintf(__(" You can also click on (or copy and paste) the following link\n\n%s"), site_url(get_instance()->config->item('route_for_verification')));

// Password reset
$lang['aauth_email_reset_subject'] = __('Tendoo CMS : Reset Password');
$lang['aauth_email_reset_link'] = sprintf(__("To reset your password click on (or copy and paste in your browser address bar) the link below:\n\n%s"), site_url(get_instance()->config->item('route_for_reset')));

// Password reset success
$lang['aauth_email_reset_success_subject'] = __('Tendoo CMS : Successful Pasword Reset');
$lang['aauth_email_reset_success_new_password'] = __('Your password has successfully been reset. Your new password is : ');


/* Error Messages */

// Account creation errors
$lang['aauth_error_email_exists'] = __('Email address already exists on the system. If you forgot your password, you can click the link below.');
$lang['aauth_error_username_exists'] = "Account already exists on the system with that username.  Please enter a different username, or if you forgot your password, please click the link below.";
$lang['aauth_error_email_invalid'] = __('Invalid e-mail address');
$lang['aauth_error_password_invalid'] = __('Invalid password');
$lang['aauth_error_username_invalid'] = __('Invalid Username');
$lang['aauth_error_username_required'] = __('Username required');

// Access errors
$lang['aauth_error_no_access'] = __('Sorry, you do not have access to the resource you requested.');
$lang['aauth_error_login_failed'] = __('E-mail Address and Password do not match.');
$lang['aauth_error_login_attempts_exceeded'] = __('You have exceeded your login attempts, your account has now been locked.');
$lang['aauth_error_recaptcha_not_correct'] = __('Sorry, the reCAPTCHA text entered was incorrect.');


// Misc. errors
$lang['aauth_error_no_user'] = __('User does not exist');
$lang['aauth_error_account_not_verified'] = __('Your account has not been verified. Please check your e-mail and verify your account.');
$lang['aauth_error_no_group'] = __('Group does not exist');
$lang['aauth_error_self_pm'] = __('It is not possible to send a Message to yourself.');
$lang['aauth_error_no_pm'] = __('Private Message not found');


/* Info messages */
$lang['aauth_info_already_member'] = __('User is already member of group');
$lang['aauth_info_group_exists'] = __('Group name already exists');
$lang['aauth_info_perm_exists'] = __('Permission name already exists');

$lang[ 'group-updated' ]            =    tendoo_success(__('The group has been updated'));

$lang[ 'fetch-error-from-auth' ]        =    function () {
    $errors_array    =    get_instance()->users->auth->get_errors_array();
    $notice_array    =    get_instance()->users->auth->get_infos_array();
    foreach ($errors_array as $_error) {
        echo tendoo_error($_error);
    }
    
    foreach ($notice_array as $notice) {
        echo tendoo_error($notice);
    }};
// User Edition
$lang[ 'user-updated' ]                    =    tendoo_success(__('User settings\'s has been updated.'));
$lang[ 'user-deleted' ]                    =    tendoo_success(__('The user has been deleted.'));
$lang[ 'pass-change-error' ]            =    tendoo_error(__('The new password cannot match the old one, please use another password.'));
$lang[ 'old-pass-incorrect' ]            =    tendoo_error(__('Your old password is not correct.'));

// Group
$lang[ 'group-already-exists' ]        =    tendoo_error(__('A group with this name already exists. Please choose another name.'));
$lang[ 'group-created' ]                =    tendoo_success(__('Group has been created.'));
$lang[ 'group-not-found' ]                =    tendoo_error(__('This group does\'nt exists or has been deleted.'));
$lang[ 'unknow-group' ]                    =    tendoo_error(__('Unknow group.'));
$lang[ 'updated' ]                        =    tendoo_success(__('Group has been updated.'));
