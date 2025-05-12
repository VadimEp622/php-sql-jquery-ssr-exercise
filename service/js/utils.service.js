function flash_timeout_remove() {
    const interval = $("#flash_message").attr("data-timeout");

    setTimeout(() => {
        $("#flash_message").alert('close');
    }, interval);

}