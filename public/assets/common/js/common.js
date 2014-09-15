$(function () {
    // We set new regex for blueimp templating (to not interfer with volt syntax)
    tmpl.regexp = /([\s'\\])(?!(?:[^[]|\[(?!%))*%\])|(?:\[%(=|#)([\s\S]+?)%\])|(\[%)|(%\])/g;
});