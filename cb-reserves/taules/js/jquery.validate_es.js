/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


jQuery.extend (jQuery.validator.messages, {
     required: "Este campo es necesario", 
     remote: "Corrige este campo", 
     email: "Introduce una dirección email válida", 
     url: "Introduce una URL válida", 
     date: "Introduce una fecha", 
     dateISO: "Introduce una fecha", 
     number: "Introduce un número", 
     digitos: "Introduce digitos.", 
     CREDITCARD: "Introduce un número de tarjeta de crédito", 
     equalTo: "Introduce el mismo valor", 
     accept: "Introduce una extensión válida", 
     maxlength: jQuery.validator.format ("No se aceptan más de {0} caracteres."), 
     minlength: jQuery.validator.format ("No se aceptan menos se de {0} caracteres."), 
     rangelength: jQuery.validator.format ("Longitud entre {0} y {1} caracteres"), 
     range: jQuery.validator.format ("Valores entre {0} y {1}."), 
     max: jQuery.validator.format ("Máximo {0}."), 
     min: jQuery.validator.format ("Mínimo {0}.") 
}); 
