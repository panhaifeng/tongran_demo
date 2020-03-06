(function($){  

002     $.fn.mailAutoComplete = function(options){  

003         var defaults = {  

004             boxClass: "mailListBox", //外部box样式  

005             listClass: "mailListDefault", //默认的列表样式  

006             focusClass: "mailListFocus", //列表选样式中  

007             markCalss: "mailListHlignt", //高亮样式  

008             zIndex: 1,  

009             autoClass: true, //是否使用插件自带class样式  

010             mailArr: ["qq.com","gmail.com","126.com","163.com","hotmail.com","yahoo.com","yahoo.com.cn","live.com","sohu.com","sina.com"], //邮件数组  

011             textHint: false, //文字提示的自动显示与隐藏  

012             hintText: "",  

013             focusColor: "#333",  

014             blurColor: "#999" 

015         };  

016         var settings = $.extend({}, defaults, options || {});  

017            

018         //页面装载CSS样式  

019         if(settings.autoClass && $("#mailListAppendCss").size() === 0){  

020             $('<style id="mailListAppendCss" type="text/css">.mailListBox{border:1px solid #369; background:#fff; font:12px/20px Arial;}.mailListDefault{padding:0 5px;cursor:pointer;white-space:nowrap;}.mailListFocus{padding:0 5px;cursor:pointer;white-space:nowrap;background:#369;color:white;}.mailListHlignt{color:red;}.mailListFocus .mailListHlignt{color:#fff;}</style>').appendTo($("head"));   

021         }  

022         var cb = settings.boxClass, cl = settings.listClass, cf = settings.focusClass, cm = settings.markCalss; //插件的class变量  

023         var z = settings.zIndex, newArr = mailArr = settings.mailArr, hint = settings.textHint, text = settings.hintText, fc = settings.focusColor, bc = settings.blurColor;  

024         //创建邮件内部列表内容  

025         $.createHtml = function(str, arr, cur){  

026             var mailHtml = "";  

027             if($.isArray(arr)){  

028                 $.each(arr, function(i, n){  

029                     if(i === cur){  

030                         mailHtml += '<div class="mailHover '+cf+'" id="mailList_'+i+'"><span class="'+cm+'">'+str+'</span>@'+arr[i]+'</div>';     

031                     }else{  

032                         mailHtml += '<div class="mailHover '+cl+'" id="mailList_'+i+'"><span class="'+cm+'">'+str+'</span>@'+arr[i]+'</div>';     

033                     }  

034                 });  

035             }  

036             return mailHtml;  

037         };  

038         //一些全局变量  

039         var index = -1, s;  

040         $(this).each(function(){  

041             var that = $(this), i = $(".justForJs").size();   

042             if(i > 0){ //只绑定一个文本框  

043                 return;   

044             }  

045             var w = that.outerWidth(), h = that.outerHeight(); //获取当前对象（即文本框）的宽高  

046             //样式的初始化  

047             that.wrap('<span style="display:inline-block;position:relative;"></span>')  

048                 .before('<div id="mailListBox_'+i+'" class="justForJs '+cb+'" style="min-width:'+w+'px;_width:'+w+'px;position:absolute;left:-6000px;top:'+h+'px;z-index:'+z+';"></div>');  

049             var x = $("#mailListBox_" + i), liveValue; //列表框对象  

050             that.focus(function(){  

051                 //父标签的层级  

052                 $(this).css("color", fc).parent().css("z-index", z);      

053                 //提示文字的显示与隐藏  

054                 if(hint && text){  

055                     var focus_v = $.trim($(this).val());  

056                     if(focus_v === text){  

057                         $(this).val("");  

058                     }  

059                 }  

060                 //键盘事件  

061                 $(this).keyup(function(e){  

062                     s = v = $.trim($(this).val());    

063                     if(/@/.test(v)){  

064                         s = v.replace(/@.*/, "");  

065                     }  

066                     if(v.length > 0){  

067                         //如果按键是上下键  

068                         if(e.keyCode === 38){  

069                             //向上  

070                             if(index <= 0){  

071                                 index = newArr.length;    

072                             }  

073                             index--;  

074                         }else if(e.keyCode === 40){  

075                             //向下  

076                             if(index >= newArr.length - 1){  

077                                 index = -1;  

078                             }  

079                             index++;  

080                         }else if(e.keyCode === 13){  

081                             //回车  

082                             if(index > -1 && index < newArr.length){  

083                                 //如果当前有激活列表  

084                                 $(this).val($("#mailList_"+index).text());    

085                             }  

086                         }else{  

087                             if(/@/.test(v)){  

088                                 index = -1;  

089                                 //获得@后面的值  

090                                 //s = v.replace(/@.*/, "");  

091                                 //创建新匹配数组  

092                                 var site = v.replace(/.*@/, "");  

093                                 newArr = $.map(mailArr, function(n){  

094                                     var reg = new RegExp(site);   

095                                     if(reg.test(n)){  

096                                         return n;     

097                                     }  

098                                 });  

099                             }else{  

100                                 newArr = mailArr;  

101                             }  

102                         }  

103                         x.html($.createHtml(s, newArr, index)).css("left", 0);  

104                         if(e.keyCode === 13){  

105                             //回车  

106                             if(index > -1 && index < newArr.length){  

107                                 //如果当前有激活列表  

108                                 x.css("left", "-6000px");     

109                             }  

110                         }  

111                     }else{  

112                         x.css("left", "-6000px");     

113                     }  

114                 }).blur(function(){  

115                     if(hint && text){  

116                         var blur_v = $.trim($(this).val());  

117                         if(blur_v === ""){  

118                             $(this).val(text);  

119                         }  

120                     }  

121                     $(this).css("color", bc).unbind("keyup").parent().css("z-index",0);  

122                     x.css("left", "-6000px");     

123                        

124                 });   

125                 //鼠标经过列表项事件  

126                 //鼠标经过  

127                 $(".mailHover").live("mouseover", function(){  

128                     index = Number($(this).attr("id").split("_")[1]);     

129                     liveValue = $("#mailList_"+index).text();  

130                     x.children("." + cf).removeClass(cf).addClass(cl);  

131                     $(this).addClass(cf).removeClass(cl);  

132                 });  

133             });  

134    

135             x.bind("mousedown", function(){  

136                 that.val(liveValue);          

137             });  

138         });  

139     };  

140        

141 })(jQuery); 
