var config = {
  map: {
      '*': {
          'custom-email-validation': 'CustomContect_CustomForm/js/custom-email-validation'
      }
  },
  shim: {
      'custom-email-validation': {
          deps: ['jquery', 'mage/validation']
      }
  }
};
