/* 
 * stringCheck.js
 * 用于配合jQuery.validation.js对英文名称的检查
 * 英文名称只能是英文,数字,下划线组成,不能有空格,只能以英文字母开头
 * @author luis
 * @time 2016-02-23
 */
$.validator.addMethod('stringCheck', function(value, element){
    return this.optional(element) || /^([a-zA-Z]|[a-zA-Z]+[a-zA-Z0-9_]+)+$/.test(value);
});

