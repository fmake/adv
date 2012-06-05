[[ extends "base/main.tpl" ]]

[[ block content ]]
<script type="text/javascript" src="/js/zerocopy/ZeroClipboard.js"></script>

	<br />
	[[raw]]
	<script>
	var hexcase = 0;var b64pad = "";function hex_mag(s) {return rstr2hex(rstr_mag(str2rstr_utf8(s)));}function b64_mag(s) {return rstr2b64(rstr_mag(str2rstr_utf8(s)));}function any_mag(s, e) {return rstr2any(rstr_mag(str2rstr_utf8(s)), e);}function hex_hmac_mag(k, d) {return rstr2hex(rstr_hmac_mag(str2rstr_utf8(k), str2rstr_utf8(d)));}function b64_hmac_mag(k, d) {return rstr2b64(rstr_hmac_mag(str2rstr_utf8(k), str2rstr_utf8(d)));}function any_hmac_mag(k, d, e) {return rstr2any(rstr_hmac_mag(str2rstr_utf8(k), str2rstr_utf8(d)), e);}function rstr_mag(s) {return binl2rstr(binl_mag(rstr2binl(s), s.length * 8));}function rstr_hmac_mag(key, data) {var bkey = rstr2binl(key);if (bkey.length > 16) {bkey = binl_mag(bkey, key.length * 8);}var ipad = Array(16), opad = Array(16);for (var i = 0; i < 16; i++) {ipad[i] = bkey[i] ^ 909522486;opad[i] = bkey[i] ^ 1549556828;}var hash = binl_mag(ipad.concat(rstr2binl(data)), 512 + data.length * 8);return binl2rstr(binl_mag(opad.concat(hash), 640));}function rstr2hex(input) {try {hexcase;} catch (e) {hexcase = 0;}var hex_tab = hexcase ? "0123456789ABCDEF" : "0123456789abcdef";var output = "";var x;for (var i = 0; i < input.length; i++) {x = input.charCodeAt(i);output += hex_tab.charAt(x >>> 4 & 15) + hex_tab.charAt(x & 15);}return output;}function rstr2b64(input) {try {b64pad;} catch (e) {b64pad = "";}var tab = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";var output = "";var len = input.length;for (var i = 0; i < len; i += 3) {var triplet = input.charCodeAt(i) << 16 | (i + 1 < len ? input.charCodeAt(i + 1) << 8 : 0) | (i + 2 < len ? input.charCodeAt(i + 2) : 0);for (var j = 0; j < 4; j++) {if (i * 8 + j * 6 > input.length * 8) {output += b64pad;} else {output += tab.charAt(triplet >>> 6 * (3 - j) & 63);}}}return output;}function rstr2any(input, encoding) {var divisor = encoding.length;var i, j, q, x, quotient;var dividend = Array(Math.ceil(input.length / 2));for (i = 0; i < dividend.length; i++) {dividend[i] = input.charCodeAt(i * 2) << 8 | input.charCodeAt(i * 2 + 1);}var full_length = Math.ceil(input.length * 8 / (Math.log(encoding.length) / Math.log(2)));var remainders = Array(full_length);for (j = 0; j < full_length; j++) {quotient = Array();x = 0;for (i = 0; i < dividend.length; i++) {x = (x << 16) + dividend[i];q = Math.floor(x / divisor);x -= q * divisor;if (quotient.length > 0 || q > 0) {quotient[quotient.length] = q;}}remainders[j] = x;dividend = quotient;}var output = "";for (i = remainders.length - 1; i >= 0; i--) {output += encoding.charAt(remainders[i]);}return output;}function str2rstr_utf8(input) {var output = "";var i = -1;var x, y;while (++i < input.length) {x = input.charCodeAt(i);y = i + 1 < input.length ? input.charCodeAt(i + 1) : 0;if (55296 <= x && x <= 56319 && 56320 <= y && y <= 57343) {x = 65536 + ((x & 1023) << 10) + (y & 1023);i++;}if (x <= 127) {output += String.fromCharCode(x);} else if (x <= 2047) {output += String.fromCharCode(192 | x >>> 6 & 31, 128 | x & 63);} else if (x <= 65535) {output += String.fromCharCode(224 | x >>> 12 & 15, 128 | x >>> 6 & 63, 128 | x & 63);} else if (x <= 2097151) {output += String.fromCharCode(240 | x >>> 18 & 7, 128 | x >>> 12 & 63, 128 | x >>> 6 & 63, 128 | x & 63);}}return output;}function str2rstr_utf16le(input) {var output = "";for (var i = 0; i < input.length; i++) {output += String.fromCharCode(input.charCodeAt(i) & 255, input.charCodeAt(i) >>> 8 & 255);}return output;}function str2rstr_utf16be(input) {var output = "";for (var i = 0; i < input.length; i++) {output += String.fromCharCode(input.charCodeAt(i) >>> 8 & 255, input.charCodeAt(i) & 255);}return output;}function rstr2binl(input) {var output = Array(input.length >> 2);for (var i = 0; i < output.length; i++) {output[i] = 0;}for (var i = 0; i < input.length * 8; i += 8) {output[i >> 5] |= (input.charCodeAt(i / 8) & 255) << i % 32;}return output;}function binl2rstr(input) {var output = "";for (var i = 0; i < input.length * 32; i += 8) {output += String.fromCharCode(input[i >> 5] >>> i % 32 & 255);}return output;}function binl_mag(x, len) {x[len >> 5] |= 128 << len % 32;x[(len + 64 >>> 9 << 4) + 14] = len;var a = 1732584193;var b = -271733879;var c = -1732584194;var d = 271733878;for (var i = 0; i < x.length; i += 16) {var olda = a;var oldb = b;var oldc = c;var oldd = d;a = mag_ff(a, b, c, d, x[i + 0], 7, -680876936);d = mag_ff(d, a, b, c, x[i + 1], 12, -389564586);c = mag_ff(c, d, a, b, x[i + 2], 17, 606105819);b = mag_ff(b, c, d, a, x[i + 3], 22, -1044525330);a = mag_ff(a, b, c, d, x[i + 4], 7, -176418897);d = mag_ff(d, a, b, c, x[i + 5], 12, 1200080426);c = mag_ff(c, d, a, b, x[i + 6], 17, -1473231341);b = mag_ff(b, c, d, a, x[i + 7], 22, -45705983);a = mag_ff(a, b, c, d, x[i + 8], 7, 1770035416);d = mag_ff(d, a, b, c, x[i + 9], 12, -1958414417);c = mag_ff(c, d, a, b, x[i + 10], 17, -42063);b = mag_ff(b, c, d, a, x[i + 11], 22, -1990404162);a = mag_ff(a, b, c, d, x[i + 12], 7, 1804603682);d = mag_ff(d, a, b, c, x[i + 13], 12, -40341101);c = mag_ff(c, d, a, b, x[i + 14], 17, -1502002290);b = mag_ff(b, c, d, a, x[i + 15], 22, 1236535329);a = mag_gg(a, b, c, d, x[i + 1], 5, -165796510);d = mag_gg(d, a, b, c, x[i + 6], 9, -1069501632);c = mag_gg(c, d, a, b, x[i + 11], 14, 643717713);b = mag_gg(b, c, d, a, x[i + 0], 20, -373897302);a = mag_gg(a, b, c, d, x[i + 5], 5, -701558691);d = mag_gg(d, a, b, c, x[i + 10], 9, 38016083);c = mag_gg(c, d, a, b, x[i + 15], 14, -660478335);b = mag_gg(b, c, d, a, x[i + 4], 20, -405537848);a = mag_gg(a, b, c, d, x[i + 9], 5, 568446438);d = mag_gg(d, a, b, c, x[i + 14], 9, -1019803690);c = mag_gg(c, d, a, b, x[i + 3], 14, -187363961);b = mag_gg(b, c, d, a, x[i + 8], 20, 1163531501);a = mag_gg(a, b, c, d, x[i + 13], 5, -1444681467);d = mag_gg(d, a, b, c, x[i + 2], 9, -51403784);c = mag_gg(c, d, a, b, x[i + 7], 14, 1735328473);b = mag_gg(b, c, d, a, x[i + 12], 20, -1926607734);a = mag_hh(a, b, c, d, x[i + 5], 4, -378558);d = mag_hh(d, a, b, c, x[i + 8], 11, -2022574463);c = mag_hh(c, d, a, b, x[i + 11], 16, 1839030562);b = mag_hh(b, c, d, a, x[i + 14], 23, -35309556);a = mag_hh(a, b, c, d, x[i + 1], 4, -1530992060);d = mag_hh(d, a, b, c, x[i + 4], 11, 1272893353);c = mag_hh(c, d, a, b, x[i + 7], 16, -155497632);b = mag_hh(b, c, d, a, x[i + 10], 23, -1094730640);a = mag_hh(a, b, c, d, x[i + 13], 4, 681279174);d = mag_hh(d, a, b, c, x[i + 0], 11, -358537222);c = mag_hh(c, d, a, b, x[i + 3], 16, -722521979);b = mag_hh(b, c, d, a, x[i + 6], 23, 76029189);a = mag_hh(a, b, c, d, x[i + 9], 4, -640364487);d = mag_hh(d, a, b, c, x[i + 12], 11, -421815835);c = mag_hh(c, d, a, b, x[i + 15], 16, 530742520);b = mag_hh(b, c, d, a, x[i + 2], 23, -995338651);a = mag_ii(a, b, c, d, x[i + 0], 6, -198630844);d = mag_ii(d, a, b, c, x[i + 7], 10, 1126891415);c = mag_ii(c, d, a, b, x[i + 14], 15, -1416354905);b = mag_ii(b, c, d, a, x[i + 5], 21, -57434055);a = mag_ii(a, b, c, d, x[i + 12], 6, 1700485571);d = mag_ii(d, a, b, c, x[i + 3], 10, -1894986606);c = mag_ii(c, d, a, b, x[i + 10], 15, -1051523);b = mag_ii(b, c, d, a, x[i + 1], 21, -2054922799);a = mag_ii(a, b, c, d, x[i + 8], 6, 1873313359);d = mag_ii(d, a, b, c, x[i + 15], 10, -30611744);c = mag_ii(c, d, a, b, x[i + 6], 15, -1560198380);b = mag_ii(b, c, d, a, x[i + 13], 21, 1309151649);a = mag_ii(a, b, c, d, x[i + 4], 6, -145523070);d = mag_ii(d, a, b, c, x[i + 11], 10, -1120210379);c = mag_ii(c, d, a, b, x[i + 2], 15, 718787259);b = mag_ii(b, c, d, a, x[i + 9], 21, -343485551);a = safe_add(a, olda);b = safe_add(b, oldb);c = safe_add(c, oldc);d = safe_add(d, oldd);}return Array(a, b, c, d);}function mag_cmn(q, a, b, x, s, t) {return safe_add(bit_rol(safe_add(safe_add(a, q), safe_add(x, t)), s), b);}function mag_ff(a, b, c, d, x, s, t) {return mag_cmn(b & c | ~b & d, a, b, x, s, t);}function mag_gg(a, b, c, d, x, s, t) {return mag_cmn(b & d | c & ~d, a, b, x, s, t);}function mag_hh(a, b, c, d, x, s, t) {return mag_cmn(b ^ c ^ d, a, b, x, s, t);}function mag_ii(a, b, c, d, x, s, t) {return mag_cmn(c ^ (b | ~d), a, b, x, s, t);}function safe_add(x, y) {var lsw = (x & 65535) + (y & 65535);var msw = (x >> 16) + (y >> 16) + (lsw >> 16);return msw << 16 | lsw & 65535;}function bit_rol(num, cnt) {return num << cnt | num >>> 32 - cnt;}function pow(n,p) {var ret_p=1;for (ip=1; ip<=p; ip++) {ret_p*=n;}return ret_p;}function inv_n(s,p) {var n=new Number(s);return pow(n,p)%10;}function magic(s){var res=hex_mag(s);var ret="";for(i=0;i<res.length&&ret.length<=7;i++){if (res.charAt(i).match(/^[0-9]{1}$/)&&(ret.length>0||res.charAt(i)!="0")){ret+=inv_n(res.charAt(i),i%3+1);}}return ret;}function randnum(s){return magic(s+"seopult");}
	
	eval(function(p,a,c,k,e,d){e=function(c){return(c<a?"":e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)d[e(c)]=k[c]||e(c);k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1;};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p;}('8={3b:"1.6",2o:"1B.1Y,1B.23,1B.2e",2i:"",2H:1a,12:"",2C:1a,Z:"",2a:\'<H V="$0">$$</H>\',R:"&#F;",1j:"&#F;&#F;&#F;&#F;",1f:"&#F;<1W/>",3c:5(){9 $(y).39("1k")[0]},I:{},N:{}};(5($){$(5(){5 1J(l,a){5 2I(A,h){4 3=(1v h.3=="1h")?h.3:h.3.1w;k.1m({A:A,3:"("+3+")",u:1+(3.c(/\\\\./g,"%").c(/\\[.*?\\]/g,"%").3a(/\\((?!\\?)/g)||[]).u,z:(h.z)?h.z:8.2a})}5 2z(){4 1E=0;4 1x=x 2A;Q(4 i=0;i<k.u;i++){4 3=k[i].3;3=3.c(/\\\\\\\\|\\\\(\\d+)/g,5(m,1F){9!1F?m:"\\\\"+(1E+1+1t(1F))});1x.1m(3);1E+=k[i].u}4 1w=1x.3d("|");9 x 1u(1w,(a.3g)?"2j":"g")}5 1S(o){9 o.c(/&/g,"&3h;").c(/</g,"&3e;")}5 1R(o){9 o.c(/ +/g,5(1X){9 1X.c(/ /g,R)})}5 G(o){o=1S(o);7(R){o=1R(o)}9 o}5 2m(2E){4 i=0;4 j=1;4 h;19(h=k[i++]){4 1b=D;7(1b[j]){4 1U=/(\\\\\\$)|(?:\\$\\$)|(?:\\$(\\d+))/g;4 z=h.z.c(1U,5(m,1V,K){4 3f=\'\';7(1V){9"$"}v 7(!K){9 G(1b[j])}v 7(K=="0"){9 h.A}v{9 G(1b[j+1t(K,10)])}});4 1A=D[D.u-2];4 2h=D[D.u-1];4 2G=2h.2v(11,1A);11=1A+2E.u;14+=G(2G)+z;9 z}v{j+=h.u}}}4 R=8.R;4 k=x 2A;Q(4 A 2r a.k){2I(A,a.k[A])}4 14="";4 11=0;l.c(2z(),2m);4 2y=l.2v(11,l.u);14+=G(2y);9 14}5 2B(X){7(!8.N[X]){4 Y=\'<Y 32="1p" 33="p/2u"\'+\' 30="\'+X+\'">\';8.N[X]=1H;7($.31.34){4 W=J.1L(Y);4 $W=$(W);$("2d").1O($W)}v{$("2d").1O(Y)}}}5 1q(e,a){4 l=e&&e.1g&&e.1g[0]&&e.1g[0].37;7(!l)l="";l=l.c(/\\r\\n?/g,"\\n");4 C=1J(l,a);7(8.1j){C=C.c(/\\t/g,8.1j)}7(8.1f){C=C.c(/\\n/g,8.1f)}$(e).38(C)}5 1o(q,13){4 1l={12:8.12,2x:q+".1d",Z:8.Z,2w:q+".2u"};4 B;7(13&&1v 13=="2l")B=$.35(1l,13);v B=1l;9{a:B.12+B.2x,1p:B.Z+B.2w}}7($.2q)$.2q({36:"2l.15"});4 2n=x 1u("\\\\b"+8.2i+"\\\\b","2j");4 1e=[];$(8.2o).2D(5(){4 e=y;4 1n=$(e).3i("V");7(!1n){9}4 q=$.3u(1n.c(2n,""));7(\'\'!=q){1e.1m(e);4 f=1o(q,e.15);7(8.2H||e.15){7(!8.N[f.a]){1D{8.N[f.a]=1H;$.3v(f.a,5(M){M.f=f.a;8.I[f.a]=M;7(8.2C){2B(f.1p)}$("."+q).2D(5(){4 f=1o(q,y.15);7(M.f==f.a){1q(y,M)}})})}1I(3s){3t("a 3w Q: "+q+\'@\'+3z)}}}v{4 a=8.I[f.a];7(a){1q(e,a)}}}});7(J.1i&&J.1i.29){5 22(p){7(\'\'==p){9""}1z{4 16=(x 3A()).2k()}19(p.3x(16)>-1);p=p.c(/\\<1W[^>]*?\\>/3y,16);4 e=J.1L(\'<1k>\');e.3l=p;p=e.3m.c(x 1u(16,"g"),\'\\r\\n\');9 p}4 T="";4 18=1G;$(1e).3j().G("1k").U("2c",5(){18=y}).U("1M",5(){7(18==y)T=J.1i.29().3k});$("3n").U("3q",5(){7(\'\'!=T){2p.3r.3o(\'3p\',22(T));2V.2R=1a}}).U("2c",5(){T=""}).U("1M",5(){18=1G})}})})(1Z);8.I["1Y.1d"]={k:{2M:{3:/\\/\\*[^*]*\\*+(?:[^\\/][^*]*\\*+)*\\//},25:{3:/\\<!--(?:.|\\n)*?--\\>/},2f:{3:/\\/\\/.*/},2P:{3:/2L|2T|2J|2O|2N|2X|2K|2Z|2U|2S|2W|2Y|2Q|51|c-50/},53:{3:/\\/[^\\/\\\\\\n]*(?:\\\\.[^\\/\\\\\\n]*)*\\/[52]*/},1h:{3:/(?:\\\'[^\\\'\\\\\\n]*(?:\\\\.[^\\\'\\\\\\n]*)*\\\')|(?:\\"[^\\"\\\\\\n]*(?:\\\\.[^\\"\\\\\\n]*)*\\")/},27:{3:/\\b[+-]?(?:\\d*\\.?\\d+|\\d+\\.?\\d*)(?:[1r][+-]?\\d+)?\\b/},4X:{3:/\\b(D|1N|1K|1I|2t|2s|4W|1z|v|1a|Q|5|7|2r|4Z|x|1G|9|1Q|y|1H|1D|1v|4|4Y|19|59)\\b/},1y:{3:/\\b(58|2k|2p|5b|5a|55|J|54|57|1t|56|4L|4K|4N|4M|4H|4G|4J)\\b/},1C:{3:/(?:\\<\\w+)|(?:\\>)|(?:\\<\\/\\w+\\>)|(?:\\/\\>)/},26:{3:/\\s+\\w+(?=\\s*=)/},20:{3:/([\\"\\\'])(?:(?:[^\\1\\\\\\r\\n]*?(?:\\1\\1|\\\\.))*[^\\1\\\\\\r\\n]*?)\\1/},21:{3:/&[\\w#]+?;/},4I:{3:/(\\$|1Z)/}}};8.I["23.1d"]={k:{25:{3:/\\<!--(?:.|\\n)*?--\\>/},1h:{3:/(?:\\\'[^\\\'\\\\\\n]*(?:\\\\.[^\\\'\\\\\\n]*)*\\\')|(?:\\"[^\\"\\\\\\n]*(?:\\\\.[^\\"\\\\\\n]*)*\\")/},27:{3:/\\b[+-]?(?:\\d*\\.?\\d+|\\d+\\.?\\d*)(?:[1r][+-]?\\d+)?\\b/},1C:{3:/(?:\\<\\w+)|(?:\\>)|(?:\\<\\/\\w+\\>)|(?:\\/\\>)/},26:{3:/\\s+\\w+(?=\\s*=)/},20:{3:/([\\"\\\'])(?:(?:[^\\1\\\\\\r\\n]*?(?:\\1\\1|\\\\.))*[^\\1\\\\\\r\\n]*?)\\1/},21:{3:/&[\\w#]+?;/}}};8.I["2e.1d"]={k:{4S:{3:/\\/\\*[^*]*\\*+([^\\/][^*]*\\*+)*\\//},2f:{3:/(?:\\/\\/.*)|(?:[^\\\\]\\#.*)/},4V:{3:/\\\'[^\\\'\\\\]*(?:\\\\.[^\\\'\\\\]*)*\\\'/},4U:{3:/\\"[^\\"\\\\]*(?:\\\\.[^\\"\\\\]*)*\\"/},4P:{3:/\\b(?:[4O][2b][1s][1s]|[4R][4Q][2b][1P]|[5c][5v][1s][5u][1P])\\b/},5x:{3:/\\b[+-]?(\\d*\\.?\\d+|\\d+\\.?\\d*)([1r][+-]?\\d+)?\\b/},5y:{3:/\\b(?:5z|5w(?:5A|5E(?:5F(?:17|1c)|5G(?:17|1c))|17|1T|5B|5C|5D(?:17|1T|1c)|1c)|P(?:5h(?:5k|5j)|5e(?:5d|5g(?:5f|5l)|5r|E(?:5t|5s)|5n(?:5m|5p)|L(?:3X|3W)|O(?:S|3Y(?:3T|3S|3V))|3U|S(?:44|47|46)|41))|40)\\b/},1y:{3:/(?:\\$43|\\$42|\\$3R|\\$3G|\\$3F|\\$3I|\\$3H|\\$3C|\\$3B|\\$3D)\\b/},28:{3:/\\b(?:3O|3N|3P|3K|3J|3M|3L|48|4v|1N|1K|1I|4u|V|4x|4w|2t|4r|2s|4q|1z|4t|v|4s|4D|4C|4F|4E|4z|4y|4B|4A|4p|4d|2F|2F|4g|Q|4f|5|1y|7|4a|4m|4l|4o|4i|4k|x|4j|4h|4n|4b|4c|49|4e|3Q|3E|9|45|1Q|y|3Z|1D|5o|5q|4|19|5i)\\b/},2g:{3:/\\$(\\w+)/,z:\'<H V="28">$</H><H V="2g">$1</H>\'},1C:{3:/(?:\\<\\?[24][4T][24])|(?:\\<\\?)|(?:\\?\\>)/}}}',62,353,'|||exp|var|function||if|ChiliBook|return|recipe||replace||el|path||step|||steps|ingredients|||str|text|recipeName||||length|else||new|this|replacement|stepName|settings|dish|arguments||160|filter|span|recipes|document|||recipeLoaded|required|||for|replaceSpace||insidePRE|bind|class|domLink|stylesheetPath|link|stylesheetFolder||lastIndex|recipeFolder|options|perfect|chili|newline|ERROR|downPRE|while|false|aux|WARNING|js|codes|replaceNewLine|childNodes|string|selection|replaceTab|pre|settingsDef|push|elClass|getPath|stylesheet|makeDish|eE|Ll|parseInt|RegExp|typeof|source|exps|global|do|offset|code|tag|try|prevLength|aNum|null|true|catch|cook|case|createElement|mouseup|break|append|Ee|switch|replaceSpaces|escapeHTML|NOTICE|pattern|escaped|br|spaces|mix|jQuery|avalue|entity|preformatted|xml|Pp|htcom|aname|numbers|keyword|createRange|defaultReplacement|Uu|mousedown|head|php|com|variable|input|elementClass|gi|valueOf|object|chef|selectClass|elementPath|window|metaobjects|in|default|continue|css|substring|stylesheetFile|recipeFile|lastUnmatched|knowHow|Array|checkCSS|stylesheetLoading|each|matched|extends|unmatched|recipeLoading|prepareStep|unblockUI|ajaxSubmit|silverlight|jscom|unblock|block|plugin|clearFields|returnValue|fieldValue|blockUI|formSerialize|event|resetForm|ajaxForm|clearForm|fieldSerialize|href|browser|rel|type|msie|extend|selector|data|html|next|match|version|getPRE|join|lt|bit|ignoreCase|amp|attr|parents|htmlText|innerHTML|innerText|body|setData|Text|copy|clipboardData|recipeNotAvailable|alert|trim|getJSON|unavailable|indexOf|ig|recipePath|Date|_SESSION|_SERVER|php_errormsg|require_once|_GET|_FILES|_REQUEST|_POST|__METHOD__|__LINE__|and|abstract|__FILE__|__CLASS__|__FUNCTION__|require|_ENV|END|CONT|PREFIX|START|OCALSTATEDIR|IBDIR|UTPUT_HANDLER_|throw|__COMPILER_HALT_OFFSET__|VERSION|_COOKIE|GLOBALS|API|static|YSCONFDIR|HLIB_SUFFIX|array|protected|implements|print|private|exit|public|foreach|final|or|isset|old_function|list|include_once|include|php_user_filter|interface|exception|die|declare|elseif|echo|cfunction|as|const|clone|endswitch|endif|eval|endwhile|enddeclare|empty|endforeach|endfor|isNaN|NaN|jquery|Infinity|clearTimeout|setTimeout|clearInterval|setInterval|Nn|value|Rr|Tt|mlcom|Hh|string2|string1|delete|keywords|void|instanceof|content|taconite|gim|regexp|escape|constructor|parseFloat|unescape|toString|with|prototype|element|Ff|BINDIR|HP_|PATH|CONFIG_FILE_|EAR_|xor|INSTALL_DIR|EXTENSION_DIR|SCAN_DIR|MAX|INT_|unset|SIZE|use|DATADIR|XTENSION_DIR|OL|Ss|Aa|E_|number|const1|DEFAULT_INCLUDE_PATH|ALL|PARSE|STRICT|USER_|CO|MPILE_|RE_'.split('|'),0,{}))

	function clearCount(){
		$("#all_count").html( 0 );
		$("#price").val( 0 ) ;
	}
	
	function addCount(num){
		$("#all_count").html( parseInt($("#all_count").html()) + num );
		$("#price").val( Math.round((parseInt( $("#price").val() ) + 2*2*num/2.3/0.7 ) ) )  ;
		calculate();
	}
	//alert(randnum(75237064));
	
	function getSum(querys,start){
		var sum = 0;
		for (i = start;i < querys.length;i++){
			sum += querys[i];
			//alert(querys[i]);
		}
		return sum;
	}
	
	function getCoefficient(querys){
		var coef = [];
		for (i = 0;i < querys.length;i++){
			coef[i] =  querys[i] / querys[querys.length-1];
			//alert(querys[i]);
		}
		return coef;
	}
	
	function printAr(mas){
		var str = '[';
		for (i = 0;i < mas.length;i++){
			str = str + mas[i] + ",";
			//alert(querys[i]);
		}
		str = str + "]";
		alert(str);
	}
	
	function getLowCoefficient(coef,low){
		
		for (var i = 0;i < coef.length - 1;i++){
			
			nextHide = ( (coef[i] - coef[i+1]) / low);
			coef[i] = coef[i] - nextHide;
			nextAll = getSum(coef,i+1);
			//alert(i);
			for (var j = i+1;j < coef.length;j++){
				coef[j] = coef[j] + (coef[j] / nextAll) * nextHide;
			}
			
		}
		return coef;
	}
	
	function getPrice(coef,price,onePercent){
		var priceMas = [];
		for (var i = 0;i < coef.length;i++){
			priceMas[i] =  (coef[i] * onePercent * price);
			priceMas[i] = Math.round (coef[i] * onePercent * price);
			//alert(querys[i]);
		}
		//printAr(coef);
		return priceMas;
	}
	
	function copyToUser(){
		var mas = calculate();
		for (var j = 0;j < mas.length;j++){
			$('#user_'+j).val( mas[j] );
		}
		calculateUser();
	}
	
	function monthRound(mas){
		var priceMas = [];
		for (var j = 0;j < mas.length;j++){
			priceMas[j] = Math.round(mas[j]/30/10)*10;
		}
		return priceMas;
	}
	
	function showPrices(mas){
		for (var j = 0;j < mas.length;j++){
			var id = "ansprice_"+j;
			//var cur = Math.round(mas[j]/monthDay/10)*10;
			$('#'+id).html( mas[j] );
			$('#'+id+'_5').html(mas[j]*1.3);
		}
		
	}
	
	function isnull(mas){
		for (var j = 0;j < mas.length;j++){
			if(mas[j]==0)
				return true;
		}
		return false;
	}
	
	function lowAndCalc(){
		getLowCoefficient(coef,lowCoef);
		calculate();
	}

	
	// основная инициализация
	query = [];
	[[endraw]]
 
	[[for key,quer in querys]]
		query[query.length]= {quer['count']};
	[[endfor]]
	
	[[raw]]	
		 
	function init(){
		price = 0;
		monthDay = 30;
		coef = [];
		lowCoef = 3;
		
		coef = getCoefficient(query);
		
		getLowCoefficient(coef,lowCoef);
		onePercent = ( query[query.length-1]/getSum(query,0) );
	}
	
	
	
	function calculate(){
		price = $("#price").val();
		first = getPrice(coef,price,onePercent);
		first = monthRound(first);
		
		var iter = 0;
		while( price && isnull(first) && iter < 100){
			getLowCoefficient(coef,lowCoef);
			first = getPrice(coef,price,onePercent);
			first = monthRound(first);
			iter++;
		}
		if(iter >= 100){
			coef = getCoefficient(query);
		}
		
		showPrices (first);
		//printAr(first);
		var top10 = getSum(first,0)*monthDay;
		$('#all_count_ans').html(top10);
		
		$('#all_count_ans_5').html(Math.round(top10*1.3 ));
		var math_price = Math.round( (top10*1.3 +top10) / 2 * 0.7 )
		$('#math_price').html(math_price);
		
		var one_user_price = ( math_price / (getSum(query,0)*0.5 ) );
		$('#one_user_price').html(  Math.round (one_user_price*100)/100 );
		
		var one_percent_user_val = parseFloat($('#one_percent_user_val').val())
		var one_percent_user = one_user_price*100/one_percent_user_val;
		$('#one_percent_user').html(  Math.round (one_percent_user) );
		
		var one15_percent_user_val = parseFloat($('#one15_percent_user_val').val());
		var one15_percent_user = one_user_price*100/one15_percent_user_val;
		$('#one15_percent_user').html(  Math.round (one15_percent_user) );
		return first;
	}
	
	function calculateUser(){
		var sum = 0;
		var tmpPr = [];
		var tmpLast = 0;
		var tmpSum = 0;
		for (var j = 0;j < query.length;j++){
			sum += parseInt($('#user_'+j).val( ));
			tmpPr[j] = parseInt($('#user_'+j).val( ));
		}
		$('#user_ans').html( sum*monthDay );
		
		$("#price").val(sum*monthDay);
		
		tmpSum = getSum(coef,0);
		coef = getCoefficient(tmpPr);
		tmpLast = tmpSum / getSum(coef,0);
		for (var j = 0;j < coef.length;j++){
			coef[j] = coef[j] * tmpLast;
		}
		
		//printAr(coef);
		calculate();
	}
	
	
	function cpTrtoTr(from,to){
	
		str = ($("#main_" + from ).html(  ));
		var re = /removeQuery\(\d+\)/;
		str = ( str.replace(re,"removeQuery("+to+")") );
		var re = /ansprice\_\d+\_5/;
		str = ( str.replace(re,"ansprice_"+to+"_5") );
		var re = /ansprice\_\d+/g;
		str = ( str.replace(re,"ansprice_"+to) );
		var re = /user\_\d+/;
		str = ( str.replace(re,"user_"+to) );
		
		$("#main_"+to).html(str);
		
		$("#seopult_"+(to)).html( $("#seopult_"+from).html() );
		//$("#seopult_"+from).remove();
		
		//$("#main_"+ from ).remove();
		
	}
	
	
	
	function removeQuery(ind){
	
		/*
		str = ($("#main_" + (query.length-1) ).html(  ));
		
		//alert(str);
		changeNum = ind;
		
		var re = /removeQuery\(\d+\)/;
		str = ( str.replace(re,"removeQuery("+changeNum+")") );
		var re = /ansprice\_\d+\_5/;
		str = ( str.replace(re,"ansprice_"+changeNum+"_5") );
		var re = /ansprice\_\d+/g;
		str = ( str.replace(re,"ansprice_"+changeNum) );
		var re = /user\_\d+/;
		str = ( str.replace(re,"user_"+changeNum) );
		//seopult_price
		
		
		alert(str);
		$("#main_"+ind).html(str);
		
		$("#seopult_"+(ind)).html( $("#seopult_"+(query.length-1)).html() );
		$("#seopult_"+(query.length-1)).remove();
		*/
		for (var j = ind;j < query.length - 1 ;j++){
			cpTrtoTr(j+1,j);
		}
		$("#seopult_"+(query.length-1)).remove();
		$("#main_"+ (query.length-1) ).remove();
		
		//cpTrtoTr(query.length-1,ind);
		$("#main_"+ (query.length-1) ).remove();
		tmpMas = [];
		for (var j = 0;j < query.length;j++){
			if(ind==j)continue;
			tmpMas[tmpMas.length] = query[j];
		}
		query = tmpMas;
		clearCount();
		
		init();
		
		var i = 0;
		$(".seo_pult_ans").each(function() { 
				if(ind != i){
					addCount(parseInt($(this).html()));
				}
				i++;
			});	
		
		init();
	}
	
	init();
	
	
	
	$(document).ready(function(){ 

		$('#all_count_users').html( Math.round( getSum(query,0)/monthDay * 0.5 ) );
		initZero() ;
	});
	
	
	
	</script>
	
	<script language="JavaScript">
		var clip = null;
		//function $(id) { return document.getElementById(id); }
		
		function initZero() {
			clip = new ZeroClipboard.Client();
			clip.setHandCursor( true );
			
			clip.addEventListener('load', function (client) {
				//debugstr("Flash movie loaded and ready.");
			});
			
			clip.addEventListener('mouseOver', function (client) {
				var str = '';
				// update the text on mouse over
				 $('.copyTR').each(function(element,val) { 
					 var tmp = $(val).text().replace(/\s{2,}/gi, "  ");
					 tmp = tmp.split('  ');
					 var j = 1;
					 for(var i = 2;i<tmp.length-1;i++){
					 if(i==2){
						str += tmp[i] ;
					 }else{
						str += "\t" + tmp[i] ;
					}
						
					 }
					 
					 str += '\n';
				});	
				clip.setText(str);
				
			});
			
			clip.addEventListener('complete', function (client, text) {
				//debugstr("Copied text to clipboard: " + text );
				alert('Текст скопирован');
			});
			
			clip.glue( 'd_clip_button', 'd_clip_container' );
		}
		

	</script>

	

	<style>
		.price_val
			{width:45px;}
		.pult TD
			{height:25px;}
	</style>
	
[[endraw]]	
	
	
	[[if querys]]
	
		<h2>Итого <span id="user_ans">0</span></h2>
		<table style="width:900px;"  >
			<tr>
				<td>
					<table  style="width:400px;" >
						[[ if request.url ]]
							<tr>
								<td>
									<div>Сайт</div>
								</td>
								<td align="right">
									{request.url}
								</td>
							</tr>	
						[[endif]]
						<tr>
							<td>
								<div>Всего запросов</div>
							</td>
							<td align="right">
								{df('sizeof',querys)}
							</td>
						</tr>	
						<tr>
							<td>
								<div>Cтоимость </div>
							</td>
							<td align="right">
								<span id="all_count">0</span>
							</td>
						</tr>	
						<tr>
							<td>
								<div>ТОП5</div>
							</td>
							<td align="right">
								<span id="all_count_ans_5">0</span>
							</td>
						</tr>
						<tr>
							<td>
								<div>ТОП10 </div>
								<br />
							</td>
							<td align="right">
								<span id="all_count_ans">0</span>
							</td>
						</tr>
						<tr>
							<td>
								<div>Посещаемости в день (50%) </div>
							</td>
							<td align="right">
								 <span id="all_count_users" ></span>
							</td>
						</tr>
						
						<tr>
							<td>
								<div>Средняя выплата в месяц (70%)</div>
							</td>
							<td align="right">
								 <span id="math_price" ></span>
							</td>
						</tr>
						
						<tr>
							<td>
								<div>стоимость 1 посетителя </div>
							</td>
							<td align="right">
								 <span id="one_user_price" ></span>
							</td>
						</tr>
						<tr>
							<td>
								<div>конвесрия min <input type="text" value="3" id="one_percent_user_val" style="width:20px" onkeyup="calculate()" /> %</div>
							</td>
							<td align="right">
								 <span id="one_percent_user" ></span>
							</td>
						</tr>
						<tr>
							<td>
								<div>конвесрия max <input type="text" value="4" id="one15_percent_user_val" style="width:20px" onkeyup="calculate()" /> %</div>
							</td>
							<td align="right">
								 <span id="one15_percent_user" ></span>
							</td>
						</tr>
					</table>
					<div></div>
					
					
					
				</td>
				</tr>
				<tr>
				<td align="right">
					<input type="text" name="price" id="price" value="0" onkeyup="calculate()" />  
					<input type="submit"  onclick="lowAndCalc()" value="сгладить" /> 
					<input type="submit"  onclick="init();calculate();" value="сбросить" />  
					<input type="submit"  onclick="copyToUser();" value="изменить цены" />
					<span id="d_clip_container" style="position:relative">
						<input type="submit" id="d_clip_button"  value="скопировать" onclick=""/>
					</span>
				</td>
			</tr>
		</table>
		<table style="width:700px;" >
			<tr><td>
				<table class="pult"  >
					<tr>
						<td>
							Запрос
						</td>
						
						<td align="right">
							Колличество
						</td>
						<td align="right" >
							Топ 5
						</td>
						<td align="right" >
							Топ 10
						</td>
					</tr>
					[[set count = 0]]
					[[for key,quer in querys]]
						<tr class="copyTR" id="main_{count}" >
							<td>
								<script>
									xajax_getSeopult({quer['id']},randnum({quer['id']}));
								</script>
								<a href="javascript: void(0);" onclick="removeQuery({count});" ><img src="/images/icon-clear.png" alt="удалить" title="удалить" style="margin: 6px 2px 0 0;" /></a> 
								<a target="_blank" href="http://yandex.ru/yandsearch?text={df('htmlspecialchars',quer['query'])}&lr=213" >{quer['query']}</a>
								[[set count = count + 1]]
							</td>
							
							<td align="right">
								{quer['count']}
							</td>
							<td align="right" >
								<span id="ansprice_{key}_5" ></span>
							</td>
							<td align="right" >
								<span id="ansprice_{key}" ></span>
							</td>
							<td align="right" >
								<input type="text" name="count[]" value="" id="user_{key}" onkeyup="calculateUser();" class="price_val" />
							</td>
						</tr>
					[[endfor]]
					</table>
				</td>
				<td>
					<table class="pult"  >
					<tr>
						<td>
							&nbsp;
						</td>
						<td align="right" >
							YA
						</td>
					</tr>
					[[set count = 0]]
					[[for quer in querys]]
						<tr id="seopult_{count}" >
							<td align="right" >
								<span id="answ_{quer['id']}" class="seo_pult_ans"  ></span>&nbsp;
								[[set count = count + 1]]
							</td>
							<td align="right" >
								{quer['pos'][0]}&nbsp;
							</td>
						</tr>
					[[endfor]]
					</table>
				</td>
				</tr>
		</table>
	[[endif]]
	
<form method="post">
	<input type="hidden" name="action" value="add_words" />
	
	<table width="400">
		<tr><td>
			<textarea name="word" rows="9" align="left" style="width:50%;">[[ if capture]]{request.word}[[endif]]</textarea>
		</td></tr>
		<tr><td align="left">
		{capture}
		<input type="submit" name="subm"  value="Получить отчет" />
		</td></tr>
	</table>
	
</form>

[[ endblock ]]
