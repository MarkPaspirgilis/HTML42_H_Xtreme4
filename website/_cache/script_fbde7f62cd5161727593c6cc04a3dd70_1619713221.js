function wait_for_jquery() {
    if (typeof window.jQuery != 'undefined' && typeof window.$ != 'undefined') {
        __jquery_loaded = true;
        for (var i in _wait_for_jquery) {
            if (typeof _wait_for_jquery[i] == 'function') {
                _wait_for_jquery[i]();
            }
        }
    } else {
        setTimeout(wait_for_jquery, 10);
    }
}
function after_jquery(func) {
    if (typeof func == 'function') {
        if (__jquery_loaded) {
            func();
        } else {
            _wait_for_jquery.push(func);
        }
    }
}
var _wait_for_jquery = [];
var _jquery_loaded = false;
setTimeout(wait_for_jquery, 10);
after_jquery(function() {
    console.log('X4 Admin');
});