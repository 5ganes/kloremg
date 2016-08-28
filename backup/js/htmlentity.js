// encode(decode) html text into html entity
var decodeHtmlEntity = function(str) {
  return str.replace(/&#(\d+);/g, function(match, dec) {
    return String.fromCharCode(dec);
  });
};

/*var encodeHtmlEntity = function(str) {
  var buf = [];
  for (var i=str.length-1;i>=0;i--) {
    buf.unshift(['&#', str[i].charCodeAt(), ';'].join(''));
  }
  return buf.join('');
};*/

var encodeHtmlEntity= function(astr)
{
	var bstr = '', cstr, i = 0;
	for(i; i < astr.length; ++i)
	{
		if(astr.charCodeAt(i) > 127){
		cstr = astr.charCodeAt(i).toString(10);
		while(cstr.length < 4)
		{
			cstr = '0' + cstr;
		}
		bstr += '&#' + cstr + ';';
		}
		else
		{
			bstr += astr.charAt(i);
		}
	}
	return bstr;
}

// output:
// true
// true