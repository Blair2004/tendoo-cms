<?php
// System
$lang[ 'database-installed' ]            =    tendoo_success(__('Database has been installed.'));
$lang[ 'database-not-found' ]            =    tendoo_error(__('Tendoo can\'t access to the database.'));
$lang[ 'unable-to-connect' ]            =    tendoo_error(__('Tendoo cannot connect to your database host.'));
$lang[ 'error-occured' ]                =    tendoo_error(__('An error occured.'));
$lang[ 'unexpected-error' ]                =    tendoo_error(__('An unexpected error occured.'));
$lang[ 'access-denied' ]                =    tendoo_error(__('Access Denied.'));
$lang[ 'option-saved' ]                    =    tendoo_success(__('Option was successfully saved.'));
$lang[ 'unable-to-find-item' ]			=	tendoo_error( __( 'Unable to find this item. It may have been deleted or moved.' ) );
// Login page
$lang[ 'signin-notice-message' ]        =    __('Sign in to start your session');
$lang[ 'recovery-notice-message' ]        =    __('Please enter your email addresse. A recovery email will be send to you.');
$lang[ 'user-logged-in' ]                =    tendoo_success(__('You logged in successfully.'));
$lang[ 'wrong-password-or-credentials' ]=    tendoo_error(__('Wrong Password or User Name'));
$lang[ 'login-required' ]                =    tendoo_info(__('Login is required.'));
// Registration
$lang[ 'username-used' ]                =    tendoo_error(__('Username is already used by another user.'));
$lang[ 'email-used' ]                    =    tendoo_error(__('This email is already used.'));
$lang[ 'email-already-taken' ]            =    tendoo_error(__('This email seems to be already taken.'));
$lang[ 'username-already-taken' ]        =    tendoo_error(__('This username seems to be already taken.'));
$lang[ 'user-created' ]                    =    tendoo_success(__('The user has been successfully created.'));
$lang[ 'account-activated' ]            =    tendoo_success(__('Your Account has been activated. Please Sign-up'));
// Recovery
$lang[ 'unknow-email' ]                    =    tendoo_error(__('Unknow email address'));
$lang[ 'recovery-email-send' ]            =    tendoo_success(__('The recovery email has been send. Please check your email, open the recovery email and follow the instructions.'));
// Logout
$lang[ 'logout-required' ]                =    tendoo_info(__('You must logout first to access that page.'));
// General
$lang[ 'new-password-created' ]            =    tendoo_success(__('A new password has been created for your account. Check your email to get it.'));
$lang[ 'module-enabled' ]                =    tendoo_success(__('The module has been enabled.'));
$lang[ 'module-disabled' ]                =    tendoo_success(__('The module has been disabled.'));
$lang[ 'module-removed' ]                =    tendoo_success(__('The module has been removed.'));
$lang[ 'module-extracted' ]                =    tendoo_success(__('The module has been extracted.'));
$lang[ 'module-updated' ]                =    tendoo_success(__('The module has been updated.'));
$lang[ 'old-version-cannot-be-installed' ]    =    tendoo_error(__('The version installed is already up to date.'));
$lang[ 'unable-to-update' ]                =    tendoo_error(__('An error occured during update.'));
$lang[ 'config-file-not-found' ]            =    tendoo_error(__('Config file hasn\'t been found. This file is not a valid module. Installation aborded !!!'));

// Extension
$lang[ 'fetch-from-upload' ]            =    function () {
        $error = array('error' =>get_instance()->upload->display_errors());
        foreach ($error as $type => $_error) {
            if ($type == 'error') {
                echo tendoo_error(strip_tags($_error));
            } else {
                echo tendoo_info(strip_tags($_error));
            }
        }
};

// Migration @since 3.0.6
$lang[ 'migration-not-required' ]    =    tendoo_info(__('A migration is not required or has already been done.'));
