function myAjaxSelect(select){
    $(document).ready(function(){
        $('body').append('<div class="ajax-select-results" style="display: none;"></div>');
        select.on('input', function(){
            updatePosition();
            $('.ajax-select-results').show();
            if(select.val().length > 0) {
                $.ajax({
                    url: '/api/v1/groups/?q=' + select.val(),
                    dataType: 'json',
                    success: function (data) {
                        if(data[0] === undefined) {
                            showError();
                        } else {
                            showResults(data);
                        }
                    }
                });
            } else {
                $('.ajax-select-results').html('<div class="ajax-select-result">Введите хотя бы 1 символ</div>');
            }
        });
        function showResults(data){
            $('.ajax-select-results').html("");
            for (var i = 0; i < data.length; i++){
                $('.ajax-select-results').append('<div class="ajax-select-result"><a href="'+data[i].url+'">'+data[i].name+'</a></div>')
            }
        }
        function showError(){
            $('.ajax-select-results').html('<div class="ajax-select-result">Ничего не найдено</div>');
        }
        function updatePosition(){
            var offset = select.offset();
            $('.ajax-select-results').css({
                "width": select.outerWidth(),
                "top": offset.top + select.outerHeight(),
                "left": offset.left
            });
        }
    });
}