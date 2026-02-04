<!doctype html>

<html data-lang="{$system['language']['code']}" {if $system['language']['dir'] == "RTL"} dir="RTL" {/if}>

  <head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="generator" content="Sngine">
    <meta name="version" content="{$system['system_version']}">
    
    <!-- Google AdSense Verification -->
    <meta name="google-adsense-account" content="ca-pub-5850644658369651">
    <!-- Google AdSense Verification -->

    <!-- Title -->
    <title>{$page_title|truncate:70}</title>
    <!-- Title -->

    <!-- Meta -->
    <meta name="description" content="{$page_description|truncate:300}">
    <meta name="keywords" content="{$system['system_keywords']}">
    <!-- Meta -->

    <!-- OG-Meta -->
    <meta property="og:title" content="{$page_title|truncate:70}" />
    <meta property="og:description" content="{$page_description|truncate:300}" />
    <meta property="og:site_name" content="{__($system['system_title'])}" />
    <meta property="og:image" content="{$page_image}" />
    <!-- OG-Meta -->

    <!-- Twitter-Meta -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{$page_title|truncate:70}" />
    <meta name="twitter:description" content="{$page_description|truncate:300}" />
    <meta name="twitter:image" content="{$page_image}" />
    <!-- Twitter-Meta -->

    <!-- Preconnect/DNS-Prefetch cho tài nguyên ngoài -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://unpkg.com">
    <link rel="dns-prefetch" href="https://pagead2.googlesyndication.com">
    <link rel="dns-prefetch" href="https://ajax.googleapis.com">
    <link rel="dns-prefetch" href="https://instant.page">
    <!-- Preconnect/DNS-Prefetch -->

    <!-- Favicon -->
    {if $system['system_favicon_default']}
      <link rel="shortcut icon" href="{$system['system_url']}/content/themes/{$system['theme']}/images/favicon.png" />
    {elseif $system['system_favicon']}
      <link rel="shortcut icon" href="{$system['system_uploads']}/{$system['system_favicon']}" />
    {/if}
    <!-- Favicon -->

    <!-- Fonts [Roboto|Font-Awesome] -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet" media="print" onload="this.media='all'" crossorigin="anonymous" />
    <noscript><link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet" crossorigin="anonymous" /></noscript>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Fonts -->

    <!-- CSS -->
    {if $system['language']['dir'] == "LTR"}
      <link href="{$system['system_url']}/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
      <style>
        {minimize_css("../css/style.css")}
      </style>
    {else}
      <link rel="stylesheet" href="{$system['system_url']}/node_modules/bootstrap/dist/css/bootstrap.rtl.min.css">
      <style>
        {minimize_css("../css/style.rtl.css")}
      </style>
    {/if}
    <!-- CSS -->

    <!-- CSS Customized -->
    {include file='_head.css.tpl'}
    <!-- CSS Customized -->

    <!-- Header trong suốt (glassmorphism) -->
    <style type="text/css">
    .main-header {
      background: rgba(255, 255, 255, 0.75) !important;
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.3);
    }
    body.night-mode .main-header {
      background: rgba(38, 45, 52, 0.85) !important;
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }
    </style>
    <!-- Header trong suốt -->

    <!-- Header Custom JavaScript -->
    {if $system['custome_js_header']}
      <script>
        {html_entity_decode($system['custome_js_header'], ENT_QUOTES)}
      </script>
    {/if}
    <!-- Header Custom JavaScript -->

    <!-- User Data for JavaScript -->
    {if $user->_logged_in}
    <script>
    window.user = {
        user_id: '{$user->_data['user_id']|escape:"javascript"}',
        name: '{$user->_data['name']|escape:"javascript"}',
        user_name: '{$user->_data['user_name']|escape:"javascript"}',
        gender: '{$user->_data['user_gender']|escape:"javascript"}',
        user_gender: '{$user->_data['user_gender']|escape:"javascript"}',
        logged_in: true
    };
    </script>
    {else}
    <script>
    window.user = {
        user_id: null,
        name: 'Guest',
        user_name: 'Guest',
        gender: 'unknown',
        user_gender: 'unknown',
        logged_in: false
    };
    </script>
    {/if}

    <!-- Google AdSense - load sau khi trang ready -->
    <script>
    window.addEventListener('load', function(){ var s=document.createElement('script'); s.async=true; s.src='https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5850644658369651'; s.crossOrigin='anonymous'; document.head.appendChild(s); });
    </script>
    <!-- Google AdSense -->

</head>