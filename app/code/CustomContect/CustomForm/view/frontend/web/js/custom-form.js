require(['jquery', 'jquery/ui'], function($) {
    $(document).ready(function() {
        $('#registration-form').submit(function() {
            resetErrorMessages();

            var email = getValueById('email');
            var contactNumber = getValueById('contact_number');
            var emergencyContact = getValueById('emergency_contact');
            var dateOfBirth = getValueById('date_of_birth');
            var name = getValueById('name');
            var marital_status = getValueById('marital_status');
            var genderSelected = $('input[name="gender"]:checked').length > 0;

            var hasErrors = false;

            // Check for empty fields and display error
            hasErrors = checkEmpty(email, '.email_error', 'Email is required.') || hasErrors;
            hasErrors = checkEmpty(contactNumber, '.contect_number_error', 'Contact Number is required.') || hasErrors;
            hasErrors = checkEmpty(emergencyContact, '.emergency_contact_error','Emergency Contact is required.') || hasErrors;
            hasErrors = checkEmpty(dateOfBirth, '.date_of_birth_error','Date of Birth is required.') || hasErrors;
            hasErrors = checkEmpty(name, '.name_error', 'Name is required.') || hasErrors;
            hasErrors = checkEmpty(marital_status, '.marital_status_error','marital_status is required.') || hasErrors;
           
            if (!genderSelected) {
                showError('.gender_error', 'Please select a gender.');
                return false;
            }

            // Check if values exist in arrays only if there are values in the fields
            if (!hasErrors) {
                hasErrors = checkvalueword(name, '.name_error','Name should be between 5 and 15 characters long, and the first two characters should be alphabets.') || hasErrors;
                hasErrors = checktotaldigit(contactNumber, '.contect_number_error','Contact Number should have exactly 10 digits') || hasErrors;
                hasErrors = checktotaldigit(emergencyContact, '.emergency_contact_error','Contact Number should have exactly 10 digits') || hasErrors;

                if (!hasErrors) {
                    hasErrors = checkIfValueExists(email, emailArray, '.email_error','Email already exists.') || hasErrors;
                    hasErrors = checkIfValueExists(contactNumber, contactNumberArray,'.contect_number_error', 'Contact Number already exists.') || hasErrors;
                    hasErrors = checkIfValueExists(emergencyContact, emergencyContactArray,'.emergency_contact_error', 'Emergency Contact already exists.') || hasErrors;
                }
            }

            return !hasErrors;
        });

        function resetErrorMessages() {
            ['.email_error', '.contect_number_error', '.emergency_contact_error',
                '.date_of_birth_error', '.name_error', '.marital_status_error', '.gender_error' ]
            .forEach(selector => {
                $(selector + ' .error').text('');
            });
        }

        function getValueById(id) {
            return $('#' + id).val();
        }

        function checkEmpty(value, errorSelector, errorMessage) {
            if (value.trim() === '') {
                showError(errorSelector, errorMessage);
                return true;
            }
            return false;
        }

        function checktotaldigit(value, errorSelector, errorMessage) {
            if (value.length !== 10) {
                showError(errorSelector, errorMessage);
                return true;
            }
            return false;
        }
        function checkvalueword(value, errorSelector, errorMessage){
            if (value.length < 5 || value.length > 15) {
                showError(errorSelector, errorMessage);
                return true;
            }
            var firstTwoCharacters = value.substr(0, 2);
             if (!/^[a-zA-Z]+$/.test(firstTwoCharacters)) {
                showError(errorSelector, errorMessage);
                return true;
            }
            return false;
        }

        function checkIfValueExists(value, array, errorSelector, errorMessage) {
            if (array.includes(value)) {
                showError(errorSelector, errorMessage);
                return true;
            }
            return false;
        }

        function showError(errorSelector, errorMessage) {
            $(errorSelector + ' .error').text(errorMessage);
            $(errorSelector)[0].scrollIntoView({
                behavior: 'smooth'
            });
        }

        // date of birth
        var today = new Date().toISOString().split('T')[0];
        $('#date_of_birth').attr('max', today);
    });
});
