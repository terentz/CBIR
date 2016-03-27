
/**
 * Pads a numeric string with zeros.
 */
String.prototype.lpad = function(padString, length) {
    var str = this;
    while (str.length < length)
        str = padString + str;
    return str;
}