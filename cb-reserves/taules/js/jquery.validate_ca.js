/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


jQuery.extend(jQuery.validator.messages, {
    required: "Aquest camp és necessari",
    remote: "Corregeix aquest camp",
    email: "Introdueix una adreça email vàlida",
    url: "Introdueix una URL vàlida",
    date: "Introdueix una data",
    dateISO: "Introdueix una data",
    number: "Introdueix un número",
    digits: "Introdueix digits.",
    creditcard: "Introdueix un número de targeta de crèdit",
    equalTo: "Introdueix el mateix valor ",
    accept: "Introdueix una extensió vàlida",
    maxlength: jQuery.validator.format("No s'ecceptes més de {0} caracters."),
    minlength: jQuery.validator.format("No s'ecceptes menyss de {0} caracters."),
    rangelength: jQuery.validator.format("Longitud entre {0} i {1} caracters"),
    range: jQuery.validator.format("Valors entre{0} i {1}."),
    max: jQuery.validator.format("Màxim {0}."),
    min: jQuery.validator.format("Mínim {0}.")
});