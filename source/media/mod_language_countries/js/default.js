jQuery(document).ready(function() {
    jQuery('#languagecountries a.btn').click(function() {
        Cookies.set('languagecountries', 1);
    });

    jQuery('#languagecountries-button a.btn').click(function() {
        showLanguageCountriesModal();
    });
});

var countdown;

function showLanguageCountriesModal()
{
    jQuery("#languagecountries").modal('show').on('hide', function () {
        hideLanguageCountriesModal();
    });

    if (languageCountriesDisableAutoRedirect == 1) {
        return;
    }

    countdown = setInterval(function () {
        if (--languageCountriesRedirectTime) {
            jQuery('div.redirect span.countdown-timer').html(languageCountriesRedirectTime);
        } else {
            clearInterval(countdown);
            Cookies.set('languagecountries', 1);
            window.location.href = languageCountriesMatchedLanguageLink;
        }
    }, 1000);
}

function hideLanguageCountriesModal()
{
    clearInterval(countdown);
}