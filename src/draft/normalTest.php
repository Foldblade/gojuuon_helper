<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>$Title$</title>
    <link rel="stylesheet" href="./css/mdui.min.css"/>
    <script src="js/jquery-3.3.1.min.js" type="text/javascript"></script>
</head>
<style>
    .btn_chose{
        width:47%;
        padding-top: 2em;
        padding-bottom: 2.5em;
        font-size: 50px;
        text-align: center;
    }
</style>
<body>

<div class="mdui-container" >
    <div class="mdui-row " >
        <div class="mdui-col-sm-12 mdui-col-md-5">
            <div class="mdui-card mdui-center">
                <div class="mdui-card-media">
                    <img src="./img/card.jpg"/>
                    <div id="countt" class="mdui-card-media-covered-top mdui-card-media-covered mdui-card-media-covered-transparent" style="text-align: right;padding-right: 2em;padding-top: 1em;">0/20</div>
                    <div id="display" class="mdui-text-center mdui-center mdui-card-media-covered mdui-card-media-covered-transparent"
                         style="font-size: 150px;height: 80%;text-shadow: black 0 0 0.04em;">

                    </div>

                </div>
                <div id="place" class="mdui-card-actions">
                    <button class="btn_chose mdui-btn mdui-btn-raised mdui-ripple" style="height: 100px;"></button>
                    <button class="btn_chose mdui-btn mdui-btn-raised mdui-ripple"></button>
                    <button class="btn_chose mdui-btn mdui-btn-raised mdui-ripple"></button>
                    <button class="btn_chose mdui-btn mdui-btn-raised mdui-ripple"></button>


                </div>
                <br>
                <br>

<!--                <div style="width: 100%;" class="mdui-text-center mdui-m-y-2" style="font-size: 3rem;">-->
<!--                    <button class="mdui-btn mdui-btn-icon mdui-btn-raised mdui-color-theme-accent mdui-ripple" onclick="prepare()"><i-->
<!--                            class="mdui-icon material-icons">refresh</i></button>-->
<!--                    <button class="mdui-btn mdui-btn-icon mdui-btn-raised mdui-color-theme-accent mdui-ripple" onclick="output()"><i-->
<!--                            class="mdui-icon material-icons">input</i></button>-->
<!--                </div>-->
                <div style="width: 100%;" class="mdui-text-center mdui-m-y-2" style="font-size: 3rem;">
                    <label class="mdui-switch">
                        <input type="checkbox" checked id="voiceSwitch"/>
                        <i class="mdui-switch-icon"></i>
                    </label>
                    <span>????????????</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mdui-hidden">
    <audio src="./voice/a.mp3" type="audio/mp3" id="voice" controls preload="none"></audio>
</div>

