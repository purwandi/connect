<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kanflow</title>

    <link rel="icon" type="image/png" sizes="32x32" href="/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/icons/favicon-16x16.png">
    <!--[if IE]><link rel="shortcut icon" href="/static/img/icons/favicon.ico"><![endif]-->
    <!-- Add to home screen for Android and modern mobile browsers -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#4DBA87">
    <!-- Add to home screen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Kanflow">
    <link rel="apple-touch-icon" href="/icons/apple-touch-icon-152x152.png">
    <link rel="mask-icon" href="/icons/safari-pinned-tab.svg" color="#4DBA87">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Add to home screen for Windows -->
    <meta name="msapplication-TileImage" content="/icons/msapplication-icon-144x144.png">
    <meta name="msapplication-TileColor" content="#000000">
  <link href="/css/app.css" rel="stylesheet"></head>
  <body>
    <noscript>
      This is your fallback content in case JavaScript fails to load.
    </noscript>

    <div id="app"></div>
    <script>
// This service worker file is effectively a 'no-op' that will reset any
// previous service worker registered for the same host:port combination.
// In the production build, this file is replaced with an actual service worker
// file that will precache your site's local assets.
// See https://github.com/facebookincubator/create-react-app/issues/2272#issuecomment-302832432

self.addEventListener('install', () => self.skipWaiting());

self.addEventListener('activate', () => {
  self.clients.matchAll({ type: 'window' }).then(windowClients => {
    for (let windowClient of windowClients) {
      // Force open pages to refresh, so that they have a chance to load the
      // fresh navigation response from the local dev server.
      windowClient.navigate(windowClient.url);
    }
  });
});
</script>
  <script type="text/javascript" src="/js/vendor.e7d2c11db78082fdd8e6.js"></script><script type="text/javascript" src="/js/app.e5ac47499de9dc0215f1.js"></script></body>
</html>
