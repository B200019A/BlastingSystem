function submitForm(btn) {
    // disable the button
    btn.disabled = true;
    // submit the form    
    btn.form.submit();
    console.log("clicked")
}