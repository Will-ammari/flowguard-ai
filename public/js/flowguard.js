(function () {
    function bindConfirmForms() {
        var forms = document.querySelectorAll('[data-confirm]');

        forms.forEach(function (form) {
            form.addEventListener('submit', function (event) {
                var message = form.getAttribute('data-confirm') || 'Are you sure?';

                if (!window.confirm(message)) {
                    event.preventDefault();
                }
            });
        });
    }

    function bindAutoDismissAlerts() {
        var alerts = document.querySelectorAll('[data-auto-dismiss]');

        alerts.forEach(function (alert) {
            var delay = parseInt(alert.getAttribute('data-auto-dismiss'), 10) || 4000;

            window.setTimeout(function () {
                alert.classList.add('fade');

                window.setTimeout(function () {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 300);
            }, delay);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        bindConfirmForms();
        bindAutoDismissAlerts();
    });
})();