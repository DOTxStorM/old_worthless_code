<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<!--
this shit is amazing
http://web.archive.org/web/20110721191046/http://particletree.com/features/rediscovering-the-button-element/
-->
<html>
    <head>
        <title>Home Page</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <style>
            /* BUTTONS */
            .buttons a, .buttons button{
                display:block;
                float:right;
                margin:0 7px 0 0;
                background-color:#f5f5f5;
                border:1px solid #dedede;
                border-top:1px solid #eee;
                border-left:1px solid #eee;    font-family:"Lucida Grande", Tahoma, Arial, Verdana, sans-serif;
                font-size:100%;
                line-height:130%;
                text-decoration:none;
                font-weight:bold;
                color:#565656;
                cursor:pointer;
                padding:5px 10px 6px 7px; /* Links */
            }
            .buttons button{
                width:auto;
                overflow:visible;
                padding:4px 10px 3px 7px; /* IE6 */
            }
            .buttons button[type]{
                padding:5px 10px 5px 7px; /* Firefox */
                line-height:17px; /* Safari */
            }
            *:first-child+html button[type]{
                padding:4px 10px 3px 7px; /* IE7 */
            }
            .buttons button img, .buttons a img{
                margin:0 3px -3px 0 !important;
                padding:0;
                border:none;
                width:16px;
                height:16px;
            }
            
            .vidButtons a, .vidButtons button{
                display:block;
                float:left;
                margin:0 7px 0 0;
                background-color:#f5f5f5;
                border:1px solid #dedede;
                border-top:1px solid #eee;
                border-left:1px solid #eee;    font-family:"Lucida Grande", Tahoma, Arial, Verdana, sans-serif;
                font-size:100%;
                line-height:130%;
                text-decoration:none;
                font-weight:bold;
                color:#565656;
                cursor:pointer;
                padding:5px 10px 6px 7px; /* Links */
            }
            .vidButtons button{
                width:auto;
                overflow:visible;
                padding:4px 10px 3px 7px; /* IE6 */
            }
            .vidButtons button[type]{
                padding:5px 10px 5px 7px; /* Firefox */
                line-height:17px; /* Safari */
            }
            *:first-child+html button[type]{
                padding:4px 10px 3px 7px; /* IE7 */
            }
            .vidButtons button img, .buttons a img{
                margin:0 3px -3px 0 !important;
                padding:0;
                border:none;
                width:16px;
                height:16px;
            }
            
            p{
                font-family:"Arial";
                font-size:14px;
                color:green;
                text-align: right;
            }
            p1{
                display: block;
                color:orange;
            }         
        </style>

    </head>
    <body onload="onLoad()">
        
        <p>
        <a href="profile_page"><img src="profile.png" width="120" height="120"></a><br>
        </p>
        <div class="buttons">
            <a href="profile_page">Profile</a>
        </div>

        <div class="vidButtons">
            <?php
                //i'm assuming that the database managing of creating a new story and such will be done on the new story page
                echo "<button type=\"button\" href=\"create_story\">Create Story</button>";
                //I'm also assuming that the load drafts button will take you to another page with a list of all the drafts you have
                echo "<button type=\"button\" href=\"load_draft\">Load Drafts</button><br><br>";
            ?>
            <hr>
            <a href="recent_video">Your Recent Videos</a><br><br>
            <?php
                for($i = 0; $i < 5; ++$i){
                    echo "<a href=\"link_to_vid\">video</a>";
                }
                echo "<br><br>";
            ?>
            <br><br><br><br><br><br>
            <a href="recent_favorites">Recently Favorited Videos</a><br><br>
            <?php
                for($i = 0; $i < 5; ++$i){
                    echo "<a href=\"link_to_vid\">video</a>";
                }
                echo "<br><br>";
            ?>
        </div>
        

    </body>
</html>