<script>
    var questionNum=20;
    var length=0;
    var length2=0;
    var fontsize=0;
    var buttonEnable=true;
    let notSkilled = [];
    let qingPing = [
        "???", "???", "???", "???", "???",
        "???", "???", "???", "???", "???",
        "???", "???", "???", "???", "???",
        "???", "???", "???", "???", "???",
        "???", "???", "???", "???", "???",
        "???", "???", "???", "???", "???",
        "???", "???", "???", "???", "???",
        "???", "???", "???",
        "???", "???", "???", "???", "???",
        "???", "???",
        "???"
    ];

    let qingPian = [
        "???", "???", "???", "???", "???",
        "???", "???", "???", "???", "???",
        "???", "???", "???", "???", "???",
        "???", "???", "???", "???", "???",
        "???", "???", "???", "???", "???",
        "???", "???", "???", "???", "???",
        "???", "???", "???", "???", "???",
        "???", "???", "???",
        "???", "???", "???", "???", "???",
        "???", "???",
        "???"
    ];

    let qingLuo = [
        "a", "i", "u", "e", "o",
        "ka", "ki", "ku", "ke", "ko",
        "sa", "shi", "su", "se", "so",
        "ta", "chi", "tsu", "te", "to",
        "na", "ni", "nu", "ne", "no",
        "ha", "hi", "fu", "he", "ho",
        "ma", "mi", "mu", "me", "mo",
        "ya", "yu", "yo",
        "ra", "ri", "ru", "re", "ro",
        "wa", "o",
        "n"
    ];

    var lianxi=[];
    var thisTimeQuestion=0;
    function loadQuestion()
    {
        if(thisTimeQuestion<questionNum)
        {
            displayCountNum(thisTimeQuestion+1,questionNum);
            //????????????
            if(lianxi[questionNum+thisTimeQuestion]==0)
            {
                document.getElementById("display").innerText=qingPing[lianxi[thisTimeQuestion]];

            }else{
                document.getElementById("display").innerText=qingPian[lianxi[thisTimeQuestion]];
            }
            //????????????
            document.getElementById("place").innerHTML="";
            let wrongSjs=[];
            wrongSjs[0]=(lianxi[thisTimeQuestion]+Math.floor(1+Math.random()*11))%46;
            wrongSjs[1]=(wrongSjs[0]+Math.floor(1+Math.random()*11))%46;
            wrongSjs[2]=(wrongSjs[1]+Math.floor(1+Math.random()*11))%46;
            wrongSjs[3]=(wrongSjs[2]+Math.floor(1+Math.random()*11))%46;
            for(let cho=0;cho<4;cho++)
            {

                if(cho==lianxi[thisTimeQuestion+(questionNum*2)])
                {
                    //???????????????
                    document.getElementById("place").innerHTML += '<button id="'+cho+'" class="btn_chose mdui-btn mdui-btn-raised mdui-ripple" style="height: '+length2+'px;border-radius: 5%;font-size: '+fontsize+'px;" onclick="clickAnswer(this)">'+qingLuo[lianxi[thisTimeQuestion]]+'</button>';

                }else{
                    //???????????????
                    document.getElementById("place").innerHTML += '<button id="'+cho+'" class="btn_chose mdui-btn mdui-btn-raised mdui-ripple" style="height: '+length2+'px;border-radius: 5%;font-size: '+fontsize+'px;" onclick="clickAnswer(this)">'+qingLuo[wrongSjs[cho]]+'</button>';


                }
            }

        }else{
            //??????????????????????????????????????????
            alert("?????????????????????????????????????????????")
            prepare();
        }

    }
    function displayCountNum(num,num2)
    {
        document.getElementById("countt").innerText=num+"/"+num2;

    }
    function playVoice(num) {

        if (document.getElementById("voiceSwitch").checked == true) {
            audio = document.getElementById("voice");
            if(num==1)
            {
                audio.src = "./voice/right.mp3";

            }else{
                audio.src = "./voice/wrong.mp3";

            }

            audio.play();
        }
    }
    function clickAnswer(obj) {
        if(buttonEnable==false)return;
        let id=obj.id;
        if(id==lianxi[thisTimeQuestion+(questionNum*2)])
        {

            obj.className+="new mdui-color-green";
            //???????????????????????????   ?????? index=lianxi[thisTimeQuestion]
            buttonEnable=false;
            playVoice(1);
            //????????????????????? ??????500??????
            setTimeout(function(){thisTimeQuestion+=1;loadQuestion();buttonEnable=true; }, 500);


        }else{
            //????????????????????????????????????????????????????????????????????? ??????????????????????????? index=lianxi[thisTimeQuestion]
            // lianxi[thisTimeQuestion+questionNum]==0 ??????????????????  ==1??????????????????
            //?????? index==0  ?????????????????????a???
            obj.className+="new mdui-color-red";
            playVoice(0);

        }


    }
    function prepare() {
        length=Math.floor($("#place").width()/2.1);
        length2=Math.floor(length*0.618);
        fontsize=Math.floor(length/5);
        document.getElementById("countt").style.fontSize=(Math.floor(fontsize/2))+"px";
        document.getElementById("display").style.fontSize=(3*fontsize)+"px";
        document.getElementById("place").innerHTML=" ";
        document.getElementById("place").innerHTML += '<button id="0" class="btn_chose mdui-btn mdui-btn-raised mdui-ripple" style="height: '+length2+'px;border-radius: 5%;font-size: '+fontsize+'px;" onclick="clickAnswer(this)">Agg</button>';
        document.getElementById("place").innerHTML += '<button id="1" class="btn_chose mdui-btn mdui-btn-raised mdui-ripple" style="height: '+length2+'px;border-radius: 5%;font-size: '+fontsize+'px;" onclick="clickAnswer(this)">Agg</button>';
        document.getElementById("place").innerHTML += '<button id="2" class="btn_chose mdui-btn mdui-btn-raised mdui-ripple" style="height: '+length2+'px;border-radius: 5%;font-size: '+fontsize+'px;" onclick="clickAnswer(this)">Agg</button>';
        document.getElementById("place").innerHTML += '<button id="3" class="btn_chose mdui-btn mdui-btn-raised mdui-ripple" style="height: '+length2+'px;border-radius: 5%;font-size: '+fontsize+'px;" onclick="clickAnswer(this)">Agg</button>';
        lianxi=[];
        thisTimeQuestion=0;
        for(let i=0;i<questionNum;i++)
        {
            let flag=true;

            while(flag)
            {
                let sjs=Math.floor(Math.random()*46);
                let sjs2=Math.floor(Math.random()*2);
                let sjs3=Math.floor(Math.random()*4);
                lianxi[i]=sjs;
                lianxi[i+questionNum]=sjs2;
                lianxi[i+(questionNum*2)]=sjs3;
                flag=false;
                for(let p=0;p<i;p++)
                {
                    if(lianxi[i]===lianxi[p])
                    {
                        flag=true;
                        break;

                    }
                }

            }
        }

        loadQuestion();


    }



    window.onload = function () {
        prepare();
    }
</script>

<!-- MDUI JavaScript -->
<script src="./js/mdui.min.js"></script>

</body>