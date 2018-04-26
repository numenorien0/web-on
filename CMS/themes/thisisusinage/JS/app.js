$(function(){
    $(document).scroll(function(){
        var backgroundPos = $(".bannerImage").css('background-position').split(" ");
        //now contains an array like ["0%", "50px"]
        var percent = ($(this).scrollTop()*1.2)/$(this).height()*100;
        var height = $(".bannerImage").height();
        var xPos = backgroundPos[0],
            yPos = parseFloat(backgroundPos[1]);
        
        console.log((yPos+percent));
        
        var enPourcent = 50-yPos/$(this).height()*100;
        console.log((enPourcent+percent));
        $(".bannerImage").css({"background-position": xPos+" "+(enPourcent-percent)+"%"});    
    });
    
    //$("#menuItem").hide();
    $("#responsiveMenu").click(function(){
        $("#menuItem").toggle();
    });
    
    function circle()
    {
        $('.circle').each(function(){
            var width = $(this).width();
            $(this).height(width);
        })
    
    }
    circle();
    
    $(window).resize(function(){
        circle();
    })
})