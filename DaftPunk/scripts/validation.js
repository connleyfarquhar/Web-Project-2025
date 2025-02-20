function validateInput(event, fieldType) {
  let regex;
  switch (fieldType) {
    case 'name':
      regex = /^[a-zA-Z\s]*$/;
      break;
    case 'address':
      regex = /^[a-zA-Z0-9,.-\s]*$/;
      break;
    case 'card-number':
      event.target.value = event.target.value.replace(/\s+/g, ''); 
      regex = /^[0-9]{16}$/; 
      break;
    case 'cvc':
      regex = /^[0-9]{3}$/; 
      break;
    case 'expiry-date':
      regex = /^[0-9]*$/;
      break;
    default:
      return;
  }

  if (event.target.value.trim() === "") {
    event.target.setCustomValidity("Input cannot be empty or only spaces.");
  } else if (!regex.test(event.target.value)) {
    event.target.setCustomValidity("Invalid input. Please check the format.");
  } else {
    event.target.setCustomValidity("");
  }
}
