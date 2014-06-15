<!DOCTYPE html>

<html>
    <head>
        <title><?= isset($title) ? $title : 'Home' ?> &middot; DBdev</title>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">

        <link href="./media/bootstrap3/css/bootstrap.css" rel="stylesheet"> <!-- Bootstrap -->
        <link href="./media/style.css" rel="stylesheet">
        <link rel="shortcut icon" href="./media/favicon.png">
    </head>

    <body>
        <div id="content">
            <div class="container">
                <div class="page-header">
                    <h1><?= isset($subtitle) ? $subtitle : (isset($title) ? $title : 'Home') ?> <small>DBdev</small></h1>
                </div>
