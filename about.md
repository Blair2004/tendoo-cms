# You're using Tendoo CMS 3.0.4


Congratulation, Tendoo CMS 3.0.4 has been successfully installed. This page is a summary of what you can expect for it : (improvements, new features, bug fixes, and so on).
Thank's for having choosed Tendoo CMS to build your web application.

---

# Bug Fix
Tendoo CMS users has faced some issue, while trying to install Tendoo CMS on production server. This bug has been discovered within core files, and this bug is due to back slash and forward slash usage on file path. Hope you'll enjoy this new release.

# What's new

## 1. News
GroceryCRUD library will be merge into core to provide better CRUD feature for tendoo CMS. Users screen, won't be supported by this feature, default feature still used .



## 2. Actions and Filters

### &mdash; Actions

Here are new actions added to this release :

**dashboard_header** : triggers action within dashboard header<br>
**dashboard_footer** : triggers action within dashboard footer

---
### &mdash; Filters

Here are new filters added to this release :

**dashboard_output** : is dashboard index output.<br>
**dashboard_footer_text** : hold dashboard footer text.

## 3. Internal Features

### &mdash; Auto Redirect
Each page are now added as fallback when trying to access dashboard without login.

## 4. JS API

### &mdash; Notify

Tendoo 3.0.1 adds new methods to the JS API. Here is how you can use it.

<pre>
tendoo.notify.success( [title], [message], [url], [keepvisible]); // will print a success notice.

tendoo.notify.error( [title], [message], [url], [keepvisible]); // will print a error notice.

tendoo.notify.warning( [title], [message], [url], [keepvisible]); // will print a warning notice.

tendoo.notify.info( [title], [message], [url], [keepvisible]); // will print an info notice.
</pre>

### &mdash; BootBox
Bootbox.js is a small JavaScript library which allows you to create programmatic dialog boxes using Bootstrap modals, without having to worry about creating, managing or removing any of the required DOM elements or JS event handlers. 

<a href="http://bootboxjs.com/#download">BooBox Official Web site</a>
<pre>
bootbox.alert(message, callback)

bootbox.prompt(message, callback)

bootbox.confirm(message, callback)
</pre>

### &mdash;  Loader
Automatic loader is now added on dashboard header each time XHR request are send and stopped.

**How to trigger loader**

<pre>
tendoo.loader.show(); // to show loader
tendoo.loader.hide(); // to hide loader 
</pre>