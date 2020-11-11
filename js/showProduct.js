$(document).ready(function($) {

    $('.item__img').click(function(e){
        var id = $(this).attr('data-id');
        $.ajax({
            url: '/index.php',
            data: {modalId : id},
            type: 'GET',
            dataType: 'json',
            success:function(res){
                if(res){
                        showModal(res);
                }else{
                    alert("Ошибка при получении данных");
                }
            },
            error: function(e){
               
            }
        });
    });
    
    function showModal(res){
        $('.b-modalProduct').addClass("modal-active");
        $('.overlay').addClass('modal-active');
        $('.modalProduct__title').text('Товар: ' + res.goodName);
        $('.modalProduct__description').text('Полное описание: ' + res.goodFullDescr);
        $('.modalProduct__categories').text('Категории: ' + res.categories.join(', '));
        let isCanOrder = res.flag_order == 1 ? "Есть" : "Нет";
        $('.modalProduct__isOrder').text('Возможность заказа со склада: ' + isCanOrder);
        $('.modalProduct__count').text('Кол-во: ' + res.goodAmount);
    }

    function closeModal(){
        if($(".b-modalProduct").hasClass("modal-active")){
            $('.b-modalProduct').removeClass("modal-active");
            $('.overlay').removeClass('modal-active');
        }
    }

    $('.modal__cross').click(function(){
        closeModal();
    });

    $("body").keyup(function(e) {
        if(e.keyCode == 27){
            closeModal();
        }
   });

});


