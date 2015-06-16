var Skip={};
Skip.getXmlHttpRequest=function (){
    if ( window.XMLHttpRequest ) // 除了IE外的其它浏览器
        return new XMLHttpRequest() ;
    else if ( window.ActiveXObject ) // IE
        return new ActiveXObject("MsXml2.XmlHttp") ;
}
//导入内容
    Skip.includeJsText =function (rootObject,jsText){
        if ( rootObject != null ){
            var oScript = document.createElement( "script" );
            oScript.type = "text/javascript";
            //oScript.id = sId;
            //oScript.src = fileUrl;
            //oScript.defer = true;
            oScript.text = jsText;
            rootObject.appendChild(oScript);
        }
    }
//导入文件
    Skip.includeJsSrc =function (rootObject, fileUrl){
        if ( rootObject != null ){
            var oScript = document.createElement( "script" );
            oScript.type = "text/javascript";
            oScript.src = fileUrl;
            rootObject.appendChild(oScript);
        }
    }
//同步加载
    Skip.addJs=function(rootObject, url) {
        var oXmlHttp = Skip.getXmlHttpRequest();
        oXmlHttp.onreadystatechange = function () {
            if (oXmlHttp.readyState == 4) {
                if (oXmlHttp.status == 200 || oXmlHttp.status == 304) {
                    Skip.includeJsSrc(rootObject, url);
                } else {
                    alert('XML request error: ' + oXmlHttp.statusText + ' (' + oXmlHttp.status + ')');
                }
            }
        }
        oXmlHttp.open('GET', url, false);
        oXmlHttp.send(null);
        Skip.includeJsText(rootObject, oXmlHttp.responseText);
    }
