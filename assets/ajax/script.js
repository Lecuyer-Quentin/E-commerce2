
/**
 * This script handles the AJAX form submissions for the login, register, product add, user add, and special add forms.
 * It sends the form data to the server using AJAX and updates the UI based on the response.
 *
 * @file This file contains the AJAX form submission logic for multiple forms.
 * @summary Handles AJAX form submissions for login, register, product add, user add, and special add forms.
 * @description This script listens for form submission events and sends the form data to the server using AJAX.
 * It expects the server to respond with JSON data containing a status and message.
 * If the status is 'success', it updates the UI with a success message and redirects the user to a specified page.
 * If the status is 'error', it updates the UI with an error message.
 *
 * @see {@link https://api.jquery.com/jQuery.ajax/|jQuery.ajax}
 * @see {@link https://developer.mozilla.org/en-US/docs/Web/API/FormData|FormData}
 * @see {@link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/JSON|JSON}
 */

// Login form //
const loginForm = document.getElementById('login_form');
const loginAlertMsg = document.getElementById('alert_message_login_form');
loginForm.addEventListener('submit', function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: 'json',
        success: function(data) {
            if (data.status == 'success') {
                $(loginAlertMsg).removeClass('d-none');
                $(loginAlertMsg).addClass('alert-success');
                $(loginAlertMsg).html(data.message);
                setTimeout(function() {
                    $(loginAlertMsg).addClass('d-none');
                    $(loginAlertMsg).removeClass('alert-success');
                    window.location.href = data.redirect;
                }, 3000);
            }
            if (data.status == 'error'){
                $(loginAlertMsg).removeClass('d-none');
                $(loginAlertMsg).addClass('alert-danger');
                $(loginAlertMsg).html(data.message);
                setTimeout(function() {
                    $(loginAlertMsg).addClass('d-none');
                    $(loginAlertMsg).removeClass('alert-danger');
                }, 3000);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown, jqXHR);
            $(loginAlertMsg).removeClass('d-none');
            $(loginAlertMsg).addClass('alert-danger');
            $(loginAlertMsg).html('Error: ' + textStatus);
            setTimeout(function() {
                $(loginAlertMsg).addClass('d-none');
                $(loginAlertMsg).removeClass('alert-danger');
                $(loginAlertMsg).html('');
            }, 3000);
        }
    });
});
// ********** //

// Register form //
const registerForm = document.getElementById('register_form');
const registerAlertMsg = document.getElementById('alert_message_register_form');
registerForm.addEventListener('submit', function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: 'json',
        success: function(data) {
            if (data.status == 'success') {
                $(registerAlertMsg).removeClass('d-none');
                $(registerAlertMsg).addClass('alert-success');
                $(registerAlertMsg).html(data.message);
                setTimeout(function() {
                    $(registerAlertMsg).addClass('d-none');
                    $(registerAlertMsg).removeClass('alert-success');
                    window.location.href = data.redirect;
                }, 3000);
            }
            if (data.status == 'error'){
                $(registerAlertMsg).removeClass('d-none');
                $(registerAlertMsg).addClass('alert-danger');
                $(registerAlertMsg).html(data.message);
                setTimeout(function() {
                    $(registerAlertMsg).addClass('d-none');
                    $(registerAlertMsg).removeClass('alert-danger');
                    $(registerAlertMsg).html('');
                }, 3000);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            //console.log(textStatus, errorThrown, jqXHR);
            $(registerAlertMsg).removeClass('d-none');
            $(registerAlertMsg).addClass('alert-danger');
            //! Error message is not displayed on the page
            //! error parse error
            $(registerAlertMsg).html('Error: ');

            setTimeout(function() {
                $(registerAlertMsg).addClass('d-none');
                $(registerAlertMsg).removeClass('alert-danger');
                $(registerAlertMsg).html('');
            }, 3000);
        }
    });
});
// ********** //

