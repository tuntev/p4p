/**
 * Created by tunte on 11/5/14.
 */
$(document).ready(function(){
    $('form').on('submit', function(e){
        $('button:submit').attr("disabled", true);
    });

    $('.navbar-nav').find('.active').removeClass('active');
    switch(window.location.pathname){

        // add the permalinks to the nav
        case '/Prog4Projects/public/prog4':
            $('#coursesNav').addClass('active');
            break;
        case '/Prog4Projects/public/users':
        case '/Prog4Projects/public/user/createNew':
            $('#adminNav').addClass('active');
            break;
    };

    $('.jsDelete').click(function(e){
        e.stopPropagation();

        var r = confirm("Are you sure");
        if (r == false){
            e.preventDefault();
            return;
        }
    });

});