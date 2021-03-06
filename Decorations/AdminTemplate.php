<?php ob_start(); ?>

<!DOCTYPE html>
<html>
    <head>
    
        <meta charset="UTF-8">
        <meta name="description" content="My Project, for www univercity class" >
        <meta name="author" content="Vasileios Georgoulas">
        <meta name="keywords" content="HTML,CSS,JavaScript, PHP">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
        <script src="./MyJavaScriptFile.js"></script>
        <link rel="stylesheet" href="./Decorations/style.css">
    </head>
    <body style="background-color:#f2f2f2; height:800px" >
        <nav class="navbar shadow-sm navbar-expand-lg navbar-dark bg-primary">
            <a href="#bar" class="navbar-brand"><strong>Medical Agenda</strong></a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#myBar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="myBar" class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a href="../Authorization/Login.html" class="nav-link">Exit</a></li>
                </ul>
            </div>
        </nav>


<?php ob_end_flush();?>