// Product add form //
const productAddForm = document.getElementById('product_add_form');
const productAddAlertMsg = document.getElementById('alert_message_product_add_form');
productAddForm.addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(data) {
            if (data.status == 'success') {
                $(productAddAlertMsg).removeClass('d-none');
                $(productAddAlertMsg).addClass('alert-success');
                $(productAddAlertMsg).html(data.message);
                setTimeout(function() {
                    $(productAddAlertMsg).addClass('d-none');
                    $(productAddAlertMsg).removeClass('alert-success');
                    window.location.href = data.redirect;
                }, 3000);
            }
            if (data.status == 'error'){
                $(productAddAlertMsg).removeClass('d-none');
                $(productAddAlertMsg).addClass('alert-danger');
                $(productAddAlertMsg).html(data.message);
                setTimeout(function() {
                    $(productAddAlertMsg).addClass('d-none');
                    $(productAddAlertMsg).removeClass('alert-danger');
                    $(productAddAlertMsg).html('');
                }, 3000);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown, jqXHR);
            $(productAddAlertMsg).removeClass('d-none');
            $(productAddAlertMsg).addClass('alert-danger');
            $(productAddAlertMsg).html('Error: ' + textStatus);
            setTimeout(function() {
                $(productAddAlertMsg).addClass('d-none');
                $(productAddAlertMsg).removeClass('alert-danger');
                $(productAddAlertMsg).html('');
            }, 3000);
        }
    });
}
);
// ********** //

// User add form //
const userAddForm = document.getElementById('user_add_form');
const userAddAlertMsg = document.getElementById('alert_message_user_add_form');
userAddForm.addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(data) {
            if (data.status == 'success') {
                $(userAddAlertMsg).removeClass('d-none');
                $(userAddAlertMsg).addClass('alert-success');
                $(userAddAlertMsg).html(data.message);
                setTimeout(function() {
                    $(userAddAlertMsg).addClass('d-none');
                    $(userAddAlertMsg).removeClass('alert-success');
                    window.location.href = data.redirect;
                }, 3000);
            }
            if (data.status == 'error'){
                $(userAddAlertMsg).removeClass('d-none');
                $(userAddAlertMsg).addClass('alert-danger');
                $(userAddAlertMsg).html(data.message);
                setTimeout(function() {
                    $(userAddAlertMsg).addClass('d-none');
                    $(userAddAlertMsg).removeClass('alert-danger');
                    $(userAddAlertMsg).html('');
                }, 3000);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown, jqXHR);
            $(userAddAlertMsg).removeClass('d-none');
            $(userAddAlertMsg).addClass('alert-danger');
            $(userAddAlertMsg).html('Error: ' + textStatus);
            setTimeout(function() {
                $(userAddAlertMsg).addClass('d-none');
                $(userAddAlertMsg).removeClass('alert-danger');
                $(userAddAlertMsg).html('');
            }, 3000);
        }
    });
}
);
// ********** //

