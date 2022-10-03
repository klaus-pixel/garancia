(function($){
    $(document).ready(function(){
        $(document).on('change', '.filter-cat', function(e){
            e.preventDefault();
            var category = $(this).find('option:selected').val();
        

            $.ajax({
                url: wp_ajax.ajax_url,
                data: {action: 'filter', category: category},
                type: 'post',
                success: function(result){
                    $('#produkte').html(result);
                },
                error: function(result){
                    console.warn(result);
                }
            })
        })
    })
})(jQuery);