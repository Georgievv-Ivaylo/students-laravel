
let errors = false;
let eventListeners = {};

let formRules = {
    'name': [ {'required': 'The Your Name is required field!'} ],
    'work': [ {'required': 'The Work Title is required field!'} ],
    'exam': [ {'required': 'Must be selected Exam for graduetion!'} ],
    'degree': [ {'required': 'Must be selected Degree for graduetion!'} ],
    'professor': [ {'required': 'Must be selected Professor for exam!'} ]
};

ajaxGet('/ajax/graduation/form');

function validation(form){
  errors = false;
  removeError();
  
  const formInputFields = document.forms[form].getElementsByTagName('input');
  const formSelectFields = document.forms[form].getElementsByTagName('select');
  validationChecker(formInputFields);
  validationChecker(formSelectFields);
  
  if (!errors) document.forms[form].submit();
}

function validationChecker(formFields) {
  for (let fieldK in formFields) {
    const field = formFields[fieldK];
    const checkField = field['name'];
    if ( formRules[checkField] ) {
      const checkFieldValue = field.value.trim();
      formRules[checkField].map( (validationRule) => {
        if (validationRule['required']) {
          if ( !checkFieldValue ) return printError( field, validationRule['required'] );
        }
        if (formRules['options'] &&
            formRules['options'][checkField] &&
            formRules['options'][checkField]['values']) {
          if ( !formRules['options'][checkField]['values'][checkFieldValue] ) printError( field, 'Selected option is invalid!' );
        }
      } );
    }
  };
}

function printError(field, message) {
  errors = true;
  let errorMsg = document.createElement('div');
  errorMsg.classList = 'alert alert-danger';
  errorMsg.innerHTML = message;
  field.parentElement.appendChild(errorMsg);
  if (!eventListeners[field['name']]) {
    eventListeners[field['name']] = field['name'];
    field.addEventListener("change", function(e) {
      removeError(e.target)
    }, true);
  }
}

function removeError(field) {
  if (field) {
    const toRemove = field.parentNode.querySelectorAll('.alert.alert-danger')[0];
    if (!toRemove) return;
    return toRemove.parentNode.removeChild(toRemove);
  }
  const toRemoveArr = document.querySelectorAll('.alert.alert-danger');
  if (!toRemoveArr[0]) return;
  for (const toRemoveK in toRemoveArr) {
    const toRemove = toRemoveArr[toRemoveK];
    if (toRemove.parentNode) toRemove.parentNode.removeChild(toRemove);
  }
}

function ajaxGet(urlData) {
  const xmlhttp = new XMLHttpRequest();
  let ajaxData = {};

  xmlhttp.onreadystatechange = function() {
      if (xmlhttp.readyState == XMLHttpRequest.DONE) {   // XMLHttpRequest.DONE == 4
         if (xmlhttp.status == 200) {
           handelAjaxData(JSON.parse(xmlhttp.responseText));
         }
         else if (xmlhttp.status == 400) {
           console.log('There was an error 400!');
         }
         else {
           console.log('Something else other than 200 was returned!');
         }
      }
  };

  xmlhttp.open("GET", urlData, true);
  xmlhttp.send();
  
  return ajaxData;
}

function handelAjaxData(ajaxData) {

  if (ajaxData['formRules']) {
    formRules['options'] = ajaxData['formRules'];
  }
}