// Special add form //
const specialAddForm = document.getElementById('special_add_form');
const specialAddAlertMsg = document.getElementById('alert_message_special_add_form');
specialAddForm.addEventListener('submit', function(e) {
    e.preventDefault();

    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: 'json',
        success: function(data) {
            if (data.status == 'success') {
                $(specialAddAlertMsg).removeClass('d-none');
                $(specialAddAlertMsg).addClass('alert-success');
                $(specialAddAlertMsg).html(data.message);
                setTimeout(function() {
                    $(specialAddAlertMsg).addClass('d-none');
                    $(specialAddAlertMsg).removeClass('alert-success');
                    window.location.href = data.redirect;
                }, 3000);
            }
            if (data.status == 'error'){
                $(specialAddAlertMsg).removeClass('d-none');
                $(specialAddAlertMsg).addClass('alert-danger');
                $(specialAddAlertMsg).html(data.message);
                setTimeout(function() {
                    $(specialAddAlertMsg).addClass('d-none');
                    $(specialAddAlertMsg).removeClass('alert-danger');
                    $(specialAddAlertMsg).html('');
                }, 3000);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown, jqXHR);
            $(specialAddAlertMsg).removeClass('d-none');
            $(specialAddAlertMsg).addClass('alert-danger');
            $(specialAddAlertMsg).html('Error: ' + textStatus);
            setTimeout(function() {
                $(specialAddAlertMsg).addClass('d-none');
                $(specialAddAlertMsg).removeClass('alert-danger');
                $(specialAddAlertMsg).html('');
            }, 3000);
        }
    });
}
);
// Special edit form //
const specialEditForms = document.querySelectorAll('#special_edit_form');
const specialEditAlertMsgs = document.querySelectorAll('#alert_message_special_edit_form');
specialEditForms.forEach(function(form) {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                if (data.status == 'success') {
                    specialEditAlertMsgs.forEach(function(alertMsg) {
                        alertMsg.classList.remove('d-none');
                        alertMsg.classList.add('alert-success');
                        alertMsg.innerHTML = data.message;
                        setTimeout(function() {
                            $(alertMsg).addClass('d-none');
                            $(alertMsg).removeClass('alert-success');
                            window.location.href = data.redirect;
                        }, 3000);
                    });
                }
                if (data.status == 'error'){
                    specialEditAlertMsgs.forEach(function(alertMsg) {
                        alertMsg.classList.remove('d-none');
                        alertMsg.classList.add('alert-danger');
                        alertMsg.innerHTML = data.message;
                        setTimeout(function() {
                            alertMsg.classList.add('d-none');
                            alertMsg.classList.remove('alert-danger');
                            alertMsg.innerHTML = '';
                        }, 3000);
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown, jqXHR);
                specialEditAlertMsgs.forEach(function(alertMsg) {
                    alertMsg.classList.remove('d-none');
                    alertMsg.classList.add('alert-danger');
                    alertMsg.innerHTML = 'Error: ' + textStatus;
                    setTimeout(function() {
                        alertMsg.classList.add('d-none');
                        alertMsg.classList.remove('alert-danger');
                        alertMsg.innerHTML = '';
                    }, 3000);
                });
            }
        });
    })
});
// Special delete form //
const specialDeleteForms = document.querySelectorAll('#special_delete_form');
const specialDeleteAlertMsgs = document.querySelectorAll('#alert_message_special_delete_form');
specialDeleteForms.forEach(function(form) {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                if (data.status == 'success') {
                    specialDeleteAlertMsgs.forEach(function(alertMsg) {
                        alertMsg.classList.remove('d-none');
                        alertMsg.classList.add('alert-success');
                        alertMsg.innerHTML = data.message;
                        setTimeout(function() {
                            $(alertMsg).addClass('d-none');
                            $(alertMsg).removeClass('alert-success');
                            window.location.href = data.redirect;
                        }, 3000);
                    });
                }
                if (data.status == 'error'){
                    specialDeleteAlertMsgs.forEach(function(alertMsg) {
                        alertMsg.classList.remove('d-none');
                        alertMsg.classList.add('alert-danger');
                        alertMsg.innerHTML = data.message;
                        setTimeout(function() {
                            alertMsg.classList.add('d-none');
                            alertMsg.classList.remove('alert-danger');
                            alertMsg.innerHTML = '';
                        }, 3000);
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown, jqXHR);
                specialDeleteAlertMsgs.forEach(function(alertMsg) {
                    alertMsg.classList.remove('d-none');
                    alertMsg.classList.add('alert-danger');
                    alertMsg.innerHTML = 'Error: ' + textStatus;
                    setTimeout(function() {
                        alertMsg.classList.add('d-none');
                        alertMsg.classList.remove('alert-danger');
                        alertMsg.innerHTML = '';
                    }, 3000);
                });
            }
        });
    });
});
// ********** //

