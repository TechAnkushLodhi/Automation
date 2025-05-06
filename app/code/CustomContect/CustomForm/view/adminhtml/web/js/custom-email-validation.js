require(
    [
        'Magento_Ui/js/lib/validation/validator',
        'jquery',
        'mage/translate'
], function(validator, $){
  $(document).ready(function () {


                // Add click event listener for the Save button
                $('#save , #save_and_continue').on('click', function () {
                            customduplicateValidation('custom-check-validation', 'A customer with the same email address already exists in an associated website.','email');
                            customduplicateValidation('custom-contact_number-validation', 'A customer with the same contact_number already exists in an associated website.','contact_number');
                            customduplicateValidation('custom-emergency-contact-validation','A customer with the same emergency contact already exists in an associated website.','emergency_contact');
                });

                  function customduplicateValidation(fieldType, errorMessage,fieldname) {
                    validator.addRule(
                        fieldType,
                        function (value) {
                            if(value){
                            var result = false;
                            var id=urlcheck();
                            var sendData = {
                                fieldvalue: value,
                                id:id,
                                fieldname:fieldname
                            };
                            // Synchronous AJAX request
                            $.ajax({
                                url: '/customform/index/emailcheck', // Replace with your controller URL
                                type: 'POST',
                                dataType: 'json',
                                data: sendData,
                                async: false,  // Make the request synchronous
                                success: function(response) {
                                    if (response.status === 'error') {
                                       result = false;
                                        var message = $('#messages');
                                        if(message){
                                             message.remove();
                                        }
                                        // Show alert with the specified message
                                            var messageHTML = '<div id="messages"><div class="messages"><div class="message message-error error"><div data-ui-id="messages-message-error">' + $.mage.__(errorMessage) + '</div></div></div></div>';
                                            var messageContainer = $('#anchor-content .page-main-actions').after(messageHTML);
                                              // Scroller ko message container tak animate karein
                                            $('html, body').animate({
                                                scrollTop: messageContainer.offset().top
                                            }, 500);
                                    } else {
                                        var message = $('#messages');
                                        if(message){
                                             message.remove();
                                        }

                                       
                                        result = true;
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error(xhr.responseText); // Log errors to console
                                }
                            });

                            return result;
                        }
                        },
                        $.mage.__(errorMessage)
                    );
               }

});

function urlcheck() {
    var currentUrl = window.location.href;

    if (currentUrl.indexOf('/edit') !== -1) {
        var match = currentUrl.match(/\/edit\/id\/(\d+)/);
        if (match && match[1]) {
            var idParameter = match[1];
            return idParameter;
        }
    } else if (currentUrl.indexOf('/new') !== -1) {
        var idParameter = 'new';
        return idParameter;
    }
}


validator.addRule(
    'custom-name-validation',
    function (value) {
        // Check if the length is between 5 and 15 characters
        if (value.length < 5 || value.length > 15) {
            return false;
        }

        // Check if the first two characters are alphabets
        var firstTwoCharacters = value.substr(0, 2);
        if (!/^[a-zA-Z]+$/.test(firstTwoCharacters)) {
            return false;
        }

        // Additional validation logic (if any) can be added here

        return true; // If all conditions are met
    },
    $.mage.__('Name should be between 5 and 15 characters long, and the first two characters should be alphabets.')
);

var today = new Date().toISOString().split('T')[0];
$('[name="date_of_birth"]').attr('max', today);


});