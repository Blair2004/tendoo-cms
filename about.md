# You're using Tendoo CMS 3.0.6

### Bug Fix 

- "Duplicate Entry" for Post_Type database version migrate 1.0 to 1.1
- Fix Post_Type database update for v1.0 to v1.1
- Fix Sql Syntax for Post_Type


---
# History
### News

We've been working on how to add theme support on Tendoo and for a little while, we were thinking about how this will work. We finaly decided to create a system similar to WordPress. There is however a slight difference. Any way this release introduce "Hello", which has a basic blog system with home page, blog, single and 404 error page.

Tendoo's Codeigniter version has been updated to 3.0.4 but "System/Zip.php" has been restore since codeIgniter zip.php version cause bug during module extraction.

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