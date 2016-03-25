/* 
 * 利用dataTables插件,对表格数据进行排序和筛选
 */
function datasSortFilter(table_id, col_num)
{
    $('#' + table_id).DataTable({
        "aoColumnDefs": [{ "bSortable": false, "aTargets": [col_num] }],
        "paging":   false,
        "info":     false,
        "dom": '<"clear">', //通过dom属性去掉search文本框
        initComplete: function () {
            $('#' + table_id + ' thead').append('<tr></tr>');

            var api = this.api();
            api.columns().indexes().flatten().each( function ( i ) {
                if(i < col_num)
                {
                    $('#' + table_id + ' thead').find('tr:last').append('<th></th>');
                    var column = api.column( i );
                    //console.log(column.header());
                    var select = $('<select class="js-source-states" style="margin-right: 40px;"><option value="">全部</option></select>')
                        .appendTo( $('#' + table_id + ' thead').find('tr:last').find('th').eq(i) )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );
                    column.data().unique().sort().each( function ( d, j ) {
                        if(d != '')
                        {
                            select.append( '<option value="'+d+'">'+d+'</option>' );
                        }
                    } );
                }
            } );
        }
    });
}

