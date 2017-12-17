<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>{{ welcome }} XPHP!</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    </head>
    <body>
        {{&include "Home/test"}}
        {{{include "Home/test"}}}
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
            h1{
                margin:0;
                font-size:38px;
                font-weight:normal;
                line-height:48px;
            }
            strong{
                display:inline-block;
                width:65px;
            }
        </style>
        
        <table border="0" width="100%" height="100%">
            <tr valign="middle" align="center">
                <td><h1>XPHP</h1></td>
            </tr>
            <tr valign="middle" align="center">
                <td><h3>Version {{ version }} {{{eval "date('Y')"}}}</h3></td>
            </tr>
        </table>
        
    </body>
</html>