<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    
    <style>
        .info_box{
            width: 80%;
            margin: 0 auto;
            text-align: center;
        }
        .info_box .title{
            margin-left: 0%;
            display: inline-block;
        }
        .info_box .login {
            display: inline-block;
            position: relative;
            left: 40%;
        }
    </style>

</head>

<body>
    <div class="info_box">
        <div class="title" onclick=window.open("index.php","_self")>
            <h1>방구석 약상자</h1>
        </div>

        <div class="login" onclick=window.open("/","_self")>
            <span class="material-symbols-outlined">account_circle</span>
        </div>
    </div>
</body>