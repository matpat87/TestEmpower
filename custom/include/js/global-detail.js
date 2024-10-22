jQuery( () => {
    handleF2RedirectToEditView();
});

// Arrow function not working if module is AJAX enabled, had to use older way of declaring functions for it work
// Arrow function example: const handleF2RedirectToEditView = () => {}
function handleF2RedirectToEditView() {
    let moduleName = $("form#formDetailView > input[name='module'][type='hidden']").val();
    let recordId = $("input[name='record'][type='hidden']").val();

    window.onkeydown = (e) => {  
        if (e.keyCode === 113) {
            e.preventDefault();
            window.location.href = `/index.php?module=${moduleName}&action=EditView&record=${recordId}`;
        }
    };
}
