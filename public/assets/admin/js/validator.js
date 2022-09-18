function isEmail(email)
{
    let pattern = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/
    return pattern.test(email)
}
function isEmpty(str)
{
    return str.length == 0;
}