// Category add form //
const categoryAddForm = document.getElementById('categorie_add_form');
const categoryAddAlertMsg = document.getElementById('alert_message_categorie_add_form');
categoryAddForm.addEventListener('submit', function(e) {
    e.preventDefault();

    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: 'json',
        success: function(data) {
            if (data.status == 'success') {
                $(categoryAddAlertMsg).removeClass('d-none');
                $(categoryAddAlertMsg).addClass('alert-success');
                $(categoryAddAlertMsg).html(data.message);
                setTimeout(function() {
                    $(categoryAddAlertMsg).addClass('d-none');
                    $(categoryAddAlertMsg).removeClass('alert-success');
                    window.location.href = data.redirect;
                }, 3000);
            }
            if (data.status == 'error'){
                $(categoryAddAlertMsg).removeClass('d-none');
                $(categoryAddAlertMsg).addClass('alert-danger');
                $(categoryAddAlertMsg).html(data.message);
                setTimeout(function() {
                    $(categoryAddAlertMsg).addClass('d-none');
                    $(categoryAddAlertMsg).removeClass('alert-danger');
                    $(categoryAddAlertMsg).html('');
                }, 3000);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown, jqXHR);
            $(categoryAddAlertMsg).removeClass('d-none');
            $(categoryAddAlertMsg).addClass('alert-danger');
            $(categoryAddAlertMsg).html('Error: ' + textStatus);
            setTimeout(function() {
                $(categoryAddAlertMsg).addClass('d-none');
                $(categoryAddAlertMsg).removeClass('alert-danger');
                $(categoryAddAlertMsg).html('');
            }, 3000);
        }
    });
});
// Category edit form //
const categoryEditForms = document.querySelectorAll('#categorie_edit_form');
const categoryEditAlertMsgs = document.querySelectorAll('#alert_message_categorie_edit_form');
categoryEditForms.forEach(function(form) {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                if (data.status == 'success') {
                    categoryEditAlertMsgs.forEach(function(alertMsg) {
                        alertMsg.classList.remove('d-none');
                        alertMsg.classList.add('alert-success');
                        alertMsg.innerHTML = data.message;
                        setTimeout(function() {
                            $(alertMsg).addClass('d-none');
                            $(alertMsg).removeClass('alert-success');
                            window.location.href = data.redirect;
                        }, 3000);
                    });
                }
                if (data.status == 'error'){
                    categoryEditAlertMsgs.forEach(function(alertMsg) {
                        alertMsg.classList.remove('d-none');
                        alertMsg.classList.add('alert-danger');
                        alertMsg.innerHTML = data.message;
                        setTimeout(function() {
                            alertMsg.classList.add('d-none');
                            alertMsg.classList.remove('alert-danger');
                            alertMsg.innerHTML = '';
                        }, 3000);
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown, jqXHR);
                categoryEditAlertMsgs.forEach(function(alertMsg) {
                    alertMsg.classList.remove('d-none');
                    alertMsg.classList.add('alert-danger');
                    alertMsg.innerHTML = 'Error: ' + textStatus;
                    setTimeout(function() {
                        alertMsg.classList.add('d-none');
                        alertMsg.classList.remove('alert-danger');
                        alertMsg.innerHTML = '';
                    }, 3000);
                });
            }
        });
    })
});

// Category delete form //
const categoryDeleteForms = document.querySelectorAll('#categorie_delete_form');
const categoryDeleteAlertMsgs = document.querySelectorAll('#alert_message_categorie_delete_form');
categoryDeleteForms.forEach(function(form) {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                if (data.status == 'success') {
                    categoryDeleteAlertMsgs.forEach(function(alertMsg) {
                        alertMsg.classList.remove('d-none');
                        alertMsg.classList.add('alert-success');
                        alertMsg.innerHTML = data.message;
                        setTimeout(function() {
                            $(alertMsg).addClass('d-none');
                            $(alertMsg).removeClass('alert-success');
                            window.location.href = data.redirect;
                        }, 3000);
                    });
                }
                if (data.status == 'error'){
                    categoryDeleteAlertMsgs.forEach(function(alertMsg) {
                        alertMsg.classList.remove('d-none');
                        alertMsg.classList.add('alert-danger');
                        alertMsg.innerHTML = data.message;
                        setTimeout(function() {
                            alertMsg.classList.add('d-none');
                            alertMsg.classList.remove('alert-danger');
                            alertMsg.innerHTML = '';
                        }, 3000);
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown, jqXHR);
                categoryDeleteAlertMsgs.forEach(function(alertMsg) {
                    alertMsg.classList.remove('d-none');
                    alertMsg.classList.add('alert-danger');
                    alertMsg.innerHTML = 'Error: ' + textStatus;
                    setTimeout(function() {
                        alertMsg.classList.add('d-none');
                        alertMsg.classList.remove('alert-danger');
                        alertMsg.innerHTML = '';
                    }, 3000);
                });
            }
        });
    });
});
// ********** //

