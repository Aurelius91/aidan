$(document).ready(function(){
    detectTouch();
});

function detectTouch() {
    var supportsTouch = 'ontouchstart' in window || navigator.msMaxTouchPoints;
    if(supportsTouch == undefined) {
    }
    else if (supportsTouch == true){
        $('.nav-menu-bar .navbar-main-menu .dropdown .dropdown-toggle').on('click', function(event) {
            if($(this).hasClass('touch-active')) {
                event.preventDefault();
                $(this).removeClass('touch-active');
            }
            else {
                event.preventDefault();
                $('.nav-menu-bar .navbar-main-menu .dropdown .dropdown-toggle').removeClass('touch-active');
                $(this).toggleClass('touch-active');
            }
        });

        $(document).on('click', function(event) {
            if (!$(event.target).closest('.nav-menu-bar .navbar-main-menu .dropdown').length) {
                $('.nav-menu-bar .navbar-main-menu .dropdown .dropdown-toggle').removeClass('touch-active');
            }
        });
    }
}

$('#forgot-password-toggle').on('click', function () {
	$('#sign-in-modal').modal('hide');
	$('#sign-in-modal').on('hidden.bs.modal', function () {
		$('#forgot-password-modal').modal('show');
		$(this).off('hidden.bs.modal');
	})
});

$('#create-an-account-button').on('click', function () {
	$('#sign-in-modal').modal('hide');
	$('#sign-in-modal').on('hidden.bs.modal', function () {
		$('#sign-up-modal').modal('show');
		$(this).off('hidden.bs.modal');
	})
});
