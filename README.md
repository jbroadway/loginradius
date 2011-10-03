This is a social login app for the [Elefant CMS](http://www.elefantcms.com/)
that uses the [LoginRadius](https://www.loginradius.com/) service
to provide automatic support for over two dozen popular ID providers.

### To install:

1\. Download and unzip the app into your apps folder.
2\. Edit the `apps/loginradius/conf/config.php` and add your LoginRadius API credentials.
3\. To see that it's working, go to `/loginradius` on your site.

### Embedding into a page

1\. Add or edit a page on your site
2\. In the WYSIWYG editor, click the Dynamic Objects button
3\. Choose "LoginRadius: Login" from the list
4\. Save the page

The login link should now be working on that page.

### Embedding into your layout

Add the following code to the `<body>` of your layout:

```html
{! loginradius/index?text=Sign in with LoginRadius !}
```

The login link should now be working in your template.

> Note: If you are already logged in, it will simply output nothing.