// Role add form //
const roleAddForm = document.getElementById('role_add_form');
const roleAddAlertMsg = document.getElementById('alert_message_role_add_form');
roleAddForm.addEventListener('submit', function(e) {
    e.preventDefault();

    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: 'json',
        success: function(data) {
            if (data.status == 'success') {
                $(roleAddAlertMsg).removeClass('d-none');
                $(roleAddAlertMsg).addClass('alert-success');
                $(roleAddAlertMsg).html(data.message);
                setTimeout(function() {
                    $(roleAddAlertMsg).addClass('d-none');
                    $(roleAddAlertMsg).removeClass('alert-success');
                    window.location.href = data.redirect;
                }, 3000);
            }
            if (data.status == 'error'){
                $(roleAddAlertMsg).removeClass('d-none');
                $(roleAddAlertMsg).addClass('alert-danger');
                $(roleAddAlertMsg).html(data.message);
                setTimeout(function() {
                    $(roleAddAlertMsg).addClass('d-none');
                    $(roleAddAlertMsg).removeClass('alert-danger');
                    $(roleAddAlertMsg).html('');
                }, 3000);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown, jqXHR);
            $(roleAddAlertMsg).removeClass('d-none');
            $(roleAddAlertMsg).addClass('alert-danger');
            $(roleAddAlertMsg).html('Error: ' + textStatus);
            setTimeout(function() {
                $(roleAddAlertMsg).addClass('d-none');
                $(roleAddAlertMsg).removeClass('alert-danger');
                $(roleAddAlertMsg).html('');
            }, 3000);
        }
    });
});

// Role edit form //
const roleEditForms = document.querySelectorAll('#role_edit_form');
const roleEditAlertMsgs = document.querySelectorAll('#alert_message_role_edit_form');
roleEditForms.forEach(function(form) {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                if (data.status == 'success') {
                    roleEditAlertMsgs.forEach(function(alertMsg) {
                        alertMsg.classList.remove('d-none');
                        alertMsg.classList.add('alert-success');
                        alertMsg.innerHTML = data.message;
                        setTimeout(function() {
                            $(alertMsg).addClass('d-none');
                            $(alertMsg).removeClass('alert-success');
                            window.location.href = data.redirect;
                        }, 3000);
                    });
                }
                if (data.status == 'error'){
                    roleEditAlertMsgs.forEach(function(alertMsg) {
                        alertMsg.classList.remove('d-none');
                        alertMsg.classList.add('alert-danger');
                        alertMsg.innerHTML = data.message;
                        setTimeout(function() {
                            alertMsg.classList.add('d-none');
                            alertMsg.classList.remove('alert-danger');
                            alertMsg.innerHTML = '';
                        }, 3000);
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown, jqXHR);
                roleEditAlertMsgs.forEach(function(alertMsg) {
                    alertMsg.classList.remove('d-none');
                    alertMsg.classList.add('alert-danger');
                    alertMsg.innerHTML = 'Error: ' + textStatus;
                    setTimeout(function() {
                        alertMsg.classList.add('d-none');
                        alertMsg.classList.remove('alert-danger');
                        alertMsg.innerHTML = '';
                    }, 3000);
                });
            }
        });
    })
});

// Role delete form //
const roleDeleteForms = document.querySelectorAll('#role_delete_form');
const roleDeleteAlertMsgs = document.querySelectorAll('#alert_message_role_delete_form');
roleDeleteForms.forEach(function(form) {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                if (data.status == 'success') {
                    roleDeleteAlertMsgs.forEach(function(alertMsg) {
                        alertMsg.classList.remove('d-none');
                        alertMsg.classList.add('alert-success');
                        alertMsg.innerHTML = data.message;
                        setTimeout(function() {
                            $(alertMsg).addClass('d-none');
                            $(alertMsg).removeClass('alert-success');
                            window.location.href = data.redirect;
                        }, 3000);
                    });
                }
                if (data.status == 'error'){
                    roleDeleteAlertMsgs.forEach(function(alertMsg) {
                        alertMsg.classList.remove('d-none');
                        alertMsg.classList.add('alert-danger');
                        alertMsg.innerHTML = data.message;
                        setTimeout(function() {
                            alertMsg.classList.add('d-none');
                            alertMsg.classList.remove('alert-danger');
                            alertMsg.innerHTML = '';
                        }, 3000);
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown, jqXHR);
                roleDeleteAlertMsgs.forEach(function(alertMsg) {
                    alertMsg.classList.remove('d-none');
                    alertMsg.classList.add('alert-danger');
                    alertMsg.innerHTML = 'Error: ' + textStatus;
                    setTimeout(function() {
                        alertMsg.classList.add('d-none');
                        alertMsg.classList.remove('alert-danger');
                        alertMsg.innerHTML = '';
                    }, 3000);
                });
            }
        });
    });
});
