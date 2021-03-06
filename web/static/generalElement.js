//根据select选择值的类型,动态生成select和input
function generalElement(table, obj)
{
    //根据参数类型改变参数值项
    var val_type = $(obj).find('option:selected').attr('valType');
    $('#'+table+' tbody').find('tr:last').children(':last').empty();
    if(val_type == "enum" || val_type == "bool")
    {   
        //创建select元素
        var sele = document.createElement("select");
        sele.setAttribute("name", "parameter_value");
        sele.setAttribute("id", "parameter_value");
        sele.setAttribute("onchange", "javascript:$(this).valid();");
        sele.setAttribute("style", "width:300px; margin-right: 40px;");

        $('#'+table+' tbody').find('tr:last').children(':last').append(sele);
        $(sele).html("<option value='' selected='selected'>请选择参数值</option>").select2();

        var options = $(obj).find('option:selected').attr('optVal').split(',');
        for(var i = 0; i < options.length; i++)
        {
            var option = document.createElement("option");
            option.setAttribute("value", $.trim(options[i]));
            option.text = $.trim(options[i]);
            sele.appendChild(option);
        }
        //添加校验规则
        $('#parameter_value').rules("remove");
        $('#parameter_value').rules("add",{required: true, messages: { required: "请选择参数值"}});
    }
    else
    {
        var html = "<input type='text' class='form-control' id='parameter_value' name='parameter_value' placeholder='参数值' style='width:300px; margin-right: 40px;' />";
        $('#'+table+' tbody').find('tr:last').children(':last').append(html);
        
        $("#parameter_value").rules("remove");  
        $('#parameter_value').removeClass('error');  //删除验证的error样式
        $('#parameter_value').next().remove('label');  //删除验证信息的label
    }
}


