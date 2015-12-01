$(function () {
    //导航切换  
    $(".menuson").on('click',".header",function(){
        var $parent = $(this).parent();
        $(".menuson>li.active").not($parent).removeClass("active open").find('.sub-menus').hide();
        $parent.addClass("active");
        if (!!$(this).next('.sub-menus').size()) {
            if ($parent.hasClass("open")) {
                $parent.removeClass("open").find('.sub-menus').hide();
            } else {
                $parent.addClass("open").find('.sub-menus').show();
            }
        } 
    });
    
    $(document).on('click',".sub-menus li",function(){
        $(".sub-menus li.active").removeClass("active")
        $(this).addClass("active");
    });
    
    $(document).on('click',".title",function(){
        var $ul = $(this).next('ul');
        $('dd').find('.menuson').slideUp();
        if ($ul.is(':visible')) {
            $(this).next('.menuson').slideUp();
        } else {
            $(this).next('.menuson').slideDown();
        }
    });
})