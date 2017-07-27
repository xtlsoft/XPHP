<html>
    <head>
        <title>XPHP {{$L['System']['Error']}}</title>
        <style>
            body{
                margin:0;
                padding:30px;
                font:12px/1.5 "Microsoft Yahei UI",Helvetica,Arial,Verdana,sans-serif;
            }
            h1{
                margin:0;
                font-size:48px;
                font-weight:normal;
                line-height:48px;
            }
            strong{
                display:inline-block;
                width:65px;
            }
        </style>
    </head>
    <body>
        <h1>{{$L['System']['Error']}} {{$no ? "#".$no : ""}} :</h1>
        <h3>
            {{$e}}
        </h3>
        <p>{{$L['System']['WeHadRecordThisError']}}</p>
        
        {{# if ($jump){ }}
            <a href='{{$jump}}'>{{$L['System']['jumpNow']}}</a> ({{$sec}}{{$L['System']['SecondsAfterAutoJump']}})
            <script type="text/javascript">
                window.setTimeout("window.location.href='{{$jump}}';",{{$sec}}*1000);
            </script>
        {{# }else{ }}
            <a href='/'>{{$L['System']['BackHome']}}</a>
        {{# } }}
    </body>
</html>