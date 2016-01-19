/**
*author:zhangjun
*date:2014-4-27
*
*/
(function($){
    $.fn.codyMenu = function(options){
        var defaults = {
            "height":49,
            "z-index":527,
            contents:[
                {
                    id:'menu_download',
                    text:"直接下载",
                    href:1,
                    action:null
                },
                {
                    id:'menu_qr',
                    text:"二维码",
                    href:0,
                    action:function(p){generateQR(p)}
                },
                {
                    id:'menu_outnet',
                    text:"上传外网",
                    href:0,
                    action:function(p){upload_file(p)}
                },
                {
                    id:'menu_cdn',
                    text:"上传CDN",
                    href:0,
                    action:function(p){alert("敬请期待")}
                }
            ]
        };
        var options = $.extend(defaults, options);
        this.each(function(){
            $(this).click(function(e){
                options._org = this;
                
                winX = e.pageX || (e.clientX + (document.documentElement.scrollLeft || document.body.scrollLeft));
                winY = e.pageY || (e.clientY + (document.documentElement.scrollTop || document.body.scrollTop));
    
                console.debug(winX + '=' + winY);
                winY = winY - 15;//这里根据实际情况微调
                winX = winX - 55;
                //判断是否已经创建
                if ($("#codyMenuContent").length > 0){
                    $("#codyMenuContent").css("left",winX + "px");
                    $("#codyMenuContent").css("top",winY + "px");

                    $.each(options.contents,function(i,item){
                        var tmp_href = "javascript:void(0)";
                        if (item.href == 1){
                            tmp_href = $(options._org).attr("href");
                        }
                        
                        $("#" + item.id).attr("href",tmp_href);
                        if (item.action){
                            $("#" + item.id).unbind('click');
                            $("#" + item.id).click(function(){item.action(options._org);});
                        }
                    });
                    $("#codyMenuContent").show();
                }else{
                    $("body").append('<div id="codyMenuContent" ><div class="tips-wrap"><span class="trangle">&nbsp;&nbsp;&nbsp;&nbsp;</span><div class="inner"></div></div></div>');
                    console.debug("config menu");
                    $("#codyMenuContent").css("left",winX + "px");
                    $("#codyMenuContent").css("top",winY + "px");
                    $("#codyMenuContent").css("z-index",options["z-index"]);
                    $("#codyMenuContent").css("height",options["height"]+ "px");
                    $("#codyMenuContent").css("width","auto");
                    $("#codyMenuContent").css("display","block");
                    $("#codyMenuContent").css("position","absolute");
                    $("#codyMenuContent").css("line-height","32px");
                    $("#codyMenuContent").css("text-align","center");
                    $("#codyMenuContent").css("border-radius","1px");
                    $("#codyMenuContent").css("right","auto!important");
                    $("#codyMenuContent").css("float","left");
                    $("#codyMenuContent").css("font-size",options["font-size"]);

                    $(".trangle").css("background","url(http://static.wenku.bdimg.com/static/view/ui/panel/images/panel_99ca54b4.png) no-repeat 0 -30px");
                    $(".trangle").css("position","relative");
                    $(".trangle").css("left","-70px");
                    $(".trangle").css("top","20px");

                    $(".inner").css("box-shadow","0 0 3px #e6e6e6");
                    $(".inner").css("margin","5px");
                    $(".inner").css("background","#fff");
                    $(".inner").css("border","1px");
                    $(".inner").css("solid","1px solid #c4c4c4");
                    $(".inner").css("border-radius","2px");
                    $(".inner").append('<span> | <span>');
                    $.each(options.contents,function(i,item){
                        var tmp_href = "javascript:void(0)";
                        if (item.href == 1){
                            tmp_href = $(options._org).attr("href");
                        }
                        
                        $(".inner").append('<a id="'+item.id+'" href="'+tmp_href+'">'+item.text+'</a>');
                        if (item.action){
                            $("#" + item.id).unbind('click');
                            $("#" + item.id).click(function(){item.action(options._org);});
                        }
                        $(".inner").append('<span> | <span>');
                    });


                }
                setTimeout(function(){$("#codyMenuContent").hide();},3000);
                e.preventDefault();
            });
        });
    };
})(jQuery);
