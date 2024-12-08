<script>
    document.cookie = 'sw-cache=true; Max-Age=10; Path=/';
    setTimeout(() => {
        window.stop();
        let url = location.href;
        if (url.indexOf('?') === -1) {
            url = url + '?';
        } else {
            url = url + '&';
        }
        url = url + 'sw_by_pass=true';
        location.reload();
    }, 5000);
    navigator.serviceWorker.addEventListener('message', function(event) {
        if (!event.data) return;
        if (event.data.action === 'refresh') {
            window.stop();
            location.reload();
        }
    });
</script>
