if (document.addEventListener) { document.addEventListener('DOMContentLoaded', function() {
    Array.forEach(document.getElementById('menu').getElementsByTagName('a'), function(link) {
        if (link.href === window.location.href) {
            link.className = link.className + ' selected';
        }
    });
}, false); }