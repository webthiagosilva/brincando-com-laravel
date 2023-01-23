function applyCpfMask(event) {
    if (event.key.match(/[a-zA-Z]/)) {
        event.preventDefault();
        return;
    }

    var eventValue = event.target.value;

    eventValue = eventValue.replace(/\D/g, '');
    eventValue = eventValue.replace(/(\d{3})(\d)/, "$1.$2");
    eventValue = eventValue.replace(/(\d{3})(\d)/, "$1.$2");
    eventValue = eventValue.replace(/(\d{3})(\d{1,2})$/, "$1-$2");

    event.target.value = eventValue;
};

function capitalize(input) {
    var inputValue = input.value;

    if (/\d/.test(inputValue)) {
        input.value = inputValue.replace(/\d/g, "");
        return;
    }

    input.value = inputValue.replace(/\b(da|de|do|das|dos)\b/gi, function (f) { return f.toLowerCase(); })
        .replace(/(^|\s)\p{L}/gu, function (f) { return f.toUpperCase(); });
}
