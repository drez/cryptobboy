<?php

use ApiGoat\Utility\Assets;

$Assets = new Assets(['deployment_type' => _DEPLOYMENT_TYPE, 'pipeline' => true]);
$Assets->add(_SITE_URL . 'public/css/main.css');
$Assets->add('public/css/remix/remixicon.css');
$Assets->add('public/js/index.js');
$Assets->add('public/js/selectbox.js');
$Assets->add('vendor/components/jqueryui/ui/minified/jquery-ui.min.js');

$AssetsAdmin = new Assets(['deployment_type' => _DEPLOYMENT_TYPE, 'pipeline' => false]);
$AssetsAdmin->add('vendor/moxiecode/plupload/js/plupload.full.min.js');
$AssetsAdmin->add( 'public/css/apigoat.css');
$AssetsAdmin->add('vendor/moxiecode/plupload/js/jquery.plupload.queue/jquery.plupload.queue.min.js');
$AssetsAdmin->add('vendor/moxiecode/plupload/js/moxie.js');
$AssetsAdmin->add('vendor/ckeditor/ckeditor/ckeditor.js');
$AssetsAdmin->add('vendor/ckeditor/ckeditor/adapters/jquery.js');
$AssetsAdmin->add('public/js/ckeditor.config.js');

$AssetsHead = new Assets(['deployment_type' => _DEPLOYMENT_TYPE, 'pipeline' => true]);
$AssetsHead->add('vendor/components/jquery/jquery.min.js');
$AssetsHead->add("public/js/jquery.md5.js");
