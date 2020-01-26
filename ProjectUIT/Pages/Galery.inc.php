<head>
    <title>Galery</title>
    <style>
        .wrpGal{
            float: left;
            display: inline-block;
            width: 31.3%;
            height: 50vh;
            margin: 1% 1% 1% 1%;
            z-index:2;
        }
        .imgGal{
            width: 100%;
            height: 100%;
            border-radius: 15px;
        }
        #bigImgGal{
            width: 100%;
            max-height: 75.322vh;
        }
        #Dark{
            visibility: hidden;
            left: 0px;
            top: 0px;
            position: fixed;
            width: 100%;
            height: 100vh;
            overflow: hidden;
            background-color: rgba(0,0,0,0.9);
            z-index:5;
        }
        #bigImgWrap{
            visibility: hidden;
            position: fixed;
            top:10%;
            left:20%;
            max-height: 75.322vh;
            width:60%;
            border:1px solid white;
            z-index:10;
        }
        #LAR,#RAR{
            top:40vh;
            visibility: hidden;
            position: fixed;
            font-size: 5em;
            font-weight: 800;
            color:white;
            z-index: 12;
            -webkit-user-select: none;      
            -moz-user-select: none;
            -ms-user-select: none;
        }
        #LAR:hover, #RAR:hover{
            cursor: pointer;
            color:yellow;
        }
        #LAR{
            left: 5%;
        }
        #RAR{
            right: 5%;
        }
    </style>
</head>
<body>
    <div class="wrpGal"><img id="IM1" onclick="imgToFront(true, event, 1)" class="imgGal" src="https://cdn.bleacherreport.net/images/team_logos/328x328/epl.png" alt="img"></div>
    <div class="wrpGal"><img id="IM2" onclick="imgToFront(true, event, 2)" class="imgGal" src="http://www.veenaija.com/vnfiles/2018/01/Cover-Image.jpg" alt="img"></div>
    <div class="wrpGal"><img id="IM3" onclick="imgToFront(true, event, 3)" class="imgGal" src="https://www.standard.co.uk/s3fs-public/thumbnails/image/2017/08/12/16/premier-league-trophy.jpg" alt="img"></div>
    <div class="wrpGal"><img id="IM4" onclick="imgToFront(true, event, 4)" class="imgGal" src="http://www.goal.com/story/premier-league-2017-18-preview-special/media/bpl-dazn-image2.png" alt="img"></div>
    <div class="wrpGal"><img id="IM5" onclick="imgToFront(true, event, 5)" class="imgGal" src="https://www.101greatgoals.com/wp-content/uploads/2017/11/GettyImages-879078388.jpg" alt="img"></div>
    <div class="wrpGal"><img id="IM6" onclick="imgToFront(true, event, 6)" class="imgGal" src="http://i.dailymail.co.uk/i/pix/2017/12/15/20/475DA3AB00000578-5184581-image-a-1_1513368711366.jpg" alt="img"></div>
    <div id="Dark" onclick="imgToFront(false, event, 0)"></div>
    <div id="bigImgWrap"><img id="bigImgGal" src="https://wallpaperlayer.com/img/2015/9/gorgeous-london-wallpaper-2509-2687-hd-wallpapers.jpg" alt="img"></div>
    <div id="LAR" onclick= "imgChange(-1)" ><<</div>
    <div id="RAR" onclick= "imgChange(1)" >>></div>

    <script>
        var ID;

        function imgToFront(i, event, id) {
            ID = id;
            if (i)
            {
                document.body.style.overflowY = "hidden";
                if (document.getElementById("IM" + (ID - 1)))
                    document.getElementById("LAR").style.visibility = "visible";
                if (document.getElementById("IM" + (ID + 1)))
                    document.getElementById("RAR").style.visibility = "visible";
                document.getElementById("Dark").style.visibility = "visible";
                document.getElementById("bigImgWrap").style.visibility = "visible";
                document.getElementById("bigImgGal").src = event.target.src;
            } else
            {
                document.body.style.overflowY = "scroll";
                document.getElementById("LAR").style.visibility = "hidden";
                document.getElementById("RAR").style.visibility = "hidden";
                document.getElementById("Dark").style.visibility = "hidden";
                document.getElementById("bigImgWrap").style.visibility = "hidden";
                document.getElementById("bigImgGal").src = "";
            }
        }

        function imgChange(inc) {

            var imgNext = document.getElementById("IM" + (ID + inc));
            var imgSec = document.getElementById("IM" + (ID + 2 * inc));

            document.getElementById("LAR").style.visibility = "visible";
            document.getElementById("RAR").style.visibility = "visible";

            if (imgNext)
            {
                document.getElementById("bigImgGal").src = imgNext.src;
                ID += inc;
                if (!imgSec)
                    if (inc > 0)
                        document.getElementById("RAR").style.visibility = "hidden";
                    else
                        document.getElementById("LAR").style.visibility = "hidden";
            }

        }
    </script>
</body>