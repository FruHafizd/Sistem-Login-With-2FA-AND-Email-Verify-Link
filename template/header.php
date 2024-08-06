<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.118.2">
    <title>Sistem Manajemn Inventaris</title>
    <!-- Bootstrao 5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Iconos de bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Estilos Basicos -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="../controllers/qrcode/qrcode.min.js"></script>
    <!-- <link rel="stylesheet" href="style.css"> -->

    <style>
        body {
            height: 100%;
        }

        aside {
            /* border: 1px yellow solid; */
            position: fixed;
            overflow: auto;
            height: calc(100vh - 68px);
            justify-content: flex-start;
            align-self: flex-start;

        }

        main {
            position: relative;
            overflow: auto;
            margin-left: auto;
            justify-content: flex-end;
            align-self: flex-end;
        }

        #sidebarshow {
            display: none;

        }

        @media screen and (max-width: 575px) {
            #sidebarshow {
                display: inline;
            }

            #sidebartoggle {
                display: none;
            }
        }
    </style>


    <!-- Custom styles for this template -->

</head>
<body>