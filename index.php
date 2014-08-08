<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Block Explorer</title>
        <link rel="stylesheet" href="css/bootstrap.css" type="text/css"/>
        <script>
            function init()
            {
                showBlocks();
                //setInterval(showBlocks, 15000);
            }

            function showBlocks()
            {
                if(window.XMLHttpRequest)
                {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                }
                else
                { // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }

                xmlhttp.onreadystatechange = function()
                {
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        document.getElementById("ajaxBlocks").innerHTML += xmlhttp.responseText;
                    }
                }

                xmlhttp.open("POST", "lastblocks.php?single=false", true);
                xmlhttp.send();
            }
        </script>
    </head>
    <body onload="init()">
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script src="js/bootstrap.js"></script>
        <div class="container">
            <h1>Block Explorer</h1>
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="container">
                        <ul class="nav">
                            <li class="active">
                                <a href="#lastblocks">Last Blocks</a>
                            </li>
                            <li><a href="#richlist">Rich list</a></li>
                            <li><a href="#about">About</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover" id="ajaxBlocks">
            <tr>
                <th>Height</th>
                <th>Difficulty</th>
                <th>Confirmations</th>
            </tr>
            </table>
        </div>
    </body>
</html>