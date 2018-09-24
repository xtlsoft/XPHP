<html>
<head>
    <title>{{$L['System']['Error']}} {{ $code }}</title>
    <style>
        body {
            margin: 0;
            padding: 30px;
            font: 12px/1.5 "Microsoft Yahei UI", Helvetica, Arial, Verdana, sans-serif;
        }

        h1 {
            margin: 0;
            font-size: 48px;
            font-weight: normal;
            line-height: 48px;
        }

        h1 {
            margin: 0;
            font-size: 38px;
            font-weight: normal;
            line-height: 48px;
        }

        strong {
            display: inline-block;
            width: 65px;
        }
    </style>
</head>
<body>
<h1>HTTP {{ $code }} :</h1>
<h2>
    {{ $msg }}
</h2>
<p>{{$L['System']['WeHadRecordThisError']}}</p>

{{# if ($jump){ }}
<a href='{{ $jump }}'>{{$L['System']['jumpNow']}}</a> (<var>$sec</var>{{$L['System']['SecondsAfterAutoJump']}})
<script type="text/javascript">
    window.setTimeout("window.location.href='{{ $jump }}';",{{ $sec }}*
    1000
    )
    ;
</script>
{{# }else{ }}
<a href='{{$GLOBALS['_C']['RouteBase']}}'>{{$L['System']['BackHome']}}</a>
{{# } }}
</body>
</html>