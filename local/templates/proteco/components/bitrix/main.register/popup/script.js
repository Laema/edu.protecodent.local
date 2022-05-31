$(document).ready(function() {
    var item = document.getElementById('personal-phone-popup');
    const maskOptions = {
        mask: '+7(000)000-00-00',
        lazy: false,
        overwrite: true,
        prepare: value => value,
    };
    const mask = IMask(item, maskOptions);
    $('#personal-country-popup').on('change', function(event) {
        let newMask = $('#personal-country-popup').val();
        mask.updateOptions({
          mask: newMask,
        });
    });
});
