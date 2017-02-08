function myAjaxSelect(select){
    $(document).ready(function(){
        var item_num = 0;
        $('body').append('<div class="ajax-select-results" style="display: none;"></div>');
        select.on('input', function(){
            updatePosition();
            item_num = 0;
            $('.ajax-select-results').show();
            if(select.val().length > 0) {
                $.ajax({
                    url: '/api/v2/search?q=' + select.val(),
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
        select.on('keyup',function(e){
            if(e.keyCode == 38){
                item_num = (item_num-1 < 1)?1:item_num-1;
                focusSearchItem(item_num);
            } else if(e.keyCode == 40){
                item_num = (item_num+1 > $('.ajax-select-result').length)?$('.ajax-select-result').length:item_num+1;
                focusSearchItem(item_num);
            } else if(e.keyCode == 13){
                if(item_num > 0)
                    window.location.assign($('.ajax-select-result:nth-child('+item_num+') a').attr('href'));
            }
        });
        function focusSearchItem(item_num){
            $('.ajax-select-result a').removeClass('active');
            $('.ajax-select-result:nth-child('+item_num+') a').addClass('active');
        }
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