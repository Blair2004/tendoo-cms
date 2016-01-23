# You're using Tendoo CMS 3.0.6


Introducing Hello - First Tendoo CMS Theme
================================

We've been working on how to add theme support on Tendoo and for a little while, we were thinking about how this will work. We finaly decided to create a system similar to WordPress. There is however a slight difference. Any way this release introduce "Hello", which has a basic blog system with home page, blog, single and 404 error page.

# Core updated to Codeigniter v3.0.4

Tendoo's Codeigniter version has been updated to 3.0.4 but "System/Zip.php" has been restore since codeIgniter zip.php version cause bug during module extraction.

# Introducing Theme Module

This theme brings Theme support on Tendoo with several other features such as Menu Builder.

---
#What's new ?
**Internationalization:** New library has been included into core. Internationalization support has been improved. Now Tendoo CMS support 2 languages (French and English)
Developer must provide a language path within config.xml. E.g: &lt;language>/language&lt;/language> or &lt;language>/inc/lang&lt;/language>

# History
### News
GroceryCRUD library will be merged into core to provide better CRUD feature for tendoo CMS. Users screen, won't be supported by this feature, default feature still used .

### Actions and Filters

#### &mdash; Actions

Here are new actions added to this release :

**dashboard_header** : triggers action within dashboard header<br>
**dashboard_footer** : triggers action within dashboard footer

---
#### &mdash; Filters

Here are new filters added to this release :

**dashboard_output** : is dashboard index output.<br>
**dashboard_footer_text** : hold dashboard footer text.

### Internal Features

#### &mdash; Auto Redirect
Each page are now added as fallback when trying to access dashboard without login.

### JS API

#### &mdash; Notify

Tendoo 3.0.1 adds new methods to the JS API. Here is how you can use it.

<pre>
tendoo.notify.success( [title], [message], [url], [keepvisible]); // will print a success notice.

tendoo.notify.error( [title], [message], [url], [keepvisible]); // will print a error notice.

tendoo.notify.warning( [title], [message], [url], [keepvisible]); // will print a warning notice.

tendoo.notify.info( [title], [message], [url], [keepvisible]); // will print an info notice.
</pre>

#### &mdash; BootBox
Bootbox.js is a small JavaScript library which allows you to create programmatic dialog boxes using Bootstrap modals, without having to worry about creating, managing or removing any of the required DOM elements or JS event handlers. 

<a href="http://bootboxjs.com/#download">BooBox Official Web site</a>
<pre>
bootbox.alert(message, callback)

bootbox.prompt(message, callback)

bootbox.confirm(message, callback)
</pre>

#### &mdash;  Loader
Automatic loader is now added on dashboard header each time XHR request are send and stopped.

**How to trigger loader**

<pre>
tendoo.loader.show(); // to show loader
tendoo.loader.hide(); // to hide loader 
</pre>