$(document).ready(function() {
    var table_id = $('#table').attr('id');
    var count = $('#'+table_id+' thead tr').children().length
    var rows_count = $('#'+table_id+' tbody').children().length
    var has_footer = 0
    for( i = 0; i < count; i ++ ){
        var status = $("#"+table_id+" thead tr th:eq("+i+")").attr('class')
        if(status != undefined){
            has_footer = 1
            break
        } 
    }
    for( i = 0; i < count; i ++ ){
        var status = $("#"+table_id+"  thead tr th:eq("+i+")").attr('data-filter-range')
        if(status == 'true'){
            var content = $("#"+table_id+"  thead tr th:eq("+i+")").html();
            $('.select_range').append($('<option>',{ value: i,text : content }))
        }
        
    }
    if(has_footer != 0 && rows_count > 0){
        var new_tfoot = document.createElement( "tfoot")
        var new_tr = document.createElement( "tr")
        $(new_tfoot).insertAfter('thead')
        $('#'+table_id+' tfoot').append(new_tr)
        $('tfoot').addClass('display_on_top')
        var position = $('#'+table_id).attr('data-filter-position')
        if(position=='bottom'){
            $('tfoot').removeClass('display_on_top')
        }
        for( i = 0; i < count; i ++){
            var status = $("#"+table_id+" thead tr th:eq("+i+")").attr('class')
            var new_th = document.createElement( "th")
            $('tfoot tr').append(new_th)
            if(status != undefined)
            $("tfoot tr th:eq("+i+")").addClass(status)
        }
    }
    var count_tr = $('#'+table_id+' tbody').children().length
    $('#table').on('click', 'input[type="radio"]', function(){  
        $(this).parent().parent().parent().removeClass('unread');
    });
    for( i =0 ;i < count_tr; i++){
        var unread_status = $("#table tbody tr:eq("+i+")").attr('class')
        if(unread_status =='unread'){
            var new_span = document.createElement("span")
            $(new_span).addClass('pull-right')
            var ctrl = $('<input/>').attr({ type: 'radio', value:i, title: 'Đánh dấu đã đọc'});
            $(new_span).append(ctrl)
            $("#table tbody tr:eq("+i+") td").first().append(new_span)
        }
        
    }
    //Setup and filter_select
    $('#'+table_id).DataTable({
        // Kích hoạt sắp xếp hoặc ko cho tất cả các cột
        "ordering": true,
         //Kích hoạt thanh tìm kiếm chung hoặc không
        "searching": true,
        //Kích hoạt phân trang hoặc ko, mặc định "pagingType": "simple_numbers"
        "paging": true,
        'order': [0, 'asc'],
        initComplete: function () {
            this.api().columns(".filter_select").every( function () {
                var column = this;
                var select = $('<select class="form-control"><option value=""></option></select>')
                .appendTo( $(column.footer()).empty() )
                .on( 'change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );
                    column.search( val ? '^'+val+'$' : '', true, false ).draw();
                });

                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                });
            });
        }
    });
    $('#'+table_id+' tfoot th ').each( function () {
        if($(this).hasClass('filter_input'))
            $(this).html('<input type="text" class="form-control" placeholder="Tìm kiếm"/> ');
    });
    var table = $('#'+table_id).DataTable();
    table.columns().every( function () {
        var that = this;
        $( 'input', this.footer()).on('keyup change', function () {
            if ( that.search() !== this.value ) {
                that.search( this.value ).draw();
            }
        });
    });
    $('label input').addClass('tags-input')
    $('label select').addClass('tags-input')
    $('#reset_filter').on('click', function(){
        table.search('').columns().search('').draw();
        $('.form-control').val('');
    });
});