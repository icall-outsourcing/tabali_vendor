
<html>
<head>
<title>Print Test</title>
<script>
function Print()
{
if (document.all) 
{
WebBrowser1.ExecWB(6, 2) //use 6, 1 to prompt the print dialog or 6, 6 to omit it; 
WebBrowser1.outerHTML = "Devin";
}
else
{
window.print();
}
}
</script>
</head>
<body>
<object ID="WebBrowser1" WIDTH="0" HEIGHT="0" CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2">
</object>
<A HREF="#" onClick="Print()">Print this page</a>
</body>
</html>