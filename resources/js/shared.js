setTimeout(function () {
    $(".alert").alert("close");
}, 3000);

function resetForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return;
    $(form).find('.is-invalid').removeClass('is-invalid');
    $(form).find('.text-danger').remove();
    form.reset();
}